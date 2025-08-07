<?php
    include("../dbconn.php");
    session_start();
    if(!isset($_SESSION['UID'])) 
    {
        header('location: ../SignIn.php');
        die(); // Stop further execution
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
        .all-products {
            margin-left: 30vh;
            margin-right: 30vh;
            margin-top: 6vh;
            margin-bottom: 10vh;
        }

        .all-products .product-info {
            display: flex;
            flex-wrap: wrap; /* Allows wrapping to the next line */
            gap: 20px; /* Space between items */
            justify-content: space-around; /* Distribute items evenly */
        }

        .all-products .product {
            width: 30%; /* Adjust width so that three items fit in one row */
            display: flex;
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center-align items horizontally */
            justify-content: space-between; /* Distribute space evenly between items */
            height: 50vh; /* Height of each product item */
            padding: 10px; /* Optional: Add padding */
            text-align: center; /* Center-align text */
            margin-bottom: 15vh;
        }
        .all-products img {
            width: 400px; /* Make image take full width of its container */
            height: 350px; /* Maintain aspect ratio */
            margin-top: 10px;
            padding-left: 30px;
            padding-right: 30px;
            object-fit: contain; /* Cover the container while maintaining aspect ratio */
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
            margin-bottom: 5vh;
        }
        .all-products img:hover {
            transform: scale(1.14);
        }

        .all-products .product .box {
            display: flex;
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center-align items horizontally */
            justify-content: space-between; /* Evenly distribute items */
            flex-grow: 1; /* Allow the box to grow and fill available space */
            gap: 10px; /* Space between items */
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
            margin-right: 15px;
            padding-left: 50px;
            padding-right: 50px;
            padding-bottom: 50px;
            padding-top: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            display: flex;
            justify-content: space-between;
        }

        .main-container .product-details .brand {
            font-size: 20px;
            width: 30%;
            display: flex;
            justify-content: space-around;
            text-align: center;
            align-items: center;
        }

        .main-container .product-details .cat,
        .main-container .product-details .sub-cat {
            display: inline-block;
            font-size: 20px;
        }

        .main-container .product-details .brand img {
            width: 120px;
            height: fit-content;
            margin-left: 30px;
        }

        .main-container .product-details .img-row {
            display: flex;
            text-align: center;
            justify-content: center;
        }

        .main-container .product-details .img-row img {
            width: 15vw;
            align-self: center;
            height: fit-content;
        }

    </style>
</head>
<body>
    <header style="font-family: 'Oswald','sans-serif';">
    <?php
        include("../header1.php");
    ?>
    </header>
    <?php
        include("floatingCart.php")
    ?>
    <div class="main-container">
        <div class="product-details">
            <div class="product-info">
                <h1><?php echo $row['name']; ?></h1>
                <h2><u>Brand Overview</u></h2>
                <p style="font-size: 20px; width: 80%; text-align: justify;;"><?php echo $row['brand_desc'];?></p>
                <?php
                    $brand_id = $row['brand_id']; // assuming $row contains brand details

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
                </p><br>
            </div>
            <div class="img-row" style="display: flex; justify-content: center; width: 60%;">
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
                                <div class="name"><?php echo $fetch_product['name']; ?></div>
                            </div>
                            <div class="price">NPR <?php echo number_format($fetch_product['price']); ?></div>
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