<?php
    include("../dbconn.php");
    session_start();
    if(!isset($_SESSION['UID'])) 
    {
        header('location: ../SignIn.php');
        die();
    }
    if (isset($_GET['id'])) 
    {
        $brand_id = $_GET['id'];
        $sql=mysqli_query($conn, "SELECT * FROM `brands` WHERE brand_id='$brand_id'");
        if (mysqli_num_rows($sql) > 0) 
        {
            $row = mysqli_fetch_assoc($sql);
        }
        $brandName=$row['name'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products by <?php echo $brandName;?></title>
    <link rel="stylesheet" href="../mainFont.css">
    <link rel="stylesheet" href="../mainFont2.css">
    <style>
        body {
            font-family: 'Oswald', sans-serif;
        }
        
        .all-products {
            margin-left: 15vh;
            margin-right: 15vh;
            margin-top: 6vh;
            margin-bottom: 10vh;
        }

        .all-products .product-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
        }

        .all-products .product {
            width: 20%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            height: 50vh;
            padding: 10px;
            text-align: center;
            margin-bottom: 15vh;
        }
        
        .all-products img {
            width: 400px;
            height: 350px;
            margin-top: 10px;
            padding-left: 30px;
            padding-right: 30px;
            object-fit: contain;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
            margin-bottom: 5vh;
        }
        
        .all-products img:hover {
            transform: scale(1.14);
        }

        .all-products .product .box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            flex-grow: 1;
            gap: 10px;
        }

        .all-products .product .name {
            font-size: 18px;
        }

        .all-products .product .price {
            font-size: 18px;
            color: green;
        }

        .all-products .product .l-stock {
            color: red;
            font-size: 20px;
        }

        .all-products h1 {
            margin-left: 8vh;
        }
        
        .product {
            position: relative;
            width: 250px;
            text-align: center;
            margin: 0 auto;
        }

        .discount-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: red;
            color: white;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 5px;
            z-index: 5;
        }
        
        .main-container {
            margin-top: 20px;
            padding: 20px;
            margin-left: 20px;
            margin-right: 20px;
        }

        .main-container .product-details {
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .main-container .product-info {
            width: 70%;
        }

        .brand-image-container {
            width: 30%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .brand-image-container img {
            max-width: 100%;
            max-height: 200px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .main-container .product-details .cat,
        .main-container .product-details .sub-cat {
            display: inline-block;
            font-size: 20px;
        }

        .main-container h1 {
            margin-bottom: 20px;
        }

        .main-container h2 {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <header>
        <?php include("../header1.php"); ?>
    </header>
    
    <?php include("floatingCart.php") ?>
    
    <div class="main-container">
        <div class="product-details">
            <div class="product-info">
                <h1><?php echo $row['name']; ?></h1>
                <h2><u>Brand Overview</u></h2>
                <p style="font-size: 20px; width: 100%; text-align: justify;"><?php echo $row['brand_desc'];?></p>
                <?php
                    $brand_id = $row['brand_id'];

                    $subCatQuery = "
                        SELECT DISTINCT s.name AS sub_cat_name
                        FROM motoproducts m
                        JOIN sub_category s ON m.sub_cat_fid = s.sub_cat_id
                        WHERE m.brand_fid = $brand_id
                        ORDER BY s.name
                    ";

                    $subCatResult = mysqli_query($conn, $subCatQuery);

                    $subCategories = [];
                    while ($subCatRow = mysqli_fetch_assoc($subCatResult)) {
                        $subCategories[] = $subCatRow['sub_cat_name'];
                    }
                ?>
                <p class="cat" style="color: black;">
                    <b>Associated Categories:</b> 
                    <?php 
                    if (!empty($subCategories)) {
                        echo implode(', ', $subCategories);
                    } else {
                        echo 'No products found in any sub-category.';
                    }
                    ?>
                </p>
            </div>
            <div class="brand-image-container">
                <img src="../admin/brands/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
            </div>
        </div>
    </div>
    
    <div class="all-products">
        <h1 id="pro">Products by <?php echo $brandName; ?></h1>
        <div class="product-info" id="product-info">
            <?php
            if (isset($_GET['id'])) 
            {
                $brand_id = $_GET['id'];
                $select_product = mysqli_query($conn, "SELECT * FROM `motoproducts` WHERE brand_fid='$brand_id'") or die('Query failed.');
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                        <form method="post" class="product" action="productPage.php">
                            <a href="productPage.php?id=<?php echo $fetch_product['product_id']; ?>">
                                <?php if (!empty($fetch_product['discount_percent']) && $fetch_product['discount_percent'] > 0) { ?>
                                    <div class="discount-badge">-<?php echo $fetch_product['discount_percent']; ?>% off</div>
                                <?php } ?>
                                <img src="../admin/products/<?php echo $fetch_product['image']; ?>" 
                                    alt="<?php echo $fetch_product['name']; ?>" class="image">
                            </a>
                            <div class="box">
                                <div class="name" style="font-weight: bolder;"><?php echo $fetch_product['name']; ?></div>
                            </div>
                            <div class="price" style="font-weight: 600;">NPR <?php echo number_format($fetch_product['price']); ?></div>
                            <?php if ($fetch_product['stock'] <= 5) { ?>
                                <div class="l-stock">Limited Stock</div>
                            <?php } ?>
                        </form>
            <?php
                    }
                }
                else
                {
                    echo "<h2>No Products Found</h2>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>