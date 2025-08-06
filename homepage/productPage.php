<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<link rel="stylesheet" href="../mainFont.css">
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
    $product_id = $_GET['id'];

    $query = "SELECT * FROM motoproducts WHERE product_id = $product_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
    }
}

if (isset($_POST["add-to-cart"])) {
    // Retrieve existing cart data from cookies
    $cart_data = isset($_COOKIE['shopping_cart']) ? json_decode($_COOKIE['shopping_cart'], true) : [];

    // Check if the product is already in the cart
    $existing_product_index = array_search($product_id, array_column($cart_data, 'item_id'));

    if ($existing_product_index !== false) {
        // Increase the quantity of the existing product
        $cart_data[$existing_product_index]['item_quantity'] += 1;
    } else {
        // Add new product to the cart
        $cart_data[] = [
            'item_id' => $_POST["p-id"],
            'item_name' => $_POST["p-name"],
            'item_price' => $_POST["p-price"],
            'item_quantity' => $_POST["quantity"],
            'user_id' => $_SESSION['UID']
        ];
        $item_name = $_POST['p-name'];
    }

    // Save updated cart back to the cookie
    setcookie('shopping_cart', json_encode($cart_data), time() + (86000 * 30), '/');

    // Output JavaScript to show alert and redirect
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'This product has been added to cart successfully',
                    icon: 'success'
                }).then(() => {
                    window.location.href = '{$_SERVER['HTTP_REFERER']}';
                });
            });
        </script>";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php
            echo "Shop ".$row['name'];
          ?></title>
      <link rel="stylesheet" href="css/button.css">
      <link rel="stylesheet" href="css/productPage.css">
      <link rel="stylesheet" href="../mainFont.css">
      <link rel="stylesheet" href="../mainFont2.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    
        <?php
            include("../header1.php");
            ?>
            <?php
            include("floatingCart.php");
        ?>
        <div class="pmain-container">
            <div class="info-container">
                <div class="left">
                    <img src="../admin/products/<?php echo $row['image']; ?>"
                    alt="<?php echo $row['name']; ?>" class="p-image" id="p-image">
                </div>
                <div class="right">
                    <form method="post" id="productForm">
                        <input type="hidden" name="p-id" id="p-id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="p-name" id="p-name" value="<?php echo $row['name']; ?>">
                        <p class="h-name">
                            <?php echo $row['name']; ?></p>
                        <div class="l-stock">
                            <?php if ($row['stock'] < 5)
                            {
                                echo "Limited Stock";
                            } ?>
                        </div>
                        <div class="brand">
                            <p class="r-brand" style="display: inline; color: black;">Brand: </p>
                            <?php
                                // Assume $product_id is given
                                // For example

                                // Prepare the SQL query
                                $sql = mysqli_query($conn, "SELECT mp.*, b.name
                                                            FROM motoproducts mp
                                                            JOIN brands b ON mp.brand_fid = b.brand_id
                                                            WHERE mp.product_id = $product_id");

                                // Check if any row is returned
                                if(mysqli_num_rows($sql) > 0)
                                {
                                    // Fetch the associative array
                                    $row = mysqli_fetch_assoc($sql);
                                    // Display the brand name
                                    echo $row['name'];
                                }
                                else
                                {
                                    // Display a message if no product is found
                                    echo "No product found with the given ID.";
                                }
                            ?>
                        </div>
                        <p class="desc"><?php echo $row['description']; ?></p>
                        <div class="feature">
                            <h3>Features</h3>
                                <p class="feat">&#x2022; <?php
                                    $points = str_replace("!", "<br>&#x2022; ", $row['features']);

                                    // Display the processed paragraph
                                    echo "$points";
                                ?></p>
                        </div>
                        <input type="hidden" name="p-price" id="p-price" value="
                        <?php 
                        if($row['discount_percent']!=NULL)
                            {
                                $truePrice = $row['price']-($row['discount_percent']/100)*$row['price'];
                                echo $truePrice;
                            } 
                            else
                            {
                                echo $row['price'];
                            }
                        ?>">

                        <?php if ($row['stock'] > 0) { ?>
                            <input type="number" name="quantity" class="quantity" min="1" max="<?php echo $row['stock'];?>" value="1">
                        <?php } else {?>

                            <?php } ?>
                        <p class="price">
                        <?php 
                        if($row['discount_percent']!=NULL)
                            {
                                $truePrice = $row['price'] - ($row['discount_percent'] / 100) * $row['price'];
                                echo '<div style="display: flex; gap: 10px; align-items: center; font-size: 24px;">
                                    <span style="color: red; text-decoration: line-through;">Rs. ' . number_format($row['price']) . '</span>
                                    <span style="color: orange; font-weight: 500; font-size: 20px;">  ' . $row['discount_percent'] . '% off</span>
                                </div>';
                                echo '<p style=" font-size: 32px; color: green; font-weight: 500;">Rs. ' . number_format($truePrice) . '</p>';
                            } 
                            else
                            {
                                echo '<p style=" font-size: 32px; color: green; font-weight: 500;">Rs. ' . number_format($truePrice) . '</p>';
                            }
                        ?>
                        </p>
                        <div class="buttons">
                            <?php if ($row['stock'] > 0) { ?>
                                <input type="submit" name="add-to-cart" class="add-to-cart" value="Add to Cart">
                            <?php } else { ?>
                                <span class="out-of-stock" style="font-size: 32px; color: red;">Out of Stock</span>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
            <?php
                if(isset($_POST['submit']))
                {
                    $userid=$_SESSION['UID'];
                    $desc=$_POST['desc'];
                    $rating=$_POST['star'];
                    $sql = "INSERT INTO review (user_id,product_id,description,rating) VALUES ('$userid','$product_id','$desc','$rating')";
                    $res=mysqli_query($conn,$sql);
                    if($res)
                    {
                        ?>
                            <script>
                                swal({
                                    title: "Thank you for reviewing this product!",
                                    text: "Your review has been posted.",
                                    icon: "success",
                                    button: "Okay"
                                }).then(() => {
                                    window.location.href = "productPage.php?id=<?php echo $product_id; ?>";
                                });
                            </script>
                        <?php
                    }
                    else
                    {
                        ?>
                            <script>
                                swal({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Something went wrong!",
                                    button: "Okay"
                                }).then(() => {
                                    window.location.href = "productPage.php?id=<?php echo $product_id; ?>";
                                });
                            </script>
                        <?php
                    }
                }
            ?>
            
          <?php
            $product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if (!$product_id) {
                echo "<p>Invalid product ID</p>";
                exit;
            }

            // Run SBERT Python script
            $command = escapeshellcmd("python sbert_recommender.py $product_id");
            $output = shell_exec($command);

            // Convert JSON result
            $recommendations = json_decode($output, true);

            if (!empty($recommendations)) {
                echo '<div class="recommended-products-container">';
                echo '<h2>Recommended Products</h2>';
                echo '<div class="recommended-products-scroller">';
                
                foreach ($recommendations as $product) {
                    $pid = htmlspecialchars($product['product_id']);
                    $score = round($product['score'] * 100, 2); // Convert to percentage
                    
                    // Get full product details for each recommended product
                    $query = mysqli_query($conn, "SELECT * FROM motoproducts WHERE product_id = $pid");
                    $rev_query = mysqli_query($conn,"SELECT COUNT(*) as total_reviews, SUM(rating) as total_obtained_rating FROM review WHERE product_id=$pid");
                    if (mysqli_num_rows($query) > 0) {
                        $row = mysqli_fetch_assoc($query);
                        ?>
                        <div class="recommended-product-card">
                            <a href="productPage.php?id=<?php echo $row['product_id']; ?>" style="text-decoration: none;">
                                <img src="../admin/products/<?php echo $row['image'] ?? 'default.jpg'; ?>"
                                    alt="<?php echo htmlspecialchars($row['name']); ?>"
                                    class="product-image">
                                <div class="product-details">
                                    <div class="product-name"><?php echo $row['name']; ?></div>
                                    <div class="product-price">Rs. <?php echo number_format($row['price']); ?></div>
                                    <!-- <div class="similarity-score"></div> -->
                                    <?php 
                                    if(mysqli_num_rows($rev_query) > 0) {
                                        $row1 = mysqli_fetch_assoc($rev_query);
                                        $total_reviews = $row1['total_reviews'];
                                        
                                         if ($total_reviews == 0) {
                                                echo '';
                                                // Continue to the next product without stopping execution
                                            } else {
                                                $total_obtained_rating = $row1['total_obtained_rating']; // Sum of ratings
                                                
                                                // Each review has a maximum rating of 5
                                                $total_obtainable_rating = $total_reviews * 5.0;
                                                $satisfactory_rate = number_format(($total_obtained_rating / $total_obtainable_rating) * 5, 2);?>
                                                <div class="product-review" style="color:gray;">Ratings: <?php echo $satisfactory_rate."/5 (".$total_reviews.")";?></div>
                                                <?php
                                            }
                                            }else {
                                            echo "No reviews found for this product.";
                                        }
                                            ?>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                }
                
                echo '</div></div>';
            } else {
                echo "<p>No recommendations available.</p>";
            }

            ?>
            <div class="review-container">
                <div class="user-review">
                    <?php
                        $select_review = mysqli_query($conn, "
                        SELECT review.description,review.rating,review.review_date,user.name
                        FROM review
                        JOIN user ON review.user_id = user.id
                        WHERE review.product_id='$product_id'
                        ") or die('Query failed.');
                        $max_items = 11; // Set the maximum number of items to display
                        $item_count = 0;
                        if (mysqli_num_rows($select_review) > 0) {
                            ?><h2>Reviews for this product</h2><?php
                            while ($fetch_review = mysqli_fetch_assoc($select_review)) {
                                $review_date = strtotime($fetch_review['review_date']);
                                $month = date('F', $review_date); // Full month name
                                $year = date('Y', $review_date); // Full year
                                $rating = $fetch_review['rating']; // Assuming rating is an integer between 1 and 5
                                if ($item_count <= $max_items) {
                                    ?>
                                    <div class="indiv-rev">
                                        <p style="font-size:16px;">
                                            <?php echo '<b>'.$fetch_review['name'].'</b>';
                                            echo "<br>" . $month . ", " . $year;?>
                                        </p>
                                            <div class="rev-star">
                                                <span class="stars">
                                                <?php
                                                // Print filled stars based on the rating
                                                for ($i = 1; $i <= $rating; $i++) {
                                                    echo "★";  // Filled star
                                                }
                                                ?>
                                                </span>
                                                <span class="empty-stars">
                                                <?php
                                                // Print empty stars for the remaining
                                                for ($i = $rating + 1; $i <= 5; $i++) {
                                                    echo "★";  // Empty star
                                                }
                                                ?>
                                                </span>
                                            </div>
                                            <p style="color:grey;">
                                            <?php
                                                echo $fetch_review['description'];
                                            ?>
                                        </p>
                                    </div>
                                    <?php
                                }
                                $item_count++;
                    ?>
                    <?php
                            }
                        }
                    ?>
                </div>
                <div class="new-review">
                    <form action="" class="make-rev" method="post">
                        <h3>Write a review for this product</h3>
                        <label for="rate">Give a rating: </label>
                        <select name="star" id="star" class="stars">
                            <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    echo '<option value="' . $i . '">';
                                    for ($j = 1; $j <= $i; $j++) {
                                        echo '★';  // This is the HTML symbol for a star
                                    }
                                    echo '</option>';
                                }
                            ?>
                        </select><br>
                        <textarea name="desc" class="desc" style="font-size: 18px;" required></textarea><br>
                        <input type="submit" value="Submit Review" name="submit" class="rev" style="font-family: 'Monsterrat','sans-serif';">
                    </form>
                </div>
            </div>
    </body>
</html>