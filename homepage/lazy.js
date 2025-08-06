document.addEventListener('DOMContentLoaded', function() {
    // Initialize event listeners
    initAddToCart();
    initReviewSubmit();
    loadRecommendations();
    updateCartCount();
});

function initAddToCart() {
    document.getElementById('productForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                updateCartCount();
                Swal.fire({
                    title: 'Added to cart!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });
}

function initReviewSubmit() {
    document.querySelector('.make-rev')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'review_success') {
                Swal.fire({
                    title: 'Review submitted!',
                    icon: 'success'
                }).then(() => {
                    window.location.reload();
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });
}

function loadRecommendations() {
    const container = document.getElementById('recommendations-container');
    if (!container) return;

    const productId = new URLSearchParams(window.location.search).get('id');
    if (!productId) return;

    fetch(`get_recommendations.php?id=${productId}`)
        .then(response => response.json())
        .then(products => {
            if (!products || products.error) {
                container.innerHTML = products?.error ? `<p>${products.error}</p>` : '';
                return;
            }

            let html = `
                <div class="recommended-products-container">
                    <h2>Recommended Products</h2>
                    <div class="recommended-products-scroller">
            `;

            products.forEach(product => {
                const stockStatus = product.stock <= 0 ? 'Out of Stock' : 
                                  (product.stock < 5 ? 'Limited Stock' : '');
                const stockClass = product.stock <= 0 ? 'out' : 
                                  (product.stock < 5 ? 'limited' : '');

                html += `
                    <div class="recommended-product-card">
                        <a href="productPage.php?id=${product.id}">
                            <img src="../admin/products/${product.image}" 
                                 alt="${product.name}"
                                 class="product-image"
                                 loading="lazy">
                            <div class="product-details">
                                <div class="product-name">${product.name}</div>
                                <div class="product-price">Rs. ${product.price.toLocaleString()}</div>
                                <div class="similarity-score">Similarity: ${product.score}%</div>
                                ${stockStatus ? `<div class="stock-status ${stockClass}">${stockStatus}</div>` : ''}
                            </div>
                        </a>
                    </div>
                `;
            });

            html += `</div></div>`;
            container.innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading recommendations:', error);
        });
}

function updateCartCount() {
    fetch('get_cart_count.php')
        .then(response => response.json())
        .then(data => {
            document.querySelectorAll('.cart-count').forEach(el => {
                el.textContent = data.count || 0;
                el.style.display = (data.count > 0) ? 'inline-block' : 'none';
            });
        })
        .catch(error => console.error('Error updating cart count:', error));
}