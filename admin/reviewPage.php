<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="jquery-3.7.1.min.js"></script>
<?php
include("../dbconn.php");
session_start();
if (!isset($_SESSION['AID'])) {
    header('location: SignIn.php');
    die();
}
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $query = "SELECT * FROM motoproducts WHERE product_id = $product_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
}
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $product_id = $_GET['id']; // Ensure product_id is retrieved from the URL
    if (mysqli_query($conn, "DELETE FROM review WHERE review_id='$remove_id'")) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Deleted successfully',
                        text: 'The review has been deleted.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'reviewPage.php?id=$product_id';
                    });
                });
            </script>";
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to delete the record.',
                        icon: 'error'
                    });
                });
            </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Document</title>
    <style>
        .main-container {
            margin-top: 100px;
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
            margin-left: 9px;
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
            width: 20vw;
            align-self: center;
            height: fit-content;
        }

        .review-container {
            display: flex;
            /* padding: 0.5%; */
            padding-left: 1%;
            padding-right: 1%;
            margin-top: 30px;
        }

        .review-container h2 {
            margin-bottom: -10px;
        }

        .review-container .user-review {
            padding: 10px;
            max-height: fit-content;
            width: 45%;
        }

        .review-container .new-review .desc {
            width: 100%;
            height: 10vh;
            margin-top: 10px;
            margin-right: 20px;
            box-sizing: border-box;
            font-family: Oswald, sans-serif;
            padding: 8px;
        }

        .review-container .new-review .rev {
            height: 4vh;
            width: 15vh;
            background-color: black;
            font-family: Oswald, sans-serif;
            color: white;
            font-size: 16px;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.2s ease-in;
            margin-top: 4px;
        }

        .review-container .new-review .rev:hover {
            border: 1px solid darkgray;
            background-color: darkgray;
        }

        .stars {
            font-size: 20px;
            /* Adjust the size of the stars */
            color: gold;
            /* Default color for filled stars */
        }

        .empty-stars {
            margin-top: -3px;
            margin-left: -6px;
            font-size: 20px;
            color: lightgray;
            /* Color for empty stars */
        }

        .review-container .user-review .rev-star {
            margin-top: -20px;
            margin-bottom: -10px;
        }

        .review-container .user-review .rev {
            justify-content: space-between;
            border-bottom: 1px solid grey;
            display: flex;
        }

        .review-container .user-review .rev .del {
            display: flex;
            align-items: center;
        }

        .review-container .user-review .rev .del .r-btn {
            text-decoration: none;
            font-size: 16px;
            color: white;
            padding: 8px;
            background-color: red;
            border: 1px solid red;
            border-radius: 8px;
            transition: 0.1s linear;
        }

        .review-container .user-review .rev .del .r-btn:hover {
            background-color: crimson;
            border: 1px solid crimson;
        }

        .review-container {
            display: flex;
            width: 95vw;
        }

        .review-container .chart {
            width: 49%;
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            margin-left: 40px;
            max-height: fit-content;
            margin-top: 50px;
        }

        .review-container .chart .bar-chart {
            padding: 1%;
            margin-right: 10px;
            max-height: inherit;
        }
    </style>
</head>

