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
    <link rel="stylesheet" href="../mainFont2.css" />
    <link rel="stylesheet" href="css/browse.css" />
</head>
<body>
    <header style="font-family: 'Oswald','sans-serif';">
    <?php
    include("../header1.php");
    ?>
    </header>
    <?php
    include('floatingCart.php');
    ?>

    <div class="main-container" style="font-family: 'Monsterrat','sans-serif';">

        <!-- New Arrivals Section -->
        <div class="new-products">
            <h1>New Arrivals</h1>
            <div class="product-info" id="new-products-info">
                <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `motoproducts` ORDER BY `timestamp` DESC LIMIT 8") or die('Query failed.');
                    if (mysqli_num_rows($select_product) > 0) {
                        while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                    ?>
                            <a href="productPage.php?id=<?php echo $fetch_product['product_id']; ?>" class="product" style="position: relative;">
                            
                                <?php if (!empty($fetch_product['discount_percent']) && $fetch_product['discount_percent'] > 0) { ?>
                                    <div style="position: absolute; top: 8px; right: 8px; background-color: red; color: white; padding: 4px 8px; font-size: 12px; font-weight: bold; border-radius: 5px; z-index: 5;">
                                        -<?php echo $fetch_product['discount_percent']; ?>% off
                                    </div>
                                <?php } ?>

                                <img src="../admin/products/<?php echo htmlspecialchars($fetch_product['image']); ?>"
                                    alt="<?php echo htmlspecialchars($fetch_product['name']); ?>" class="image" style="object-fit: contain;"/>

                                <div class="box">
                                    <div class="name" style="color: black;"><?php echo htmlspecialchars($fetch_product['name']); ?></div>
                                </div>

                                <div class="price">
                                    <?php if ($fetch_product['stock'] > 0) { ?>
                                        NPR <?php echo number_format($fetch_product['price']); ?>
                                    <?php } else { ?>
                                        <span class="out-of-stock" style="color: grey;">Out of Stock</span>
                                    <?php } ?>
                                </div>

                                <?php if ($fetch_product['stock'] <= 5 && $fetch_product['stock'] > 0) { ?>
                                    <div class="l-stock" style="color: red; font-weight: bold;">Limited Stock</div>
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
    <div class="search-box">
        <form action="">
            <textarea name="search" id="searchInput" class="search" placeholder="Search in MotoVault"></textarea>
            <!-- Search results will appear here -->
            <div id="searchResults" class="search-results"></div>
        </form>
    </div>
    <div class="product-info" id="all-products-info">
        <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `motoproducts`") or die('Query failed.');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <a href="productPage.php?id=<?php echo $fetch_product['product_id']; ?>" class="product" style="position: relative;" data-name="<?php echo htmlspecialchars($fetch_product['name']); ?>" data-description="<?php echo htmlspecialchars($fetch_product['description']); ?>">
                    
                        <?php if (!empty($fetch_product['discount_percent']) && $fetch_product['discount_percent'] > 0) { ?>
                            <div style="position: absolute; top: 8px; right: 8px; background-color: red; color: white; padding: 4px 8px; font-size: 12px; font-weight: bold; border-radius: 5px; z-index: 5;">
                                -<?php echo $fetch_product['discount_percent']; ?>% off
                            </div>
                        <?php } ?>

                        <img src="../admin/products/<?php echo htmlspecialchars($fetch_product['image']); ?>"
                            alt="<?php echo htmlspecialchars($fetch_product['name']); ?>" class="image" />

                        <div class="box">
                            <div class="name" style="color: black;"><?php echo htmlspecialchars($fetch_product['name']); ?></div>
                        </div>

                        <div class="price">
                            <?php if ($fetch_product['stock'] > 0) { ?>
                                NPR <?php echo number_format($fetch_product['price']); ?>
                            <?php } else { ?>
                                <span class="out-of-stock" style="color: grey;">Out of Stock</span>
                            <?php } ?>
                        </div>

                        <?php if ($fetch_product['stock'] <= 5 && $fetch_product['stock'] > 0) { ?>
                            <div class="l-stock" style="color: red; font-weight: bold;">Limited Stock</div>
                        <?php } ?>
                    </a>
            <?php
                }
            }
            ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const allProducts = document.querySelectorAll('#all-products-info .product');
    let debounceTimer;

    // Event listener for input changes
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.trim().toLowerCase();
        
        // Clear previous timer
        clearTimeout(debounceTimer);
        
        // Set debounce timer (300ms delay after typing stops)
        debounceTimer = setTimeout(() => {
            filterProducts(searchTerm);
        }, 300);
    });

    // Function to filter products
    function filterProducts(searchTerm) {
        let hasMatches = false;
        
        allProducts.forEach(product => {
            const name = product.dataset.name.toLowerCase();
            const description = product.dataset.description ? product.dataset.description.toLowerCase() : '';
            
            if (searchTerm === '' || name.includes(searchTerm) || description.includes(searchTerm)) {
                product.style.display = 'block';
                hasMatches = true;
            } else {
                product.style.display = 'none';
            }
        });

        // Show message if no matches found
        if (searchTerm !== '' && !hasMatches) {
            // You could show a message here if you want
            // For example, create a temporary element showing "No products found"
        }
    }

    // Hide results when clicking outside (if you're keeping the search results div)
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target)) {
            // searchResults.style.display = 'none';
        }
    });
});
</script>
</body>
</html>
