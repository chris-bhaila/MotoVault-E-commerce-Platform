import numpy as np
import json
import sys

# Load precomputed embeddings and products
products_file = 'products.json'
embeddings_file = 'product_embeddings.npy'

with open(products_file, 'r', encoding='utf-8') as f:
    products = json.load(f)

corpus_embeddings = np.load(embeddings_file)  # shape: (num_products, embedding_dim)

# Map product_id to index
id_to_index = {p['product_id']: i for i, p in enumerate(products)}

# Load user purchase history
# Example: precomputed or fetched from DB, just product_ids list
def load_user_history(user_id):
    # Replace with DB query if needed
    import mysql.connector
    conn = mysql.connector.connect(
        host='localhost',
        user='root',
        password='',
        database='motovault'
    )
    cursor = conn.cursor(dictionary=True)
    cursor.execute("SELECT product_id FROM c_orders WHERE user_id = %s", (user_id,))
    purchased = [row['product_id'] for row in cursor.fetchall()]
    cursor.close()
    conn.close()
    return purchased

# Compute cosine similarity using NumPy
def cosine_similarity(a, b):
    # a: (embedding_dim,) b: (num_products, embedding_dim)
    a_norm = np.linalg.norm(a)
    b_norm = np.linalg.norm(b, axis=1)
    return np.dot(b, a) / (b_norm * a_norm + 1e-8)

# Hybrid recommendation
def get_hybrid_recommendations(product_id, user_id, top_k=10):
    if product_id not in id_to_index:
        return []

    target_idx = id_to_index[product_id]
    target_embedding = corpus_embeddings[target_idx]

    # Similarity to target product
    product_cos_scores = cosine_similarity(target_embedding, corpus_embeddings)

    # Similarity to purchased products
    purchased_ids = load_user_history(user_id)
    purchase_cos_scores = np.zeros(len(products))
    if purchased_ids:
        purchased_indices = [id_to_index[pid] for pid in purchased_ids if pid in id_to_index]
        if purchased_indices:
            purchased_embeddings = corpus_embeddings[purchased_indices]
            purchase_cos_scores = cosine_similarity(purchased_embeddings.mean(axis=0), corpus_embeddings)

    # Weighted combination (more weight to user history if available)
    alpha = 0.7 if purchased_ids else 0.0
    combined_scores = alpha * purchase_cos_scores + (1 - alpha) * product_cos_scores

    # Build results excluding current product & already purchased
    results = []
    for idx, p in enumerate(products):
        if p['product_id'] != product_id and p['product_id'] not in purchased_ids:
            results.append({
                'product_id': p['product_id'],
                'name': p['name'],
                'score': float(combined_scores[idx])
            })

    results = sorted(results, key=lambda x: x['score'], reverse=True)
    return results[:top_k]

# CLI
if __name__ == "__main__":
    if len(sys.argv) < 3:
        print(json.dumps([]))
        sys.exit(1)

    try:
        product_id = int(sys.argv[1])
        user_id = int(sys.argv[2])
        recommendations = get_hybrid_recommendations(product_id, user_id, top_k=10)
        print(json.dumps(recommendations))
    except Exception as e:
        print(json.dumps([]))
