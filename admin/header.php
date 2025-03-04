<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Monsterrat.css">
    <style>
        body{
            margin: 0;
            overflow-x: hidden;
        }
        header
        {
            /* font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 105px; /* Adjust height as needed */
            background-color: transparent; /* Example background color */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10px;
            z-index: 1000; /* Ensure it's above other content */
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
        }
        .img-con {
            width: 150px;
            height: 22vh;
            margin-right: 70px; /* Adjust as needed for more space */
            border-radius: 2px;
            /* background-color: black; */
        }

        header img
        {
            width: 120px;
            height: auto;
            margin-top: 90px;
            padding-right: 90px;
            border-radius: 4px;
            object-fit: cover; /* Ensure the image covers the container */
            transform: scale(2.2); /* Scale the image to make it appear zoomed in */
        }
        nav
        {
            display: flex;
            text-align: center;
            align-content: center;
            justify-content: left;
        }
        nav ul
        {
            justify-content: left;
            align-content: center;
            list-style-type: none;
            display: flex;
        }
        nav li {
            margin: 0 10px;
            display: inline;
        }
        nav ul li a
        {
            text-decoration: none;
            font-size: 24px;
            display: flex;
            position: relative;
            margin: 0 12px;
            color: black;
        }
        nav .animated a::after
        {
            content: '';
            position: absolute;
            background-color: green;
            width: 0;
            height: 4px;
            left: 0;
            bottom:-8px;
            transition: all 0.3s ease;
        }

        nav .animated a:hover {
            color: green;
            /* transition: 0.1s ease-in; */
        }

        nav a:hover::after
        {
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li class="animated"><a href="homepage.php">Dashboard</a></li>
                <li class="animated"><a href="inventory.php">Products/Inventory</a></li>
                <li class="animated"><a href="brandsAndCategories.php">Brands/Categories</a></li>
                <li class="animated"><a href="orders.php">Orders</a></li>
                <li class="animated"><a href="userAccounts.php">Users</a></li>
                <li class="animated"><a href="review.php">Reviews</a></li>
            </ul>
        </nav>
        <div class="img-con">
            <img src="motov2.png" alt="MotoVault">
        </div>
    </header>
</body>
</html>