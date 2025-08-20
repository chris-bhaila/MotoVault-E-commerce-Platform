import mysql.connector
from sentence_transformers import SentenceTransformer
import numpy as np
import json

# Load model
model = SentenceTransformer('all-MiniLM-L6-v2')

# Connect to DB and load products
conn = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',  # your DB password
    database='motovault'
)
cursor = conn.cursor(dictionary=True)
cursor.execute("SELECT product_id, name, description, features FROM motoproducts")
products = cursor.fetchall()
cursor.close()
conn.close()

# Save products info
with open("products.json", "w") as f:
    json.dump(products, f)

# Compute embeddings
corpus = [
    f"Name: {p['name']}. "
    f"Description: {p.get('description', '')}. "
    f"Features: {p.get('features')}"
    for p in products
]
embeddings = model.encode(corpus, convert_to_numpy=True)
np.save("product_embeddings.npy", embeddings)

print("Precomputed embeddings saved!")
