import mysql.connector
from sentence_transformers import SentenceTransformer, util
import numpy as np
import json
import sys

# Load the SBERT model
model = SentenceTransformer('all-MiniLM-L6-v2')  # You can use another if you want

# Connect to your MySQL database
def get_connection():
    return mysql.connector.connect(
        host='localhost',
        user='root',
        password='',  # use your DB password
        database='motovault'
    )

# Load product data
def load_products():
    conn = get_connection()
    cursor = conn.cursor(dictionary=True)
    cursor.execute("SELECT product_id, name, tags FROM motoproducts")
    products = cursor.fetchall()
    cursor.close()
    conn.close()
    return products

# Find similar products using SBERT
def get_similar_products(target_id, top_k=10):
    products = load_products()

    id_to_product = {p['product_id']: p for p in products}
    if target_id not in id_to_product:
        return []

    # Prepare text embeddings (name + tags)
    corpus = [f"{p['name']} {p['tags']}" for p in products]
    corpus_embeddings = model.encode(corpus, convert_to_tensor=True)

    # Get embedding for target product
    target_index = next(i for i, p in enumerate(products) if p['product_id'] == target_id)
    target_embedding = corpus_embeddings[target_index]

    # Compute cosine similarity
    cos_scores = util.cos_sim(target_embedding, corpus_embeddings)[0]

    # Get top-k similar excluding the target itself
    top_results = np.argpartition(-cos_scores, range(top_k + 1))[0:top_k + 1]
    results = []

    for idx in top_results:
        pid = products[idx]['product_id']
        if pid != target_id:
            results.append({
                'product_id': pid,
                'name': products[idx]['name'],
                'score': float(cos_scores[idx])
            })

    # Sort by score
    results = sorted(results, key=lambda x: x['score'], reverse=True)
    return results[:top_k]

# CLI interface
if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(json.dumps([]))
        sys.exit(1)

    try:
        target = int(sys.argv[1])
        recommendations = get_similar_products(target, top_k=10)
        print(json.dumps(recommendations))
    except Exception as e:
        print(json.dumps([]))