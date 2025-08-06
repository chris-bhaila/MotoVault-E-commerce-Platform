<?php
    include("../dbconn.php");
    if(!isset($_SESSION['UID'])) 
    {
        header('location: ../SignIn.php');
        die(); // Stop further execution
    }
    $uid=$_SESSION['UID'];
    $query1 = "SELECT * FROM user WHERE id = $uid";
    $result1 = mysqli_query($conn, $query1);
    
    if (mysqli_num_rows($result1) > 0) 
    {
        $row1 = mysqli_fetch_assoc($result1);
    }
    $name=explode(" ", $row1['name'])[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="mainFont2.css">
    <style>
        body{
            margin: 0;
            overflow-x: hidden;
        }
        header
        {
            position: absolute;
            font-family: 'Oswald','sans-serif';
            top: 0;
            left: 0;
            width: 100%;
            height: 105px; /* Adjust height as needed */
            background-color: transparent; /* Example background color */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
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
            display: flex;
        }

        header img
        {
            text-align: center;
            justify-content: center;
            width: 120px;
            height: fit-content;
            margin-top: 75px;
            margin-right: 4px;
            border-radius: 4px;
            object-fit: cover; /* Ensure the image covers the container */
            transform: scale(1.3); /* Scale the image to make it appear zoomed in */
            
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
            letter-spacing: 0.5px;
            margin: 0 45px;
            font-weight: bold;
            color: white;
        }
        nav .animated a::after
        {
            content: '';
            position: absolute;
            background-color: #feff00;
            width: 0;
            height: 4px;
            left: 0;
            bottom:-8px;
            transition: all 0.3s ease;
        }

        nav .animated a:hover {
            color: #feff00;
            /* transition: 0.1s ease-in; */
        }

        nav a:hover::after
        {
            width: 100%;
        }
    </style>
</head>
<body>
    <header style="font-family: 'Oswald', sans-serif;">
        <nav>
            <ul>
                <li class="animated"><a href="homepage.php">Home</a></li>
                <li class="animated"><a href="helmets.php">Helmets</a></li>
                <li class="animated"><a href="motorParts.php">Motorcycle Parts</a></li>
                <li class="animated"><a href="gears.php">Riding Gears</a></li>
                <li class="animated"><a href="AboutUs.php">About Us</a></li>
                <li class="animated"><a href="dashboard.php"><?php echo $name."'s " ?>Vault</a></li>
            </ul>
        </nav>
        <div class="img-con">
            <img src="logos/tmoto_zoom.png" alt="MotoVault">
        </div>
    </header>
</body>
</html>