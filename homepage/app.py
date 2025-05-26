import sys
import json
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

# Read input JSON from PHP
data = json.loads(sys.argv[1])
products = data['products']
target_id = data['target_id']

id_to_text = {p['id']: p['vector'] for p in products}
product_ids = list(id_to_text.keys())
corpus = [id_to_text[pid] for pid in product_ids]

# TF-IDF and cosine similarity
vectorizer = TfidfVectorizer()
tfidf_matrix = vectorizer.fit_transform(corpus)
target_index = product_ids.index(target_id)
similarities = cosine_similarity(tfidf_matrix[target_index], tfidf_matrix).flatten()

# Sort and exclude target
scored = list(zip(product_ids, similarities))
scored = sorted(scored, key=lambda x: x[1], reverse=True)
top_ids = [pid for pid, score in scored if pid != target_id][:5]

# Print JSON to stdout for PHP
print(json.dumps(top_ids))