<body>
    <?php
    include('header.php');
    ?>
    <div class="main-container">
        <div class="product-details">
            <div class="product-info">
                <h1>Reviews for <?php echo $row['name']; ?></h1>
                <h2><u>Product Overview</u></h2>
                <?php
                $sql = mysqli_query($conn, "
                        SELECT 
                            mp.*, 
                            b.image AS brand_image, 
                            c.name AS category_name, 
                            sc.name AS sub_cat_name
                        FROM motoproducts mp
                        JOIN brands b ON mp.brand_fid = b.brand_id
                        JOIN categories c ON mp.category_fid = c.category_id
                        JOIN sub_category sc ON mp.sub_cat_fid = sc.sub_cat_id
                        WHERE mp.product_id = $product_id
                    ");

                if (mysqli_num_rows($sql) > 0) {
                    $row1 = mysqli_fetch_assoc($sql);
                } else {
                    echo "No product found with the given ID.";
                }
                ?>
                <p class="brand" style="color: black;">Brand: <img src="brands/<?php echo $row1['brand_image']; ?>" alt=""></p><br>
                <p class="cat" style="color: black;">Category: <?php echo $row1['category_name']; ?></p><br>
                <p class="sub-cat" style="color: black;">Sub-category: <?php echo $row1['sub_cat_name']; ?></p>
                <p style="font-weight: 500; font-size: 20px; margin-left: 6px;">
                    <?php
                    $query1 = "SELECT COUNT(*) as total_reviews, SUM(rating) as total_obtained_rating FROM review WHERE product_id='$product_id'";
                    $result1 = mysqli_query($conn, $query1);

                    if ($result1 && mysqli_num_rows($result1) > 0) {
                        $row1 = mysqli_fetch_assoc($result1);

                        $total_reviews = $row1['total_reviews']; // Total number of reviews
                        if ($total_reviews == 0) {
                            echo 'No reviews made yet for this product.<br>';
                        } else {
                            $total_obtained_rating = $row1['total_obtained_rating'];
                            $total_obtainable_rating = $total_reviews * 5.0;
                            $satisfactory_rate = number_format(($total_obtained_rating / $total_obtainable_rating) * 100, 1);
                            echo "Product Satisfactory Rate: " . $satisfactory_rate . "%";
                        }
                    } else {
                        echo "No reviews found for this product.";
                    }
                    ?>
                </p>
            </div>
            <div class="img-row">
                <img src="products/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
            </div>
        </div>
        <div class="review-container">
            <div class="user-review">
                <h2>Reviews by Customers</h2>
                <?php
                $select_review = mysqli_query($conn, "
                            SELECT review.review_id,review.description,review.rating,review.review_date,user.name 
                            FROM review 
                            JOIN user ON review.user_id = user.id 
                            WHERE review.product_id='$product_id'
                        ") or die('Query failed.');
                $max_items = 11; // Set the maximum number of items to display
                $item_count = 0;
                if (mysqli_num_rows($select_review) > 0) {
                    while ($fetch_review = mysqli_fetch_assoc($select_review)) {
                        $review_date = strtotime($fetch_review['review_date']);
                        $month = date('F', $review_date); // Full month name
                        $year = date('Y', $review_date); // Full year
                        $rating = $fetch_review['rating']; // Assuming rating is an integer between 1 and 5
                        if ($item_count <= $max_items) {
                ?>
                            <div class="rev">
                                <div class="indiv-rev">
                                    <p style="font-size:20px;">
                                        <?php echo $fetch_review['name'];
                                        echo "<br>" . $month . ", " . $year; ?>
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
                                    <p style="font-size: 18px;">
                                        <?php
                                        echo $fetch_review['description'];
                                        ?>
                                    </p>
                                </div>
                                <div class="del">
                                    <a href="reviewPage.php?remove=<?php echo $fetch_review['review_id']; ?>&id=<?php echo $product_id; ?>" class="r-btn">Remove</a>
                                </div>
                            </div>

                        <?php
                        }
                        $item_count++;
                        ?>
                <?php
                    }
                } else {
                    echo "<p style='margin-top: 8px;
                                    margin-bottom: -8px;'>No Reviews Yet</p>";
                }
                ?>
            </div>
            <div class="chart">
                <div class="bar-chart">
                    <canvas id="barChart"></canvas>
                    <?php
                    $c_sql = "
                    SELECT r.rating, COUNT(r.rating) AS rating_count
                    FROM review r
                    WHERE r.product_id = $product_id
                    GROUP BY r.rating
                    ORDER BY r.rating ASC";
                    $c_result = $conn->query($c_sql);
                    $data = [];
                    if ($c_result->num_rows > 0) {
                        while ($c_row = $c_result->fetch_assoc()) {
                            $data[] = $c_row;
                        }
                    }
                    // Initialize an array for all 5 ratings (1-5)
                    $ratingCounts = [0, 0, 0, 0, 0]; // [1-star, 2-star, 3-star, 4-star, 5-star]

                    // Populate the counts based on the result from the query
                    foreach ($data as $row) {
                        $ratingCounts[$row['rating'] - 1] = $row['rating_count']; // Offset for 0-based index
                    }
                    $max_y_value = max($ratingCounts) + 2; // Add padding of 5 to the highest value
                    ?>
                    <script>
                        const ratingCounts = <?php echo json_encode($ratingCounts); ?>; // [1-star, 2-star, 3-star, 4-star, 5-star]
                        const maxYValue = <?php echo $max_y_value; ?>;
                        const ctx = document.getElementById('barChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'], // x-axis labels
                                datasets: [{
                                    label: 'Number of Reviews',
                                    data: ratingCounts, // Number of reviews for each rating
                                    backgroundColor: ['#26A0FC'], //['red', 'orange', 'yellow', 'lightgreen', 'green'], // Colors for each bar
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: maxYValue,
                                        ticks: {
                                            stepSize: 1, // Ensures the difference between points is 1
                                            precision: 0, // Ensures no decimal values are shown
                                        },
                                        title: {
                                            display: true,
                                            text: 'Number of Reviews'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Star Rating'
                                        }
                                    }
                                },
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Product Ratings Distribution'
                                    },
                                    font: {
                                        size: 24, // Font size
                                        weight: 'bold', // Font weight
                                        family: 'Courier New, monospace' // Font family
                                    },
                                    padding: {
                                        top: 15,
                                        bottom: 15
                                    },
                                    align: 'center'
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.r-btn').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure you want to remove this review?',
                icon: 'warning',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                confirmButtonColor: 'red',
                cancelButtonColor: 'grey',
                confirmButtonText: 'Confirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href; // Ensure the `href` contains the `id` query param
                }
            });
        });
    </script>
</body>

</html>