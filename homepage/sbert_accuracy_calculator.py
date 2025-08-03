import mysql.connector
from sentence_transformers import SentenceTransformer, util
import numpy as np
from collections import defaultdict
from sklearn.metrics import ndcg_score

# === 1. Connect to your MySQL database ===
connection = mysql.connector.connect(
    host="localhost",       # or your DB host
    user="root",            # your username
    password="",            # your password
    database="motovault"    # your database name
)

cursor = connection.cursor()

# === 2. Fetch product_id, name, tags, sub_cat_id (adjust 'sub_cat_id' if needed) ===
cursor.execute("SELECT product_id, name, tags, sub_cat_fid FROM motoproducts WHERE tags IS NOT NULL")
rows = cursor.fetchall()

# === 3. Build product dictionary and subcategory mapping ===
products = {row[0]: f"{row[1]} | {row[2]}" for row in rows}
subcat_map = defaultdict(list)
for row in rows:
    product_id = row[0]
    sub_cat_fid = row[3]
    subcat_map[sub_cat_fid].append(product_id)

cursor.close()
connection.close()

print(f"✅ Loaded {len(products)} products.")

# === 4. Build ground truth: products in the same subcategory are relevant ===
ground_truth = {}
for pid in products:
    for subcat_id, pid_list in subcat_map.items():
        if pid in pid_list:
            ground_truth[pid] = [other for other in pid_list if other != pid]
            break

print(f"✅ Generated ground truth for {len(ground_truth)} queries.")

# === 5. SBERT encoding ===
model = SentenceTransformer('all-MiniLM-L6-v2')
product_ids = list(products.keys())
product_texts = list(products.values())

embeddings = model.encode(product_texts, convert_to_tensor=True)
product_id_to_embedding = dict(zip(product_ids, embeddings))

# === 6. Evaluation ===
K = 5
precision_list = []
recall_list = []

all_true_relevance = []
all_scores = []

for query_id, relevant_ids in ground_truth.items():
    if query_id not in product_id_to_embedding:
        continue

    query_embedding = product_id_to_embedding[query_id]
    similarities = util.pytorch_cos_sim(query_embedding, embeddings)[0].cpu().numpy()

    # Ignore self-similarity
    query_index = product_ids.index(query_id)
    similarities[query_index] = -1.0

    # Top-K recommended product indices and IDs
    top_k_indices = np.argpartition(-similarities, range(K))[:K]
    top_k_ids = [product_ids[i] for i in top_k_indices]

    # Precision@K
    hits = sum(1 for pid in top_k_ids if pid in relevant_ids)
    precision = hits / K
    precision_list.append(precision)

    # Recall@K
    recall = hits / len(relevant_ids) if relevant_ids else 0
    recall_list.append(recall)

    # Build relevance vectors for NDCG
    true_relevance = [1 if pid in relevant_ids else 0 for pid in product_ids]
    all_true_relevance.append(true_relevance)
    all_scores.append(similarities.tolist())

# Average metrics
avg_precision = np.mean(precision_list)
avg_recall = np.mean(recall_list)
average_ndcg = np.mean([ndcg_score([true], [score], k=K) for true, score in zip(all_true_relevance, all_scores)])

print("\n--- 🧠 SBERT Product Recommendation Evaluation ---")
print(f"Evaluated Top-{K} recommendations for {len(ground_truth)} products.")
print(f"Average Precision@{K}: {avg_precision:.4f}")
print(f"Average Recall@{K}: {avg_recall:.4f}")
print(f"NDCG@{K}: {average_ndcg:.4f}")
