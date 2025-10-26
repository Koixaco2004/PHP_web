"""
Toxic Comment Classifier API
Model: vanhai123/phobert-vi-comment-4class
"""

from flask import Flask, request, jsonify
from transformers import pipeline
import logging

# Setup logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

app = Flask(__name__)

# Load model once when server starts
logger.info("Loading model: vanhai123/phobert-vi-comment-4class")
try:
    classifier = pipeline(
        "text-classification",
        model="vanhai123/phobert-vi-comment-4class"
    )
    logger.info("Model loaded successfully!")
except Exception as e:
    logger.error(f"Failed to load model: {e}")
    classifier = None


@app.route('/health', methods=['GET'])
def health():
    """Health check endpoint"""
    return jsonify({
        'status': 'ok',
        'model_loaded': classifier is not None
    })


@app.route('/classify', methods=['POST'])
def classify():
    """
    Classify comment toxicity
    
    Request body:
    {
        "text": "Đồ khốn nạn!"
    }
    
    Response:
    {
        "success": true,
        "text": "Đồ khốn nạn!",
        "label": "toxic",
        "score": 0.95,
        "is_toxic": true,
        "all_scores": [...]
    }
    """
    if classifier is None:
        return jsonify({
            'success': False,
            'error': 'Model not loaded'
        }), 500
    
    try:
        # Get text from request
        data = request.get_json()
        
        if not data or 'text' not in data:
            return jsonify({
                'success': False,
                'error': 'Missing "text" field in request body'
            }), 400
        
        text = data['text']
        
        if not text or not text.strip():
            return jsonify({
                'success': False,
                'error': 'Text cannot be empty'
            }), 400
        
        # Classify the text
        result = classifier(text, top_k=None)  # Get all scores
        
        # Get top prediction
        top_prediction = result[0]
        label = top_prediction['label']
        score = top_prediction['score']
        
        # Check if toxic
        # Model returns: LABEL_0 (positive), LABEL_1 (negative), LABEL_2 (neutral), LABEL_3 (toxic)
        is_toxic = label == 'LABEL_3'
        
        # Convert label to readable format
        label_map = {
            'LABEL_0': 'positive',
            'LABEL_1': 'negative', 
            'LABEL_2': 'neutral',
            'LABEL_3': 'toxic'
        }
        readable_label = label_map.get(label, label)
        
        logger.info(f"Classified: '{text[:50]}...' -> {readable_label} ({score:.4f})")
        
        return jsonify({
            'success': True,
            'text': text,
            'label': readable_label,
            'score': float(score),
            'is_toxic': is_toxic,
            'all_scores': [
                {'label': label_map.get(pred['label'], pred['label']), 'score': float(pred['score'])}
                for pred in result
            ]
        })
        
    except Exception as e:
        logger.error(f"Error during classification: {e}")
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500


@app.route('/batch-classify', methods=['POST'])
def batch_classify():
    """
    Classify multiple comments at once
    
    Request body:
    {
        "texts": ["comment 1", "comment 2", ...]
    }
    """
    if classifier is None:
        return jsonify({
            'success': False,
            'error': 'Model not loaded'
        }), 500
    
    try:
        data = request.get_json()
        
        if not data or 'texts' not in data:
            return jsonify({
                'success': False,
                'error': 'Missing "texts" field in request body'
            }), 400
        
        texts = data['texts']
        
        if not isinstance(texts, list):
            return jsonify({
                'success': False,
                'error': '"texts" must be an array'
            }), 400
        
        # Classify all texts
        results = []
        for text in texts:
            if text and text.strip():
                result = classifier(text, top_k=None)
                top_prediction = result[0]
                
                results.append({
                    'text': text,
                    'label': top_prediction['label'],
                    'score': float(top_prediction['score']),
                    'is_toxic': top_prediction['label'].lower() == 'toxic'
                })
        
        return jsonify({
            'success': True,
            'results': results
        })
        
    except Exception as e:
        logger.error(f"Error during batch classification: {e}")
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500


if __name__ == '__main__':
    print("=" * 60)
    print("🚀 Toxic Comment Classifier API")
    print("=" * 60)
    print(f"Model: vanhai123/phobert-vi-comment-4class")
    print(f"Endpoints:")
    print(f"  - GET  /health         : Health check")
    print(f"  - POST /classify       : Classify single comment")
    print(f"  - POST /batch-classify : Classify multiple comments")
    print("=" * 60)
    print(f"Starting server on http://127.0.0.1:5000")
    print("=" * 60)
    
    app.run(host='127.0.0.1', port=5000, debug=False)
