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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Products</title>
    <link rel="stylesheet" href="../mainFont.css">
    <link rel="stylesheet" href="css/browse.css">
</head>
<body>
    <?php
        include("../header1.php");
        include('floatingCart.php');
    ?>
    <div class="main-container">
        <h1>All Products</h1>
        <div class="all-products">
            <div class="product-info" id="product-info">
                <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `motoproducts`") or die('Query failed.');
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                ?>
                        <form method="post" class="product" action="productPage.php">
                            <a href="productPage.php?id=<?php echo $fetch_product['product_id'];?>">
                                <img src="../admin/products/<?php echo $fetch_product['image']; ?>" 
                                alt="<?php echo $fetch_product['name']; ?>" class="image">
                            </a>
                            <div class="box">
                                <div class="name"><?php echo $fetch_product['name']; ?></div>
                            </div>
                            <div class="price">
                                <?php if ($fetch_product['stock'] > 0) { ?>
                                    NPR <?php echo number_format($fetch_product['price']); ?>
                                <?php } else { ?>
                                    <span class="out-of-stock" style="color: grey;">Out of Stock</span>
                                <?php } ?>
                            </div>
                            <?php if ($fetch_product['stock'] <= 5 && $fetch_product['stock']>0) { ?>
                                <div class="l-stock">Limited Stock</div>
                            <?php } ?>
                        </form>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>