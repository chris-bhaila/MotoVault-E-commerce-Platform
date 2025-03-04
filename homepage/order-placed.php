<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Monsterrat.css">
    <title>Thank you for your order</title>
    <style>
        body
        {
            font-family: "Monsterrat", sans-serif;
            background: url('iom.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: right;
            width: 100vw;
            height: 100vh;
            overflow-x: hidden;
            overflow-y: hidden;
            backdrop-filter: blur(3px);
            color: white;
        }
        .container
        {
            background-color: transparent;
            position: relative;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -150%);
            padding: 10px;
            text-align: center; /* Align center for all content */
        }
        .container p
        {
            font-size: 18px;
        }
        .container a
        {
            color: white;
            font-size: 18px;
        }
        .container h1
        {
            font-size: 46px;
        }
        .logo
        {
            display: flex;
            justify-content: center;
            align-content: center;
        }
        .logo img 
        {
            transform: scale(1.4);
            height: 160px;
            width: fit-content;
            margin-top: 120px;
        }
    </style>
</head>
<body>
<div class="logo">
    <img src="tmoto_zoom.png" alt="MotoVault">
</div>
<div class="container">
    <h1>Thank you for your order!</h1>
    <p>Your order has been successfully placed! Please take a moment to leave a <a href="homepage/Review.php">review</a>. 
    <br>Our delivery team will ensure your order reaches you within the next 3-4 days</p>
    <a class="hp" href="helmets.php"> Continue ordering </a><br><br>
    <a class="hp" href="homepage.php"> Back to Homepage </a>
</div>
</body>
</html>
