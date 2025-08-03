<?php
include "../dbconn.php"; 
session_start();
if(!isset($_SESSION['UID'])) {
    header('location: ../SignIn.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Browse Products</title>
    <link rel="stylesheet" href="../mainFont.css" />
    <link rel="stylesheet" href="css/browse.css" />
</head>
<body>
    <?php
    include("../header1.php");
    include('floatingCart.php');
    ?>

    <div class="main-container">

        <!-- New Arrivals Section -->
        <div class="new-products">
            <h1>New Arrivals</h1>
            <div class="product-info" id="new-products-info">
                <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `motoproducts` ORDER BY `timestamp` DESC LIMIT 3") or die('Query failed.');
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                ?>
                        <a href="productPage.php?id=<?php echo $fetch_product['product_id']; ?>" class="product">
                            <img src="../admin/products/<?php echo htmlspecialchars($fetch_product['image']); ?>" alt="<?php echo htmlspecialchars($fetch_product['name']); ?>" class="image" />
                            <div class="box">
                                <div class="name"><?php echo htmlspecialchars($fetch_product['name']); ?></div>
                            </div>
                            <div class="price">
                                <?php if ($fetch_product['stock'] > 0) { ?>
                                    NPR <?php echo number_format($fetch_product['price']); ?>
                                <?php } else { ?>
                                    <span class="out-of-stock" style="color: grey;">Out of Stock</span>
                                <?php } ?>
                            </div>
                            <?php if ($fetch_product['stock'] <= 5 && $fetch_product['stock'] > 0) { ?>
                                <div class="l-stock">Limited Stock</div>
                            <?php } ?>
                        </a>
                <?php
                    }
                }
                ?>
            </div>
        </div>

        <!-- All Products Section -->
        <div class="all-products">
            <h1>All Products</h1>
            <div class="product-info" id="all-products-info">
                <!-- Products loaded here by JS -->
            </div>
            <button id="load-more">Load More</button>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let offset = 0;
        const limit = 20;
        const container = document.getElementById('all-products-info');
        const loadMoreBtn = document.getElementById('load-more');

        function loadProducts() {
            fetch(`load_products.php?limit=${limit}&offset=${offset}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        loadMoreBtn.style.display = 'none';
                        return;
                    }

                    data.forEach(product => {
                        const productLink = document.createElement('a');
                        productLink.href = `productPage.php?id=${product.product_id}`;
                        productLink.className = 'product';

                        productLink.innerHTML = `
                            <img src="../admin/products/${product.image}" alt="${product.name}" class="image" />
                            <div class="box">
                                <div class="name">${product.name}</div>
                            </div>
                            <div class="price">
                                ${product.stock > 0 ? `NPR ${parseInt(product.price).toLocaleString()}` : `<span class="out-of-stock" style="color: grey;">Out of Stock</span>`}
                            </div>
                            ${product.stock > 0 && product.stock <= 5 ? `<div class="l-stock">Limited Stock</div>` : ''}
                        `;

                        container.appendChild(productLink);
                    });

                    offset += limit;
                })
                .catch(error => {
                    console.error("Error loading products:", error);
                });
        }

        loadMoreBtn.addEventListener('click', loadProducts);
        loadProducts(); // Load first batch on page load
    });
    </script>
</body>
</html>
