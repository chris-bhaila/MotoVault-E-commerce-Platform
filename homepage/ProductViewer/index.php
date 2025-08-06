<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css" type="text/css">
</head>
<body>
    <?php
// Display regular products from database
include("../../dbconn.php");
$query = mysqli_query($conn, "SELECT * FROM motoproducts LIMIT 10"); // Adjust limit as needed
if (mysqli_num_rows($query) > 0) {
    echo '<div class="products-container">';
    echo '<h2>Featured Products</h2>';
    echo '<div class="products-scroller">';
    
    while ($row = mysqli_fetch_assoc($query)) {
        ?>
        <div class="product-card">
            <a href="productPage.php?id=<?php echo $row['product_id']; ?>" class="product-link">
                <div class="image-container">
                    <img src="../../admin/products/<?php echo $row['image'] ?? 'default.jpg'; ?>"
                        alt="<?php echo htmlspecialchars($row['name']); ?>"
                        class="product-image">
                </div>
                <div class="product-info">
                    <div class="product-name"><?php echo $row['name']; ?></div>
                    <div class="product-price">Rs. <?php echo number_format($row['price']); ?></div>
                    <div class="product-meta">
                        <?php if (($row['stock'] ?? 0) <= 5 && ($row['stock'] ?? 0) > 0) { ?>
                            <span class="stock-status limited">Limited Stock</span>
                        <?php } elseif (($row['stock'] ?? 0) <= 0) { ?>
                            <span class="stock-status out">Out of Stock</span>
                        <?php } ?>
                    </div>
                </div>
            </a>
        </div>
        <?php
    }
    
    echo '</div></div>';
} else {
    echo "<p>No products available.</p>";
}
?>
</body>
</html>