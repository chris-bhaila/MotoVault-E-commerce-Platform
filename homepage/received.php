<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Monsterrat.css">
    <title>Payment Animation</title>
    <style>
        .payment-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 10vh;
            font-family: 'Monsterrat', sans-serif;
        }

        .payment-animation {
            text-align: center;
        }

        .circle {
            width: 100px;
            height: 100px;
            background-color: #4caf50;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            animation: pop-in 0.5s ease-out;
        }

        .tick {
            width: 50px;
            height: 25px;
            border: 5px solid white;
            border-top: none;
            border-right: none;
            transform: rotate(-45deg);
            opacity: 0;
            animation: draw-tick 0.5s 0.5s ease-out forwards;
            margin-bottom: 15px;
        }

        .payment-animation p {
            margin-right: 40px;
            margin-left: -30px;
            margin-top: 20px;
            font-size: 18px;
            color: #333;
            opacity: 0;
            animation: fade-in 0.5s 1s ease-out forwards;
        }

        @keyframes pop-in {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes draw-tick {
            0% {
                opacity: 0;
                transform: scale(0.5) rotate(-45deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotate(-45deg);
            }
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="payment-wrapper">
        <div class="payment-animation">
            <div class="circle">
                <div class="tick"></div>
            </div>
            <p>Payment Received</p>
        </div>
    </div>
</body>
</html>
