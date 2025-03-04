<?php
    include "../dbconn.php"; 
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
        <title>MotoVault</title>
        <link rel="stylesheet" href="../mainFont.css">
        <link rel="stylesheet" href="css/homepage.css">
    </head>
<body>
    <?php
        include("../header.php");
        include('floatingCart.php');
    ?>
    <div class="video-container">
        <video autoplay loop muted id="bg-video">
            <source src="tron1.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="content">
            <div class="left">
                <h1>REV UP YOUR RIDE WITH MOTOVAULT</h1>
                <p>Top-tier gears and accessories for the ultimate motorbike experience</p>
                <button class="slide" onclick="document.getElementById('head').scrollIntoView({ behavior: 'smooth' });">Explore</button>
            </div>
        </div>
    </div>
    <div class="page-content">
        <!-- <div class="content2">
                <div class="right">
                    <h1>DUCATI STREETFIGHTER V4S</h1>
                    <p>The evolution follows that of the Panigale V4 family</p>
                    <button class="slide1">Shop Now</button>
                </div>
            </div> -->

        <div class="heading1" id="head">
            <h1>
            ----------------------------------------       
            Enjoy MotoVault to the fullest       
            --------------------------------------
            </h1>
        </div>

        <div class="products">
            <div class="left" onclick="javascript:window.location='helmets.php'">
                <h1>Helmets</h1>
            </div>
            <div class="center" onclick="javascript:window.location='motorParts.php'">
                <h1>Motorcycle Parts</h1>
            </div>
            <div class="right" onclick="javascript:window.location='gears.php'">
                <h1>Gears and Accessories</h1>
            </div>
        </div>
        <div class="heading2" id="head2">
            <h1>
            ----------------------------------------       
            Browse By Your Favorite Brands     
            --------------------------------------
            </h1>
        </div>
        <div class="brand-strip">
            <div class="box-container">
                <?php
                    $select_product = mysqli_query($conn, "SELECT * FROM `brands`") or die('Query failed.');
                    $max_items = 11; // Set the maximum number of items to display
                    $item_count = 0;

                    if (mysqli_num_rows($select_product) > 0) {
                        while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                            if ($item_count == $max_items) {
                                ?>
                                <div class="box1">
                                    <h2 class="name"><a href="allBrands.php">See More..</a></h2>
                                </div>
                                <?php
                                break;
                            }
                            $item_count++;
                ?>
                            <form method="post" class="box">
                            <a href="brandProducts.php?id=<?php echo $fetch_product['brand_id'];?>">
                                    <img src="../admin/brands/<?php echo $fetch_product['image']; ?>" 
                                alt="<?php echo $fetch_product['name']; ?>" class="image">
                                <div class="name"><?php echo $fetch_product['name']; ?></div></a>
                            </form>
                <?php
                        }
                    }
                ?>
            </div>
        </div>


        <!-- <div class="content2">
            <div class="right">
                <h1>DUCATI STREETFIGHTER V4S</h1>
                <p>The evolution follows that of the Panigale V4 family</p>
                <button class="slide1">Shop Now</button>
            </div>
        </div> -->
        
        <div class="heading3" id="head3" style="text-align: center; margin-top: 13vh; margin-bottom: 12vh;">
            <h1>
            ----------------------------------------       
            Enjoy secure and stressfree shopping with MotoVault     
            ----------------------------------------
            </h1>
        </div>
        <div class="assure">
            <div class="secure">
                <img src="icons/secure.png" alt="Secure">
                <h4>SECURE & SAFE PAYMENT</h4>
                <p>We guarantee the<br> security of all transactions.<br>
                 We also offer financing<br> options with Affirm</p>
            </div>
            <div class="ship">
                <img src="icons/shipping.png" alt="Shipping">
                <h4>FREE SHIPPING</h4>
                <p>Free delivery for <br>all orders above Rs. 20000</p>
            </div>
            <div class="return">
                <img src="icons/return.png" alt="Return">
                <h4>Easy Returns</h4>
                <p>If you want to <br>return the product, <br>
                    you have 10 days to do it</p>
            </div>
        </div>
    </div>
    <script>
        function playPauseVideo() {
    let videos = document.querySelectorAll("bg-video");
    videos.forEach((video) => {
        // We can only control playback without insteraction if video is mute
        video.muted = true;
        // Play is a promise so we need to check we have it
        let playPromise = video.play();
        if (playPromise !== undefined) {
            playPromise.then((_) => {
                let observer = new IntersectionObserver(
                    (entries) => {
                        entries.forEach((entry) => {
                            if (
                                entry.intersectionRatio !== 1 &&
                                !video.paused
                            ) {
                                video.pause();
                            } else if (video.paused) {
                                video.play();
                            }
                        });
                    },
                    { threshold: 0.2 }
                );
                observer.observe(video);
            });
        }
    });
}

// And you would kick this off where appropriate with:
playPauseVideo();
    </script>
    <?php
        include("../footer.php");
    ?>
</body>
</html>