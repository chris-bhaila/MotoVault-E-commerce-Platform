<?php
    include("../dbconn.php");
    session_start();
    if(!isset($_SESSION['UID'])) {
        header('location: SignIn.php');
        die(); // Stop further execution
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="../mainFont.css">
    <link rel="stylesheet" href="../mainFont2.css">
    <link rel="stylesheet" href="css/gears.css">
</head>
<body>
    <div class="header" style="font-family: 'Oswald', sans-serif;">
        <?php include("../header.php"); ?>
    </div>
    <?php
        include("floatingCart.php");
    ?>
    <div class="page-content" style="font-family: 'Monsterrat', sans-serif;">
        <!-- Main content of your page -->
        <div class="content" style="font-family: 'Oswald', sans-serif;">
            <div class="top">
                <div class="top-left">
                    <h1>
                        MONSOON SALE <br> IS ON!!
                    </h1>
                    <h2>
                        GRAB SOME GEAR AND DISAPPEAR
                    </h2>
                    <button class="slide2" onclick="document.getElementById('pro').scrollIntoView({ behavior: 'smooth' });">VIEW ITEMS ON SALE</button>
                </div>
                <div class="top-right">
                    <div class="offer">
                        <h2>
                            GET EXCITING OFFERS AND DEALS ONLY AT <p style="font-size: 3rem; color:#f6f610;
                            text-shadow: 4px 6px 8px black;
                            display:inline; margin-left:-10px; ">MOTOVAULT</p>
                        </h2>
                        <button class="slide" onclick="document.getElementById('pro').scrollIntoView({ behavior: 'smooth' });">SHOP NOW</button>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="bottom-left">

                </div>
                <div class="bottom-right">
                    <div class="image"><img src="../admin/brands/alpine.svg" alt=""></div>
                    <h2>ENJOY 15% OFF ON ALL ALPINESTARS ITEMS</h2>
                    <button class="slide1" onclick="window.location.href='brandProducts.php?id=7'">GO TO BRAND PAGE</button>
                </div>
            </div>
        </div>
        <div class="category">
            <h1 id="cat">Browse By Categories</h1>
            <div class="box-container">
            <?php
                $select_subcategories = mysqli_query($conn, "SELECT * FROM `sub_category` WHERE cat_id='4'") or die('Query failed.');
                if(mysqli_num_rows($select_subcategories) > 0) {
                    while($fetch_subcategory = mysqli_fetch_assoc($select_subcategories)) {
            ?>
                        <div class="box">
                            <!-- Hidden checkbox -->
                            <input type="checkbox" class="subcategory-checkbox" value="<?php echo $fetch_subcategory['sub_cat_id']; ?>" id="subcategory_<?php echo $fetch_subcategory['sub_cat_id']; ?>">
                            
                            <!-- Custom label and image -->
                            <label for="subcategory_<?php echo $fetch_subcategory['sub_cat_id']; ?>">
                                <img src="../admin/subcategories/<?php echo $fetch_subcategory['image'];?>" 
                                    alt="<?php echo $fetch_subcategory['name']?>" 
                                    class="image" 
                                    name="cat_image">
                            </label>
                            
                            <!-- Subcategory name -->
                            <div class="name"><?php echo $fetch_subcategory['name']?></div>
                        </div>
            <?php
                    }
                }
            ?>
            </div>
        </div>
        <div class="all-products">
            <h1 id="pro">Our Products</h1>
            <div class="product-info" id="product-info">
                <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `motoproducts` WHERE category_fid='4';") or die('Query failed.');

                $products = [];
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                        $products[] = $fetch_product;
                    }

                    // Sort products: in-stock first, out-of-stock last
                    usort($products, function($a, $b) {
                        return ($b['stock'] > 0) - ($a['stock'] > 0);
                    });

                    // Loop through sorted products
                    foreach ($products as $fetch_product) {
                        ?>
                        <form method="post" class="product" action="productPage.php">
                            <a href="productPage.php?id=<?php echo $fetch_product['product_id']; ?>" style="position: relative; display: inline-block;">
                                <?php if (!empty($fetch_product['discount_percent']) && $fetch_product['discount_percent'] > 0 && $fetch_product['stock'] > 0) { ?>
                                    <div style="position: absolute; top: 8px; right: 8px; background-color: red; color: white; padding: 4px 8px; font-size: 12px; font-weight: bold; border-radius: 5px; z-index: 5;">
                                        -<?php echo $fetch_product['discount_percent']; ?>% off
                                    </div>
                                <?php } ?>
                                <img src="../admin/products/<?php echo $fetch_product['image']; ?>" 
                                    alt="<?php echo $fetch_product['name']; ?>" class="image">
                            </a>

                            <div class="box">
                                <div class="name"><?php echo $fetch_product['name']; ?></div>
                            </div>

                            <div class="price" style="margin-top: -12px;">
                                <?php if ($fetch_product['stock'] > 0) { 
                                    $truePrice = $fetch_product['price'] - ($fetch_product['discount_percent'] / 100) * $fetch_product['price'];
                                    echo '<p style=" font-size: 18px; color: green; font-weight: 500;">NPR ' . number_format($truePrice) . '</p>';
                                } else { ?>
                                    <span class="out-of-stock" style="color: grey;">Out of Stock</span>
                                <?php } ?>
                            </div>

                            <?php if ($fetch_product['stock'] < 5 && $fetch_product['stock']>0) { ?>
                                <div class="l-stock" style="margin-top: -10px">Limited Stock</div>
                            <?php } ?>
                        </form>
                        <?php
                    }
                }

                ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".subcategory-checkbox").on('change', function() {
                var selectedSubcategories = [];

                $(".subcategory-checkbox:checked").each(function() {
                    selectedSubcategories.push($(this).val());
                });

                $.ajax({
                    url: "fetch-gears.php",
                    type: "POST",
                    data: { subcategories: selectedSubcategories },
                    beforeSend: function() {
                        $("#product-info").html("<span>Working...</span>");
                    },
                    success: function(data) {
                        $("#product-info").html(data);
                    }
                });
            });
        });
    </script>
    <?php
        include("../footer.php");
    ?>
</body>
</html>
