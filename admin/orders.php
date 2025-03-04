<?php
include('../dbconn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            width: 92vw;
            height: 40vh;
            /* border: 2px solid black; */
            justify-content: space-between;
            margin-bottom: 60px;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.2);
            background: url('brown.jpeg');
            background-position: center;
            background-size: cover;
            margin-right: 100px;
        }

        .container .analytics1 p {
            font-size: 30px;
            font-weight: 600;
            color: white;
        }

        .management {
            display: flex;
            flex-wrap: wrap;
            /* Allows items to wrap onto the next row */
            justify-content: space-between;
            /* Ensures even spacing */
            height: auto;
            /* Allow the container height to adjust dynamically */
            width: 95vw;
        }

        .management .categories,
        .management .sub-categories,
        .management .brands {
            flex: 0 0 48%;
            /* Ensures each item takes 48% of the row's width */
            margin-bottom: 20px;
            /* Adds spacing between rows */
            height: 22vh;
        }

        .management .categories {
            width: 48%;
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            margin-right: 30px;
            text-decoration: none;
            color: black;
            font-size: 32px;
            padding-left: 12px;
            padding-top: 30px;
            transition: 0.3s linear;
        }

        .management .sub-categories {
            width: 48%;
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            text-decoration: none;
            color: black;
            font-size: 32px;
            padding-left: 12px;
            padding-top: 30px;
            transition: 0.3s linear;
        }

        .management .sub-categories:hover,
        .management .categories:hover {
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.5);
        }

        .management .brands {
            width: 48%;
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            text-decoration: none;
            color: black;
            font-size: 32px;
            padding-left: 12px;
            padding-top: 30px;
        }

        .management .categories li,
        .management .sub-categories li {
            font-size: 20px;
            margin-left: 10px;
        }

        .management .categories h3,
        .management .sub-categories h3 {
            margin-top: 10px;
            margin-bottom: 20px;
        }

    </style>
</head>

<body>
    <?php
    include('header.php');
    ?>
    <div class="container">
        <div class="analytics1">
            <h1 style="font-size: 42px; color: white;"><u>Order Overview</u></h1>
            <?php
            $query = "SELECT COUNT(*) as total FROM orders";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            }
            ?>
            <p>Total Pending Orders: <?php echo $row['total'] ?></p>
            <?php
            // Query to get completed orders
            $query1 = "SELECT prod_price, prod_quantity FROM c_orders";
            $result1 = mysqli_query($conn, $query1);

            // Initialize variables
            $sub_total = 0; // Initialize subtotal
            $total_orders = 0; // Initialize total orders counter

            if ($result1 && mysqli_num_rows($result1) > 0) {
                while ($row = mysqli_fetch_assoc($result1)) {
                    $sub_total += $row['prod_price'] * $row['prod_quantity']; // Calculate subtotal
                    $total_orders++; // Count total orders
                }
            }
            ?>
            <p>Total Completed Orders: <?php echo $total_orders; ?></p>
            <p>Total Revenue Generated: <?php echo "Rs. " . number_format($sub_total); ?></p>
        </div>

        <div class="management">
            <a href="pending-orders.php" class="categories">
                <h3>Manage Pending Orders&#x2192;</h3>
                <li>Complete or Remove Orders</li>
            </a>
            <a href="completed-orders.php" class="sub-categories">
                <h3>Order History&#x2192;</h3>
                <li>Check Completed Orders</li>
            </a>
        </div>
    </div>
</body>

</html>