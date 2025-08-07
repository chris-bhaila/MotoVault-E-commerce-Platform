<?php
    include("../dbconn.php");
    session_start();
    if(!isset($_SESSION['AID'])) {
        header('location: SignIn.php');
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Monsterrat.css">
    <style>
        body
        {
            font-family: 'Monsterrat', sans-serif;
        }
        .main-table
        {
            margin-top: 90px;
            padding: 40px;
        }
        table
        {
            width: 100%;
            padding: 20px;
            padding-bottom: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            border-radius: 20px;
        }
        .c-btn{
            padding: 8px;
            width: 10vh;
            border: 1px solid black;
            color: black;
            cursor: pointer;
            border-radius: 25px;
            transition: 0.2s linear;
            font-family: 'Monsterrat', sans-serif;
            text-decoration: none; 
            font-weight: 500; 
            font-size: 18px;
        }
        .c-btn:hover{
            text-decoration: none; 
            color: white;
            background-color: black;
        }
    </style>
</head>
<body>
    <?php
        include('header.php');
    ?>
    <div class="main-table">
        <table>
            <tr style="height: 80px; font-size: 24px;">
                <th style="text-align: center;" width="5%">S.N.</th>
                <th style="text-align: center;" width="8%">Product ID</th>
                <th style="text-align: center;" width="18%">Product Image</th>
                <th style="text-align: left;" width="27%">Product Name</th>
                <th style="text-align: center;" width="25%">Positive Ratings</th>
                <th style="text-align: center;" width="17%">Action</th>
            </tr>
            <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `motoproducts`") or die('Query failed.');
                $index=1;
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                        ?>
                            <tr>
                                <td style="text-align: center; font-weight: 500; font-size: 18px;"><?php echo $index++;?></td>
                                <td style="text-align: center; font-weight: 500; font-size: 18px;"><?php echo $fetch_product['product_id'];?></td>
                                <td style="text-align: center;"><img src="products/<?php echo $fetch_product['image']; ?>" alt="" width="350px" height="auto"></td>
                                <td style="font-weight: 500; font-size: 18px;"><?php echo $fetch_product['name']; ?></td>
                                <td style="text-align: center; font-weight: 500; font-size: 20px;">
                                    <?php
                                        $product_review_id = $fetch_product['product_id'];
                                        $query1 = "SELECT COUNT(*) as total_reviews, SUM(rating) as total_obtained_rating FROM review WHERE product_id='$product_review_id'";
                                        $result1 = mysqli_query($conn, $query1);

                                        if ($result1 && mysqli_num_rows($result1) > 0) {
                                            $row1 = mysqli_fetch_assoc($result1);

                                            $total_reviews = $row1['total_reviews']; // Total number of reviews
                                            if ($total_reviews == 0) {
                                                echo 'No reviews made yet for this product.<br>';
                                                // Continue to the next product without stopping execution
                                            } else {
                                                $total_obtained_rating = $row1['total_obtained_rating']; // Sum of ratings
                                                
                                                // Each review has a maximum rating of 5
                                                $total_obtainable_rating = $total_reviews * 5.0;
                                                $satisfactory_rate = number_format(($total_obtained_rating / $total_obtainable_rating) * 100, 1);
                                                echo $satisfactory_rate."%";
                                            }
                                            
                                        } else {
                                            echo "No reviews found for this product.";
                                        }
                                    ?>
                                </td>
                                <td style="text-align: center;"><a href="reviewPage.php?id=<?php echo $fetch_product['product_id']; ?>" class="c-btn">Check Reviews</a></td>
                            </tr>
                        <?php
                    }
                }
                ?>
        </table>
    </div>
</body>
</html>