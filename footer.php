<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="mainFont.css">
    <style>
        html,body
        {
            width: 100%;
            scroll-behavior: smooth;
            /* font-family: 'Oswald', sans-serif; */
        }
        .main-container1
        {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            background-color: black;
        }
        .main-container1 .sub-container1
        {
            width: 100%;
            display: flex;
            justify-content: space-evenly;
            padding: 50px;
        }
        .main-container1 .sub-container1 h2
        {
            color: grey;
            font-weight: lighter;
        }
        .main-container1 .sub-container1 a
        {
            text-decoration: none;
            color: white;
            font-weight:lighter;
            font-size: 14px;
        }
        .main-container1 .sub-container1 a:hover
        {
            color: #f6f610;
        }
        .main-container1 .sub-container2
        {
            max-width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
        .img-container
        {
            margin-top: 5rem;
            background-color: black;
        }
        .img-container .img img
        {
            width: 55vh;
        }
        .img-container .img
        {
            max-width: fit-content;
            margin-left: auto;
            margin-right: auto;
            justify-content: center;
        }
        footer f1
        {
            color: white;
            display: flex;
            text-align: center;
            justify-content: center;
        }
        </style>
</head>
<body>
    <div class="img-container">
        <div class="img">
            <img src="motovb.png" alt="MotoVault">
        </div>
    </div>
    <div class="main-container1">
        <div class="sub-container1">
            <div class="social">
                <h2>Social</h2>
                <a target="_blank" href="https://instagram.com">Instagram</a><br>
                <a target="_blank" href="https://facebook.com">Facebook</a><br>
                <a target="_blank" href="https://x.com">Twitter</a><br>
                <a target="_blank" href="https://youtube.com">YouTube</a>
            </div>
            
            <div class="care">
                <h2>Customer Care</h2>
                <a href="">Contact Us</a><br>
                <a href="../terms/faq.php">FAQ</a><br>
                <a href="../terms/shipping.php">Shipments</a><br>
                <a href="../terms/refund.php">Return & Refunds</a>
            </div>
            
            <div class="fproducts">
                <h2>Products</h2>
                <a href="../terms/warranty.php">Warranty</a><br>
                <a href="../terms/Authenticity.php">Authenticity</a><br>
                <a href="../terms/faq.php">Products FAQ</a><br>
                <a href="../terms/manual.php">User Manuals</a>
            </div>
            
            <div class="legal">
                <h2>Legal</h2>
                <a href="../terms/terms.php">Terms & Condition</a><br>
                <a href="../terms/privacy.php">Privacy Policy</a><br>
                <a href="../terms/">Disclaimer</a><br>
                <a href="../terms/">Code of Ethics</a><br>
                <a href="../terms/">Quality Policy</a><br>
            </div>
        </div>
        <div class="sub-container2">
            <footer>
                <f1>
                    <p>&copy; 2024-MotoVault Nepal,Chris Bhaila, Inc-All rights reserved.</p>
                </f1>
            </footer>
        </div>
    </div>
</body>
</html>