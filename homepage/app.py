import sys
import json
import traceback
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

try:
    # Read JSON from temporary file instead of command line argument
    if len(sys.argv) < 2:
        print(json.dumps({"error": "No input file provided"}), flush=True)
        sys.exit(1)
    
    temp_file_path = sys.argv[1]
    
    try:
        with open(temp_file_path, 'r', encoding='utf-8') as f:
            data = json.load(f)
    except FileNotFoundError:
        print(json.dumps({"error": f"Input file not found: {temp_file_path}"}), flush=True)
        sys.exit(1)
    except json.JSONDecodeError as je:
        print(json.dumps({"error": f"Invalid JSON in file: {str(je)}"}), flush=True)
        sys.exit(1)
    
    products = data.get('products', [])
    target_id = int(data.get('target_id', 0))  # Ensure target_id is integer
    
    if not products:
        print(json.dumps({"error": "No products provided"}), flush=True)
        sys.exit(1)
    
    if target_id <= 0:
        print(json.dumps({"error": "Invalid target ID provided"}), flush=True)
        sys.exit(1)
    
    # Create mappings - ensure IDs are integers
    id_to_text = {}
    for p in products:
        pid = int(p['id'])
        vector_text = p.get('vector', '').strip()
        if vector_text:
            id_to_text[pid] = vector_text
    
    product_ids = list(id_to_text.keys())
    
    if target_id not in product_ids:
        print(json.dumps({"error": f"Target ID {target_id} not found in products"}), flush=True)
        sys.exit(1)
    
    if len(product_ids) < 2:
        print(json.dumps({"error": "Need at least 2 products for comparison"}), flush=True)
        sys.exit(1)
    
    corpus = [id_to_text[pid] for pid in product_ids]
    
    # TF-IDF and cosine similarity
    try:
        vectorizer = TfidfVectorizer(
            stop_words='english',  # Remove common English words
            min_df=1,  # Include terms that appear in at least 1 document
            max_df=1.0,  # Include all terms
            ngram_range=(1, 2),  # Include both single words and bigrams
            lowercase=True,
            strip_accents='ascii'
        )
        
        tfidf_matrix = vectorizer.fit_transform(corpus)
        target_index = product_ids.index(target_id)
        
        similarities = cosine_similarity(tfidf_matrix[target_index], tfidf_matrix).flatten()
        
        # Sort and exclude target
        scored = list(zip(product_ids, similarities))
        scored = sorted(scored, key=lambda x: x[1], reverse=True)
        
        # Lower threshold if no results
        threshold = 0.05  # Very low threshold
        top_ids = [int(pid) for pid, score in scored if pid != target_id and score >= threshold][:5]
        
        # If still no results, return top 5 regardless of threshold
        if not top_ids:
            top_ids = [int(pid) for pid, score in scored if pid != target_id][:5]
        
        # Ensure all IDs are integers and print as clean JSON array
        result = [int(id) for id in top_ids if isinstance(id, (int, float)) and id > 0]
        print(json.dumps(result), flush=True)
        
    except Exception as vectorizer_error:
        # If TF-IDF fails, return random similar products
        other_ids = [int(pid) for pid in product_ids if pid != target_id][:5]
        print(json.dumps(other_ids), flush=True)
    
except Exception as e:
    error_info = {
        "error": str(e),
        "traceback": traceback.format_exc(),
        "argv": sys.argv
    }
    print(json.dumps(error_info), flush=True)
    sys.exit(1)