<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../mainFont.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        *
        {
            box-sizing: border-box;
        }
        .floating-btn
        {
            width: 80px;
            height: 80px;
            background: green;
            display: flex;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.25);
            position: fixed;
            right: 25px;
            bottom: 25px;
            z-index: 1000;
            transition: 0.25s ease-in;
            cursor: pointer;
            border: 2px solid green;
        }
        .floating-btn:hover
        {
            background: white;
            color: green;
        }
        .modal-container
        {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease-in;
            z-index: 999;
        }
        .modal-container.show
        {
            pointer-events: auto;
            opacity: 1;
        }
        .modal-overlay
        {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.5); /* Dim the background */
            z-index: 1; /* Layer the overlay below the modal */
        }
        .modal
        {
            background-color: white;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.25);
            max-width: 100%;
            padding: 30px 50px;
            max-height: 80%;
            width: 1000px;
            border-radius: 10px;
            text-align: center;
            position: relative;
            z-index: 2; /* Ensure modal is above the overlay */
        }
        .modal h1
        {
            margin: 0;
        }
        .modal p
        {
            font-size: 14px;
        }
        .close
        {
            background-color: transparent;
            border: none;
            font-size: 24px;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 3; /* Ensure close button is above everything else */
        }
        .con-shop
        {
            background-color: #156ae0;
            color: white;
            border: 1px solid #156ae0;
            font-size: 16px;
            padding: 8px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.15s linear;
        }
        .con-shop:hover
        {
            background-color: darkgray;
            border: 1px solid darkgray;
        }
        .check-out
        {
            font-family:Arial, Helvetica, sans-serif;
            background-color: green;
            color: white;
            border: 1px solid green;
            font-size: 16px;
            padding: 8px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.15s linear;
            text-decoration: none;
        }
        .check-out:hover
        {
            background-color: darkgray;
            border: 1px solid darkgray;
        }
        .remove-btn
        {
            text-decoration: none;
            color: black;
            background-color: transparent;
            border: none;
            cursor: pointer;
            transition: 0.1s linear;
            padding: 4px;
            border-radius: 4px;
            font-size: 28px;
        }
        .remove-btn:hover
        {
            color: red;
        }
        .remove-btn1
        {
            text-decoration: none;
            color: black;
            /* background-color: darkgray;*/
            border: 2px solid black;
            cursor: pointer;
            transition: 0.1s linear;
            padding: 4px;
            font-size: 16px;
            border-radius: 4px;
            font-family: 'Oswald', sans-serif;
        }
        .remove-btn1:hover
        {
            background-color: crimson;
            border: 2px solid crimson;
            color: white;
        }
        .table-bordered tr td
        {
            padding: 6px;
        }
    </style>
</head>
<body>
    <button class="material-icons floating-btn" id="open">shopping_cart</button>
    <div class="modal-container" id="modal_container">
        <!-- Overlay for dimming background -->
        <div class="modal-overlay"></div>
        <div class="modal">
            <h1>Your Cart Overview</h1>
            <div class="cart-table">
                <table class="table table-bordered" style="width:100%;">
                    <tr style="height: 16px;"></tr>
                    <?php
                        $cookie_name = "shopping_cart";
                        if (isset($_COOKIE[$cookie_name])) {
                            $total = 0;
                            $cookie_data = stripslashes($_COOKIE[$cookie_name]);
                            $cart_data = json_decode($cookie_data, true);
                        
                            $items_found = false; // Track if items exist for the current user
                            $index=1;
                            foreach ($cart_data as $keys => $values) {
                                // Ensure the item belongs to the logged-in user
                                    if ($values["user_id"] == $_SESSION['UID']) {
                                        $items_found = true; // Set flag if an item is found
                                    }
                                }
                                if($items_found==true)
                                {
                            ?>
                                <tr style="font-size: 20px;">
                                    <th width="10%">S.N.</th>
                                    <th width="37%" style="text-align: left;">Item Name</th>
                                    <th width="15%">Item Price</th>
                					<th width="10%">Quantity</th>
                					<th width="15%">Total</th>
                                    <th width="13%">Action</th>
                                </tr>
                            <?php
                                }
                            foreach ($cart_data as $keys => $values) {
                                // Ensure the item belongs to the logged-in user
                                    if ($values["user_id"] == $_SESSION['UID']) {
                                        $items_found = true; // Set flag if an item is found
                                        ?>
                                        <tr>
                                            <td style="text-align: center;"><?php echo $index++; ?></td>
                                            <td style="text-align: left;"><?php echo $values["item_name"]; ?></td>
                                            <td style="text-align: center;"><?php echo "Rs. " . number_format($values["item_price"], 2); ?></td>
                                            <td style="text-align: center;"><?php echo $values["item_quantity"]; ?></td>
                                            <td style="text-align: center;">Rs. <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
                                            <td style="text-align: center;">
                                                <button onclick="removeFromCart(<?php echo $values['item_id']; ?>, <?php echo $_SESSION['UID']; ?>)" class="remove-btn">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                            $total = $total + ($values["item_quantity"] * $values["item_price"]);

                                    }
                            }
                        
                            // Display total if items were found
                            if ($items_found) {
                                ?>
                                <tr style="height: 16px;"></tr>
                                <tr style="border-top: 1px solid black;">
                                    <td></td>
                                    <td style="text-align: left; font-size: 20px;"><strong>Total</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: center; font-size: 18px; color: green;"><?php echo "Rs. " . number_format($total, 2); ?></td>
                                    <td style="text-align: center;">
                                        <button onclick="removeAll(<?php $_SESSION['UID']?>)" class="remove-btn1"><b>Clear Cart</b></button>
                                    </td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td colspan="6"><p style="color: red; font-size:16px">
                                        Prices are VAT inclusive and delivery charge will be calulated during checkout
                                    </p></td>
                                </tr>
                                <tr style="height: 16px;"></tr>
                                <tr>
                                    <td></td>
                                    <td colspan="5" style="text-align: right;"><button id="close1" class="con-shop">Continue Shopping</button>
                                    <a href="checkout.php" class="check-out">Continue to Checkout</a></td>
                                </tr>
                                <?php
                            } else {
                                // No items for the current user
                                ?>
                                <div clas="empty" style="text-align: center;">
                                    <img src="icons/box.png" alt="Empty" width="200px"
                                    style="margin-top:20px;">
                                    <p style="font-size: 20px;">Your cart is empty.</p>
                            </div>
                            <tr style="text-align: center;"><button id="close1" class="con-shop">Continue Shopping</button></tr>
                                <?php
                            }
                        } else {
                            // Cookie does not exist or is empty
                            ?>
                            <div clas="empty" style="text-align: center;">
                                    <img src="icons/box.png" alt="Empty" width="200px"
                                    style="margin-top:20px;">
                                    <p style="font-size: 20px;">Your cart is empty.</p>
                            </div>
                            <tr style="text-align: center;"><button id="close1" class="con-shop">Continue Shopping</button></tr>
                            <?php
                        }                        
                    ?>
                </table>
            </div>
            <button id="close" class="close">X</button>
        </div>
    </div>
    <script src="cookie.js"></script>
    <script>
        const open = document.getElementById('open');
        const modal_container = document.getElementById('modal_container');
        const close = document.getElementById('close');
        const close1 = document.getElementById('close1');

        open.addEventListener('click', () => {
            modal_container.classList.add('show');
        });
        close.addEventListener('click', () => {
            modal_container.classList.remove('show');
        });
        close1.addEventListener('click', () => {
            modal_container.classList.remove('show');
        });
    </script>
</body>
</html>
