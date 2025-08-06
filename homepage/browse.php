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
                $select_product = mysqli_query($conn, "SELECT * FROM `motoproducts` ORDER BY `timestamp` DESC LIMIT 4") or die('Query failed.');
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
                <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `motoproducts`") or die('Query failed.');
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
            <button id="load-more">Load More</button>
        </div>
    </div>

</body>
</html>
