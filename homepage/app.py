# ---------------- improved_app.py ----------------
import sys
import json
import traceback
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import re
import numpy as np

# More targeted stopwords for product descriptions
stop_words = set([
    'the', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 
    'by', 'from', 'this', 'that', 'these', 'those', 'a', 'an', 'is', 'are', 
    'was', 'were', 'be', 'been', 'being', 'have', 'has', 'had', 'do', 'does', 
    'did', 'will', 'would', 'could', 'should'
])

def preprocess(text):
    """Enhanced preprocessing that preserves important product information"""
    if not text or text.strip() == '':
        return ''
    
    text = text.lower()
    # Keep alphanumeric, spaces, and some punctuation that might be meaningful
    text = re.sub(r'[^\w\s-]', ' ', text)
    # Replace multiple spaces with single space
    text = re.sub(r'\s+', ' ', text)
    
    words = text.split()
    # Filter stopwords but keep important terms
    words = [w for w in words if w not in stop_words and len(w) > 1]
    
    return ' '.join(words)

def calculate_enhanced_similarity(texts, target_index):
    """Calculate similarity using multiple methods and combine them"""
    
    # Method 1: Standard TF-IDF with relaxed parameters
    vectorizer1 = TfidfVectorizer(
        ngram_range=(1, 2),
        min_df=1,  # Allow terms that appear in just 1 document
        max_df=0.95,  # More lenient max frequency
        sublinear_tf=True,
        max_features=1000  # Limit features to avoid noise
    )
    
    try:
        tfidf_matrix1 = vectorizer1.fit_transform(texts)
        similarities1 = cosine_similarity(tfidf_matrix1[target_index], tfidf_matrix1).flatten()
    except:
        similarities1 = np.zeros(len(texts))
    
    # Method 2: Character-level n-grams for catching similar product codes/names
    vectorizer2 = TfidfVectorizer(
        analyzer='char_wb',
        ngram_range=(2, 4),
        min_df=1,
        max_df=0.95,
        max_features=500
    )
    
    try:
        tfidf_matrix2 = vectorizer2.fit_transform(texts)
        similarities2 = cosine_similarity(tfidf_matrix2[target_index], tfidf_matrix2).flatten()
    except:
        similarities2 = np.zeros(len(texts))
    
    # Method 3: Word-level with higher n-grams for phrase matching
    vectorizer3 = TfidfVectorizer(
        ngram_range=(1, 3),
        min_df=1,
        max_df=0.98,
        sublinear_tf=False,
        max_features=800
    )
    
    try:
        tfidf_matrix3 = vectorizer3.fit_transform(texts)
        similarities3 = cosine_similarity(tfidf_matrix3[target_index], tfidf_matrix3).flatten()
    except:
        similarities3 = np.zeros(len(texts))
    
    # Combine similarities with weights
    combined_similarities = (0.5 * similarities1 + 0.3 * similarities2 + 0.2 * similarities3)
    
    return combined_similarities

try:
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
    target_id = int(data.get('target_id', 0))

    if not products:
        print(json.dumps({"error": "No products provided"}), flush=True)
        sys.exit(1)

    if target_id <= 0:
        print(json.dumps({"error": "Invalid target ID provided"}), flush=True)
        sys.exit(1)

    # Build text corpus with enhanced preprocessing
    id_to_text = {}
    for p in products:
        text = p.get('vector', '').strip()
        if text:  # Only include products with non-empty text
            id_to_text[int(p['id'])] = text

    product_ids = list(id_to_text.keys())

    if target_id not in product_ids:
        print(json.dumps({"error": f"Target ID {target_id} not found in products"}), flush=True)
        sys.exit(1)

    if len(product_ids) < 2:
        print(json.dumps({"error": "Need at least 2 products for comparison"}), flush=True)
        sys.exit(1)

    # Preprocess all texts
    corpus = [preprocess(id_to_text[pid]) for pid in product_ids]
    
    # Filter out empty texts after preprocessing
    valid_indices = [i for i, text in enumerate(corpus) if text.strip()]
    if len(valid_indices) < 2:
        print(json.dumps({"error": "Not enough valid product descriptions after preprocessing"}), flush=True)
        sys.exit(1)
    
    # Update corpus and product_ids to only include valid entries
    corpus = [corpus[i] for i in valid_indices]
    product_ids = [product_ids[i] for i in valid_indices]
    
    # Check if target is still in the valid set
    if target_id not in product_ids:
        print(json.dumps({"error": f"Target product has empty description after preprocessing"}), flush=True)
        sys.exit(1)

    try:
        target_index = product_ids.index(target_id)
        similarities = calculate_enhanced_similarity(corpus, target_index)

        # Create scored results
        scored = list(zip(product_ids, similarities))
        scored = sorted(scored, key=lambda x: x[1], reverse=True)

        # Use adaptive threshold based on score distribution
        scores = [score for _, score in scored if _ != target_id]
        if scores:
            mean_score = np.mean(scores)
            std_score = np.std(scores)
            adaptive_threshold = max(0.01, mean_score - std_score)  # Lower minimum threshold
        else:
            adaptive_threshold = 0.3

        result = []
        for pid, score in scored:
            if pid != target_id and score >= adaptive_threshold:
                result.append({"product_id": int(pid), "similarity": round(float(score), 4)})
            if len(result) == 6:  # Get more recommendations
                break

        # If still no results, take top 5 regardless of score
        if not result:
            result = []
            for pid, score in scored:
                if pid != target_id:
                    result.append({"product_id": int(pid), "similarity": round(float(score), 4)})
                if len(result) == 5:
                    break

        print(json.dumps(result), flush=True)

    except Exception as calc_error:
        # Enhanced fallback: try simple keyword matching
        target_text = preprocess(id_to_text[target_id]).split()
        fallback_scores = []
        
        for pid in product_ids:
            if pid == target_id:
                continue
            other_text = preprocess(id_to_text[pid]).split()
            # Simple word overlap score
            if target_text and other_text:
                overlap = len(set(target_text) & set(other_text))
                total_unique = len(set(target_text) | set(other_text))
                score = overlap / total_unique if total_unique > 0 else 0
            else:
                score = 0
            fallback_scores.append((pid, score))
        
        fallback_scores.sort(key=lambda x: x[1], reverse=True)
        result = [{"product_id": int(pid), "similarity": round(float(score), 4)} 
                 for pid, score in fallback_scores[:5]]
        
        print(json.dumps(result), flush=True)

except Exception as e:
    error_info = {
        "error": str(e),
        "traceback": traceback.format_exc(),
        "argv": sys.argv
    }
    print(json.dumps(error_info), flush=True)
    sys.exit(1)