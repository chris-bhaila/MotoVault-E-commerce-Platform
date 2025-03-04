<?php
    include('../dbconn.php');
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
            background-color: white;
            font-family: 'Monsterrat', sans-serif;
        }
        .container
        {
            margin-top: 90px;
            padding: 40px;
        }
        /* .container .analytics1
        {
            width: 92vw;
            height: 40vh;
            justify-content: space-between;
            margin-bottom: 60px;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.2);
            background: url('white-topo1.jpeg');
            background-position: center;
            background-size: cover;
            margin-right: 100px;
        }

        .container .analytics1 p
        {
            font-size: 30px;
            font-weight: 600;
            color: white;
        } */
        .management {
            display: flex;
            flex-wrap: wrap; /* Allows items to wrap onto the next row */
            justify-content: space-between; /* Ensures even spacing */
            height: auto; /* Allow the container height to adjust dynamically */
            width: 95vw;
        }

        .management .categories,
        .management .sub-categories,
        .management .brands {
            flex: 0 0 48%; /* Ensures each item takes 48% of the row's width */
            margin-bottom: 20px; /* Adds spacing between rows */
            height: 22vh;
        }
        .management .categories
        {
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
        .management .sub-categories
        {
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
        .management .brands
        {
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
        .management .categories:hover,
        .management .sub-categories:hover,
        .management .brands:hover
        {
            box-shadow: 0 6px 25px rgba(0,0,0, 0.5);
        }
        .management .categories h3,
        .management .sub-categories h3,
        .management .brands h3
        {
            margin-top: 10px;
            margin-bottom: 20px;
            margin-left: 20px;
        }
        .management .categories p,
        .management .sub-categories p,
        .management .brands p
        {
            font-size: 24px;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <?php
        include('header.php');
    ?>
    <div class="container">
        <div class="analytics1">
           
        </div>
        <div class="management">
            <?php
                $query1 = "SELECT COUNT(*) as total_categories FROM categories"; // Use COUNT to get the total number of users
                $result1 = mysqli_query($conn, $query1);
                
                $total_categories = 0; // Default value in case query fails
                if ($result1 && mysqli_num_rows($result1) > 0) {
                    $row1 = mysqli_fetch_assoc($result1);
                    $total_categories = $row1['total_categories']; // Fetch the count from the result
                }
            ?>
            <a href="manage-category.php" class="categories">
                <h3>Manage Categories&#x2192;</h3>
                <p>Current number of categories: <?php echo $total_categories ?></p>
            </a>
            <?php
                $query2 = "SELECT COUNT(*) as total_sub_categories FROM sub_category"; // Use COUNT to get the total number of users
                $result2 = mysqli_query($conn, $query2);
                
                $total_sub_categories = 0; // Default value in case query fails
                if ($result2 && mysqli_num_rows($result2) > 0) {
                    $row2 = mysqli_fetch_assoc($result2);
                    $total_sub_categories = $row2['total_sub_categories']; // Fetch the count from the result
                }
            ?>
            <a href="sub-category.php" class="sub-categories">
                <h3>Manage Sub-categories&#x2192;</h3>
                <p>Current number of sub-categories: <?php echo $total_sub_categories ?></p>
            </a>
            <?php
                $query3 = "SELECT COUNT(*) as total_brands FROM brands"; // Use COUNT to get the total number of users
                $result3 = mysqli_query($conn, $query3);
                
                $total_brands = 0; // Default value in case query fails
                if ($result3 && mysqli_num_rows($result3) > 0) {
                    $row3 = mysqli_fetch_assoc($result3);
                    $total_brands = $row3['total_brands']; // Fetch the count from the result
                }
            ?>
            <a href="manage-brands.php" class="brands">
                <h3>Manage Brands&#x2192;</h3>
                <p>Current number of brands: <?php echo $total_brands ?></p>
            </a>
        </div>
    </div>
</body>
</html>