<?php
    include("../dbconn.php");
    session_start();
    if(!isset($_SESSION['UID'])) {
        header('location: ../SignIn.php');
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
    <link rel="stylesheet" href="CSS/helmets.css">
</head>
<body>
    <?php include("../header.php"); 
    include("floatingCart.php");?>
    
    <div class="page-content">
        <!-- Main content of your page -->
        <div class="content">
            <div class="left">
                <h1>AGV PISTA GP R Winter Test 2018</h1>
                <p>100% carbon fiber helmet offering unparalleled lightweight performance.</p>
                <button class="slide" onclick="document.getElementById('pro').scrollIntoView({ behavior: 'smooth' });">Shop Now</button>
            </div>
        </div>

        <div class="category">
            <h1 id="cat">Browse By Categories</h1>
            <div class="box-container">
            <?php
                $select_subcategories = mysqli_query($conn, "SELECT * FROM `sub_category` WHERE cat_id='2'") or die('Query failed.');
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
                $select_product = mysqli_query($conn, "SELECT * FROM `motoproducts` WHERE category_fid='2';") or die('Query failed.');
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".subcategory-checkbox").on('change', function() {
                var selectedSubcategories = [];

                $(".subcategory-checkbox:checked").each(function() {
                    selectedSubcategories.push($(this).val());
                });

                $.ajax({
                    url: "fetch-helmet.php",
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

    <?php include("../footer.php"); ?>
</body>
</html>
