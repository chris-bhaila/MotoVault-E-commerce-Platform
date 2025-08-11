<?php
    include("../dbconn.php");
    session_start();
    if(!isset($_SESSION['UID'])) {
        header('location: ../SignIn.php');
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands</title>
    <link rel="stylesheet" href="../mainFont.css">
    <link rel="stylesheet" href="../mainFont2.css">
    <style>
        .brand-strip
        {
            margin-top: 6vh;
            margin-left: 20vh;
            margin-right: 20vh;
            margin-bottom: 10vh;
        }
        .brand-strip .box-container
        {
            width: inherit;
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 3vh;
        }
        .brand-strip .box-container .box {
            width: 120px;
            height: 160px;
            padding-top: 2vh;
            margin-left: 6.5vh;
            margin-top: 3vh;
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Vertically center content */
            align-items: center;     /* Horizontally center content */
            position: relative; /* Needed for absolute positioning of the .name */
        }

        .brand-strip .box-container .box:hover {
            transform: scale(1.22);
        }

        .brand-strip .box-container .box a {
            width: 120px;
            height: fit-content;
            cursor: pointer;
            align-self: center; /* Center the image horizontally */
            margin-bottom: 4vh;
            color: black;
        }
        .brand-strip .box-container .box img {
            width: 120px;
            height: fit-content;
            cursor: pointer;
            align-self: center; /* Center the image horizontally */
        }

        .brand-strip .box-container .box .name {
            text-align: center;
            cursor: pointer;
            position: absolute; /* Position the name at the bottom of the box */
            bottom: 0; /* Align it at the bottom */
            width: 100%; /* Ensure it takes full width */
            align-items: center;
        }

        .brand-strip .box-container .box1
        {
            align-items: center;
            margin-top: 70px;
            padding-top: 3vh;
            margin-left: 6.5vh;
            transition: 0.1s ease-in;
            cursor: pointer;
        }
        /* .brand-strip .box-container .box1 h2
        {
            transition: 0.2s ease-in;
            cursor: pointer;
        } */
        .brand-strip .box-container .box1:hover
        {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header style="font-family: 'Oswald','sans-serif';">
    <?php
        include("../header1.php");
    ?>
    </header>
    <?php
        include("floatingCart.php");
    ?>
    <div class="brand-strip">
        <h1 style="text-align: center; font-size: 2.5em; margin-bottom: 3vh; font-family:'Oswald','sans-serif';">
            --------------------------------------
            Brands we offer
            --------------------------------------
        </h1>
            <div class="box-container" style="font-family: 'Monsterrat','sans-serif';">
                <?php
                    $select_product = mysqli_query($conn, "SELECT * FROM `brands`") or die('Query failed.');

                    if (mysqli_num_rows($select_product) > 0) {
                        while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                ?>
                            <form method="post" class="box" style="cursor: pointer;">
                                <a href="brandProducts.php?id=<?php echo $fetch_product['brand_id'];?>">
                                    <img src="../admin/brands/<?php echo $fetch_product['image']; ?>" 
                                alt="<?php echo $fetch_product['name']; ?>" class="image">
                                <div class="name" style="font-weight: 500;"><?php echo $fetch_product['name']; ?></div></a>
                            </form>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
</body>
</html>