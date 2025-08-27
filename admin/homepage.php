<?php
include('../dbconn.php');
session_start();
if (!isset($_SESSION['AID'])) {
    header('location: SignIn.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="Monsterrat.css">
    <style>
        body {
            background-color: white;
            font-family: 'Monsterrat', sans-serif;
        }

        .container {
            margin-top: 90px;
            padding: 40px;
        }

        .container .analytics1 {
            width: 95vw;
            height: 40vh;
            /* border: 2px solid black; */
            display: flex;
            justify-content: space-between;
            margin-bottom: 60px;
        }

        .container .analytics1 .revenue {
            padding: 30px;
            width: 55%;
            height: 85%;
            /* border: 2px solid black; */
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            margin-left: 40px;
        }

        .container .analytics1 .revenue h1 {
            font-weight: 400;
        }

        .container .analytics1 .revenue p:nth-child(2) {
            margin-top: 15px;
            font-size: 54px;
            font-weight: 600;
            color: green;
            margin-left: -2px;
            margin-bottom: 25px;
        }

        .container .analytics1 .welcome {
            padding: 30px;
            width: 40%;
            height: 85%;
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            background: url('multicolor.jpg');
            background-position: center;
            background-size: cover;
        }

        .container .analytics1 .welcome p {
            font-size: 36px;
            font-weight: 600;
            color: white;
        }

        .container .welcome .button-down {
            background-color: transparent;
            color: white;
            border: transparent;
            cursor: pointer;
            position: relative;
            font-size: 24px;
            margin-top: 80px;
            font-family: 'Monsterrat', sans-serif;
            text-decoration: none;
        }

        .container .welcome .button-down:hover {
            text-decoration: underline;
        }

        .container .analytics2 {
            display: flex;
            justify-content: space-evenly;
            height: 26vh;
            width: 95vw;
        }

        .container .analytics2 .customer-count,
        .container .analytics2 .top-selling,
        .container .analytics2 .cust-satisfy,
        .container .analytics2 .pending-orders {
            width: 21.5%;
            border-radius: 20px;
            box-shadow: 0 7px 26px rgba(0, 0, 0, 0.12);
            padding: 20px;
            /* border: 1px solid green; */
        }

        .charts {
            margin-top: 25px;
            padding: 40px;
            display: flex;
            width: 95vw;
        }

        .charts .sales-chart {
            transform: translateX(-65px);
            width: 49%;
            height: 50vh;
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            margin-left: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            margin-bottom: 60px;
            padding: 20px;
            text-align: center;
        }

        .charts .pie-chart {
            transform: translateX(-45px);
            width: 49%;
            height: 54.1vh;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
        }

        .pie-chart canvas
        {
            width: 500px !important; /* Adjust width as needed */
            height: 500px !important;
        }

        .sales-chart .chart-heading {
            text-align: center;
            margin-bottom: 15px;
            /* Adds space between heading and chart */
        }

        .sales-chart .line-chart {
            height: 48vh;
            width: 100%;
            /* Adjust width to make it responsive */
            display: flex;
            justify-content: center;
            /* Centers chart horizontally */
            align-items: center;
            /* Centers chart vertically */
        }
    </style>
</head>

<body>
    <?php
    include('header.php');
    ?>
    <div class="container">
        <div class="analytics1">
            <div class="welcome">
                <p>Welcome to Admin Dashboard, </p>
                <h1 style="font-size: 54px; color: white;">
                    <?php
                    $id = $_SESSION['AID'];
                    $query = "SELECT name FROM admin WHERE aid='$id'";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows(($result))) {
                        $row = mysqli_fetch_assoc($result);
                        echo $row['name'];
                    }
                    ?>
                </h1>
                <a href="adminDash.php" class="button-down"><u>Change Personal Details&#x2192;</u></a><br>
                <br>
                <a href="SignOut.php" class="button-down">Log Out</a>
            </div>
            <div class="revenue">
                <h1>All Time Revenue</h1>
                <?php
                // Query to get completed orders
                $query1 = "SELECT prod_price, prod_quantity FROM c_orders";
                $result1 = mysqli_query($conn, $query1);

                // Initialize variables
                $sub_total = 0;        // Initialize subtotal
                $total_orders = 0;     // Initialize total orders counter
                $total_quantity = 0;   // Initialize total quantity counter

                if ($result1 && mysqli_num_rows($result1) > 0) {
                    while ($row = mysqli_fetch_assoc($result1)) {
                        $sub_total += $row['prod_price'] * $row['prod_quantity']; // Calculate subtotal
                        $total_orders++; // Count total orders
                        $total_quantity += $row['prod_quantity']; // Sum up all quantities
                    }
                }
                ?>
                <p><?php echo "Rs. " . number_format($sub_total, 2); ?></p>
                <h2 style="font-weight: 400;">Total items sold: <?php echo $total_quantity; ?></h2>
                <p>Website URL: <a href="../homepage/homepage.php" target="_blank">motovault.com</a></p>
            </div>
        </div>
        <?php
        $query = "SELECT COUNT(*) as total_users FROM user"; // Use COUNT to get the total number of users
        $result = mysqli_query($conn, $query);

        $total_users = 0; // Default value in case query fails
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $total_users = $row['total_users']; // Fetch the count from the result
        }
        ?>
        <div class="analytics2" id="analytics2">
            <div class="customer-count">
                <h2>User Count</h2>
                <p style="font-size: 36px; font-weight: 420;"><?php echo $total_users; ?></p> <!-- Display the total user count -->
            </div>
            <div class="top-selling">
                <h2>Top Selling Product</h2>
                <?php
                $sql = "
                        SELECT 
                            product_id, 
                            prod_name, 
                            SUM(prod_quantity) AS total_quantity
                        FROM 
                            c_orders
                        GROUP BY 
                            product_id, prod_name
                        ORDER BY 
                            total_quantity DESC
                        LIMIT 1;
                    ";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output the result
                    while ($row = $result->fetch_assoc()) {
                        echo "<p style='font-size: 28px; font-weight: 600; color: #1E3A8A;'>" . $row["prod_name"] . "</p>";
                        echo "<p style='font-size: 18px; font-weight: 420;'>Total Quantity Sold: " . $row["total_quantity"] . "</p>";
                    }
                } else {
                    echo "No results found.";
                }
                ?>
            </div>
            <?php
            $query1 = "SELECT COUNT(*) as total_reviews, SUM(rating) as total_obtained_rating FROM review";
            $result1 = mysqli_query($conn, $query1);

            if ($result1 && mysqli_num_rows($result1) > 0) {
                $row1 = mysqli_fetch_assoc($result1);

                $total_reviews = $row1['total_reviews']; // Total number of reviews
                $total_obtained_rating = $row1['total_obtained_rating']; // Sum of ratings

                if ($total_reviews > 0) {
                    // Each review has a maximum rating of 5
                    $total_obtainable_rating = $total_reviews * 5.0;
                    $satisfactory_rate = number_format(($total_obtained_rating / $total_obtainable_rating) * 100.0, 1);
                } else {
                    $satisfactory_rate = 0; // No reviews case
                }
            } else {
                $satisfactory_rate = 0; // No reviews found in the database
            }
            ?>
            <div class="cust-satisfy">
                <h2>Customer Satisfactory Rate</h2>
                <?php
                if ($satisfactory_rate > 0)
                    echo "<p>(Based on Product Reviews)</p><p style='font-size: 36px; color:#e8b202; font-weight:420;'>" . $satisfactory_rate . "%</p>";
                else
                    echo "<p style='font-size: 20px; color:#e8b202; font-weight:420;'>No reviews found</p>";
                ?>

            </div>

            <div class="pending-orders">
                <?php
                $query = "SELECT COUNT(*) as total FROM orders";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                }
                ?>
                <h2>Pending Orders</h2>
                <p style="font-size: 36px; font-weight: 420;"><?php echo $row['total']; ?></p>
            </div>
        </div>
        <div class="charts">
            <div class="pie-chart">
                <canvas id="pieChart"></canvas> <!-- Added missing canvas -->
                <?php
                // Fetch data for the pie chart
                $pieChartQuery = "
                    SELECT 
                        prod_name, 
                        SUM(prod_quantity) AS total_quantity
                    FROM 
                        c_orders
                    GROUP BY 
                        prod_name
                    ORDER BY 
                        total_quantity DESC
                    LIMIT 5;
                ";
                $pieChartResult = mysqli_query($conn, $pieChartQuery);

                $pieChartData = [];
                if ($pieChartResult && mysqli_num_rows($pieChartResult) > 0) {
                    while ($row = mysqli_fetch_assoc($pieChartResult)) {
                        $pieChartData[] = $row;
                    }
                }
                ?>

                <script>
                    const pieChartData = <?php echo json_encode($pieChartData); ?>;
                </script>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const labels2 = pieChartData.map(item => item.prod_name.split(' ').slice(0, 4).join(' '));
                        const quantities2 = pieChartData.map(item => item.total_quantity);

                        const ctx2 = document.getElementById('pieChart').getContext('2d');
                        new Chart(ctx2, {
                            type: 'pie',
                            data: {
                                labels: labels2,
                                datasets: [{
                                    label: 'Total Quantity Sold',
                                    data: quantities2,
                                    backgroundColor: [
                                        '#1E3A8A', // Deep Blue
                                        '#3B82F6', // Royal Blue
                                        '#10B981', // Teal Green
                                        '#FACC15', // Amber Yellow
                                        '#FB923C' // Soft Orange
                                    ],
                                    borderWidth: 1,
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Top Selling Products',
                                        font: {
                                            size: 24, 
                                            family: 'Monsterrat, sans-serif'
                                        },
                                        color: 'black'
                                    },
                                    legend: {
                                        labels: {
                                            font: {
                                                size: 14
                                            },
                                            color: 'black'
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            title: function(tooltipItems) {
                                                return pieChartData[tooltipItems[0].dataIndex].prod_name; // Show full name on hover
                                            }
                                        },
                                        titleFont: {
                                            size: 16
                                        }, // Increase tooltip title font size
                                        bodyFont: {
                                            size: 14
                                        }
                                    }
                                }
                            }
                        });
                    });
                </script>
            </div>
        </div>
</body>

</html>