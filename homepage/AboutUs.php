<?php
    session_start();
    include("../dbconn.php");
    if(!isset($_SESSION['UID'])) {
        header('location: ../SignIn.php');
        die(); // Stop further execution
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About Us</title>
        <link rel="stylesheet" href="../mainFont.css">
        <link rel="stylesheet" href="../mainFont2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            body
            {
                padding: 0;
                font-family: 'Oswald', sans-serif;
            }
            .all
            {
                padding: 0;
            }

            /* .top img
            {
                width: inherit;
                height: 450px;
                background-color: transparent;
                color: white;
                display: flex;
                background-image: url('about.jpg');
                background
            } */
            .story
            {
                display: flex;
                justify-content: space-evenly;
                padding-top: 65px;
                align-items: center;
                color: black;
            }
            .story .left
            {
                margin-left: 20px;
                margin-right: 60px;
                width: 600px;
            }

            .story .left h2
            {
                font-size: 2.5rem;
            }
            .story .right
            {
                width: 45rem;
                height: 25rem;
                background-image: url('aboutUs/garage.jpg');
                background-size: contain;
                border-radius: 20px;
                box-shadow: 0 7px 25px rgba(0, 0, 0, 0.34);
                margin-top: 40px;
                display: flex;
                justify-content: center;
                align-items: center;
                /* animation: imageLoop 2s linear; */
                transition: background-image 1s linear;
            }
            .meet
            {
                display: flex;
                justify-content: space-evenly;
                padding-top: 65px;
                color: black;
            }
            .meet .left
            {
                width: 45rem;
                height: 25rem;
                background-image: url('aboutUs/room.png');
                background-size: cover;
                background-repeat: no-repeat;
                border-radius: 20px;
                box-shadow: 0 7px 25px rgba(0, 0, 0, 0.34);
                margin-top: 40px;
            }
            .meet .right
            {
                margin-right: 20px;
                margin-left: 60px;
                width: 600px;
                text-align: justify;
            }
            .meet .right h2
            {
                font-size: 2.5rem;
            }

            .cert
            {
                display: flex;
                justify-content: space-evenly;
                padding-top: 65px;
                color: black;
            }
            .cert .left
            {
                margin-left: 20px;
                margin-right: 60px;
                width: 600px;
                text-align: justify;
            }

            .cert .left h2
            {
                font-size: 2.5rem;
            }
            .cert .right
            {
                width: 45rem;
                height: 25rem;
                background-image: url('aboutUs/journey.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                border-radius: 20px;
                box-shadow: 0 7px 25px rgba(0, 0, 0, 0.34);
                margin-top: 40px;
                display: flex;
                align-items: center;
                /* animation: imageLoop 2s linear; */
                transition: background-image 1s linear;
            }
            .links h2
            {
                margin-left: 140px;
                color: black;
            }
            .social-links 
            {
                display: flex;
                justify-content: space-around;
                margin-top: 20px;
            }

            .social-link 
            {
                text-align: center;
                text-decoration: none;
                color: black;
                transition: color 0.3s ease;
            }

            .social-link img 
            {
                width: 30px;
                height: 30px;
                margin-bottom: 5px;
            }

            .social-link:hover 
            {
                color: #e8491d;
            }
            .left p{
                font-size: 16px;
                text-align: justify;
            }
            .contact-form button
            {
                background-color: #e8491d;
                color: #fff;
                font-size: 14px;
                padding: 8px 8px;
                text-decoration: none;
                border-radius: 7px;
                margin-left: 8px;
                transition: background-color 0.3s ease;
                cursor: pointer;
                border: 2px solid;
            }
            .contact-form button:hover
            {
                background-color: white;
                color: #e8491d;
                border: 2px solid;
            }
            .join
            {
                display: flex;
            }
            .join img
            {
                padding-right: 30px;
            }
        </style>
    </head>
    <body>
        <header style="font-family: 'Oswald', sans-serif;">
        <?php
            include("../header1.php");
        ?>
        </header>
        <div class="all" style="font-family: 'Monsterrat', sans-serif;">

            <div class="story">
                <div class="left">
                <h2>Our Story</h2>
                <p>In a small garage nestled in the heart of a bustling city, two friends, Arun and Ramesh, bonded over their shared love for motorcycles. The garage was more than just a place to tinker with bikes; 
                    it was a sanctuary where passion and innovation collided. Both were avid riders who often struggled to find quality parts and gear that didn’t burn a hole in their pockets.
                    <br>
                    One fateful evening, as they sat amidst grease-streaked tools and half-assembled motorcycles, Ramesh voiced his frustration:
                    "Why is it so hard to find reliable parts? We spend hours searching, only to be let down."
                    <br>
                    Arun nodded in agreement, an idea forming in his mind. "What if we created a place for riders like us? A one-stop shop where quality meets affordability. A vault for everything a rider could ever need."
                    <br>
                    And so, MotoVault was born.
                    <br>
                </p>
                </div>
                <div class="right">
                </div>
            </div>

            <div class="meet">
                <div class="left">
                <!-- <img src="chef-image.jpeg" alt="Chef Image" class="chef-image" width="200" height="150">  -->
                </div>
                <div class="right">
                    <h2>The Vision</h2>
                    <p>MotoVault started as a small online store run from that very garage. The duo pooled their savings, sourced high-quality parts, and reached out to fellow riders for feedback. 
                        They wanted MotoVault to be more than just a store—it would be a community, a trusted ally for riders.<br>
                        Their commitment was simple:
                        <br>
                        <li>Quality: Every product, from helmets to engine parts, was rigorously tested to ensure it met the highest standards.</li>
                        <li>Affordability: They believed in making quality gear accessible to all riders, whether they were seasoned enthusiasts or beginners.</li>
                        <li>Trust: MotoVault offered a transparent shopping experience, complete with reviews, detailed descriptions, and exceptional customer service.</li>

                    </p>
                </div>
            </div>

            <div class="cert">
                <div class="left">
                <h2>The Journey</h2>
                    <p>As word spread, MotoVault grew beyond the garage. Riders from across the country began to trust the platform for their motorcycle needs. 
                        The team expanded, and so did their catalog—offering everything from sleek riding jackets to high-performance sprockets.
                        <br>
                        MotoVault wasn’t just a business; it was a revolution in the motorcycling world. Arun and Ramesh hosted meet-ups, organized riding events, and even partnered with local mechanics to offer exclusive services.
                    </p>
                </div>
                <div class="right">

                </div>
             </div>
             
            <div class="links">
                <h2>Follow Us on Social Media</h2>
                <div class="social-links">
                <a href="https://www.facebook.com/yourrestaurant" target="_blank" class="social-link">
                    <i class="fa-brands fa-facebook"></i>
                    Facbeook
                </a>
                <a href="https://twitter.com/yourrestaurant" target="_blank" class="social-link">
                    <i class="fa-brands fa-twitter"></i>
                    Twitter
                </a>
                <a href="https://www.instagram.com/yourrestaurant" target="_blank" class="social-link">
                    <i class="fa-brands fa-instagram"></i>
                    Instagram
                </a>
                </div>
            </div>
        </div>    
        <?php
            include("../footer.php");
        ?>
    </body>
</html>