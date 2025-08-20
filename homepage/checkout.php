<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="jquery-3.7.1.min.js"></script>
<?php
include("../dbconn.php");
session_start();
if (!isset($_SESSION['UID'])) {
    header('location: ../SignIn.php');
    die();
}
$id = $_SESSION['UID'];
$query = "SELECT * FROM user WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
}
if (isset($_POST['order'])) {
    $bulk_id = mysqli_real_escape_string($conn, $_POST['bulk_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $ph_num = mysqli_real_escape_string($conn, $_POST['ph_num']);
    $alt_ph_num = mysqli_real_escape_string($conn, $_POST['alt_ph_num']);
    $street_name = mysqli_real_escape_string($conn, $_POST['street_name']);
    $tole = mysqli_real_escape_string($conn, $_POST['tole']);
    $municipality = mysqli_real_escape_string($conn, $_POST['municipality']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

    $cart_data = isset($_COOKIE['shopping_cart']) ? json_decode($_COOKIE['shopping_cart'], true) : [];

    foreach ($cart_data as $item) {
        $prod_id = mysqli_real_escape_string($conn, $item['item_id']);
        $prod_name = mysqli_real_escape_string($conn, $item['item_name']);
        $prod_price = mysqli_real_escape_string($conn, $item['item_price']);
        $prod_quantity = mysqli_real_escape_string($conn, $item['item_quantity']);
        $user_id = mysqli_real_escape_string($conn, $item['user_id']);

        // Insert order details into the orders table
        if($user_id == $id) {
        $sql = "INSERT INTO `orders` 
                (bulk_id, user_id, product_id, name, email, ph_num, alt_ph_num, prod_name, prod_price, prod_quantity, street_name, tole, municipality, district, payment_method) 
                VALUES 
                ('$bulk_id', '$user_id', '$prod_id', '$name', '$email', '$ph_num', '$alt_ph_num', '$prod_name', '$prod_price', '$prod_quantity', '$street_name', '$tole', '$municipality', '$district', '$payment_method')";

        $result = mysqli_query($conn, $sql);
        }

        if (!$result) {
            echo "<script>alert('Error inserting order: " . mysqli_error($conn) . "');</script>";
            break; // Stop the loop if there's an error
        }

        // Reduce the stock in the motoproducts table
        $update_stock_sql = "UPDATE `motoproducts` 
                             SET `stock` = `stock` - '$prod_quantity' 
                             WHERE `product_id` = '$prod_id'";
        $update_result = mysqli_query($conn, $update_stock_sql);

        if (!$update_result) {
            echo "<script>alert('Error updating stock: " . mysqli_error($conn) . "');</script>";
            break; // Stop the loop if there's an error
        }
    }

    if ($result && $update_result) { // Ensure both queries are successful
        echo "<script>alert('Order Placed Successfully');</script>";

        // Filter out only items of the current user
        $updated_cart = array_filter($cart_data, function($item) use ($id) {
            return $item['user_id'] != $id; // keep items that are NOT from this user
        });

        // Reset cookie with remaining items
        if (!empty($updated_cart)) {
            setcookie('shopping_cart', json_encode(array_values($updated_cart)), time() + (86400 * 30), '/');
        } else {
            setcookie('shopping_cart', '', time() - 3600, '/'); // delete if empty
        }

        header('Location: order-placed.php');
        exit();
    } else {
        echo "<script>alert('Error placing the order.');</script>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="newbutton.css">
    <style>
        body
        {
            font-family: "Monsterrat", sans-serif;
            /* padding: 40px; */
            margin: 0;           /* Remove any default margin */
            padding: 0;          /* Remove any default padding */
            width: 100%;         /* Ensure full width */
            height: 100%;
            overflow-x: hidden;
        }
        .logo-img
        {
            background-color: black;
            text-align: center;
            /* border-bottom: 2px solid gray; */
            height:40vh;
            position: relative;
            width: 100%;
            top: 0;
            left: 0;
            box-shadow: 0 8px 10px 0 rgba(0, 0, 0, 0.6);
            border-radius: 4px;
        }
        .logo-img img
        {
            margin-top: 40px;
        }
        .summary
        {
            padding-bottom: 30px;
            border-bottom: 2px solid gray;
        }
        .main-container
        {
            font-family: "Montserrat", sans-serif;
            padding-top: 30px;
            padding-left: 50px;
            padding-right: 50px;
        }
        .list
        {
            width: 50vw;
            display: flex;
            justify-content: space-between;
            padding-left: 20px;
            padding-right: 20px;
        }
        .personal-details,
        .location-details
        {
            padding-left: 35px;
            padding-right: 30px;
            font-size: 24px;
            font-weight: 400;
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 2px solid gray;
        }
        .personal-details label.form-data,
        .location-details label.form-data
        {
            margin-bottom: 40px;
            font-weight: 500;
        }
        .personal-details input,
        .location-details input
        {
            height: 40px;
            width: 40vw;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 2.3px solid;
            font-size: 20px;
            font-family: monospace;
            padding-left: 15px;
        }
        .personal-details input::-webkit-outer-spin-button,
        .personal-details input::-webkit-inner-spin-button 
        {
            -webkit-appearance: none;
            margin: 0;
        }
        .cart-details
        {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 2px solid gray;
        }
        .cart-details .table-bordered td
        {
            font-weight: 500;
            font-size: 18px;
        }
        .cart-details .table-bordered th
        {
            font-size: 22px;
        }
        .table-bordered .img-center
        {
            display: block;
            margin-left: -70px;
            margin-right: auto;
        }
        .remove-btn
        {
            text-decoration: none;
            color: black;
            background-color: white;
            border: none;
            cursor: pointer;
            transition: 0.1s linear;
            padding: 4px;
            font-size: 28px;
            border-radius: 4px;
            font-family: 'Oswald', sans-serif;
        }
        .remove-btn:hover
        {
            color: crimson;
        }
        .payment-details
        {
            margin-top: 40px;
            /* position: fixed; */
            display: flex;
            width: 100%;
            justify-content: space-evenly;
            height: 350px;
        }
        .payment-details img
        {
            width: fit-content;
            height: 200px;
        }
        .cod,.avail
        {
            position: relative;
            width: 500px;
            height: 280px;
            border: 2px solid darkgrey;
            background-color: #F7F7FA;
            text-align: center;
            align-content: center;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.1s linear;
            margin: 0;
            transition: all 0.1s linear
        }
        .cod:hover,
        .avail:hover
        {
            outline: 4px solid #76A7E1;
        }
        .disabled {
            pointer-events: none;  /* Disable all interactions */
            opacity: 0.5;  /* Reduce opacity to give a "disabled" look */
            background-color: #f0f0f0;  /* Optionally, change background */
            cursor: not-allowed;
        }
        input[type=radio] {
        position:absolute;
        left:-10000px;
        top:auto;
        width:1px;
        height:1px;
        overflow:hidden;
        }

        input[type=radio] {
        margin: 4px;
        box-sizing: content-box;
        }
        .glow {
            border: 4px solid #76a7e1;
            transition: 0.1s linear;
        }
        .order-btn
        {
            display: flex;
            flex-direction: column;
        }
        .tick-anim
        {
            padding-left: 35px;
            padding-right: 30px;
            font-size: 24px;
            font-weight: 400;
            margin-bottom: 10px;
            padding-bottom: 30px;
            margin-left: 40px;
        }
        .hiddenBtn
        {
            position: relative; /* Absolute positioning for the button */
            left: 50%; /* Move to the center horizontally */
            top: 50%; /* Move to the center vertically */
            transform: translate(-50%, -50%); /* Adjust back by 50% of its own size */
            display: none;
            width: 50%;
            font-family: "Monsterrat", sans-serif;
            padding: 12px;
            background-color: green;
            color: white;
            font-size: 18px;
            border-radius: 30px;
            border: 2px solid green;
            cursor: pointer;
            transition: 0.2s linear;
            font-weight: bold;
            margin-top: 20px;
        }
        .hiddenBtn:hover
        {
            background-color: white;
            color: green;
        }
    </style>
</head>
<body>
    <div class="logo-img">
        <img src="logos/tmoto_zoom.png" alt="MotoVault" width="250px">
        <h1 style="color: white;">We deliver, you power through.</h1>
        <br><br>
    </div>
    <div class="main-container">
        <div class="summary">
            <h1>Order Summary</h1>
            <div class="list">
                <div class="first">
                    <h2>Items</h2>
                    <p>2 items</p>
                </div>
                <div class="second">
                    <h2>Total Quantity</h2>
                    <p>2 items</p>
                </div>
                <div class="third">
                    <h2>Price</h2>
                    <p>2 items</p>
                </div>
                <div class="fourth">
                    <h2>Delivery Time</h2>
                    <p>1-2 days</p>
                </div>
            </div>
        </div>
        <div class="info-container1">
            <form action="" method="post" class="details">
                <h2>&#x2460 Verify Personal Details</h2>
                <div class="personal-details">
                    <input type="hidden" name="bulk_id" value="
                        <?php
                            date_default_timezone_set('Asia/Kathmandu');
                            echo date("dm") . $_SESSION['UID'] . substr(date("i"), 1) . substr(date("s"), 1);
                            $pid= date("dm") . $_SESSION['UID'] . substr(date("i"), 1) . substr(date("s"), 1);
                        ?>
                    ">
                    <label class="form-data">Recipient Name</label><br>
                    <input type="text" value="<?php echo $row['name']; ?>" name="name" readonly><br>
                    <label class="form-data">Recipient Email</label><br>
                    <input type="email" value="<?php echo $row['email']; ?>" name="email"readonly><br>
                    <label class="form-data">Phone Number</label><br>
                    <input type="tel" value="<?php echo $row['phone_number']; ?>" 
                        name="ph_num" pattern="^9[78]\d{8}$" required 
                        title="Phone number must start with 97 or 98 and have 10 digits.">
                    <br>

                    <label class="form-data">Alternate Phone Number (Optional)</label><br>
                    <input type="tel" name="alt_ph_num" pattern="^9[78]\d{8}$" title="Phone number must start with 97 or 98 and have 10 digits."><br>
                </div>
                <h2 id="cart-id">&#x2461 Verify Items in Cart</h2>
                <div class="cart-details">
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
                                    <th width="10%" style="text-align: left;">Item Image</th>
                                    <th width="27%" style="text-align: left;">Item Name</th>
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
                                        <td class="img-center">
                                            <?php
                                                $prod_id=$values["item_id"];
                                                $query1 = "SELECT * FROM motoproducts WHERE product_id = $prod_id";
                                                $result1 = mysqli_query($conn, $query1);
                                                
                                                if (mysqli_num_rows($result1) > 0) 
                                                {
                                                    $row1 = mysqli_fetch_assoc($result1);
                                                    ?>
                                                        <img src="../admin/products/<?php echo $row1['image']; ?>" 
                                                        alt="<?php echo $row['name']; ?>" 
                                                        style="width: 200px; display: block; margin: 0 auto;">
                                                    <?php
                                                }
                                            ?>
                                        </td>
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
                                    <td colspan="3"></td>
                                    <td style="text-align: center; font-size: 18px; color: green;"><?php echo "Rs. " . number_format($total, 2); ?></td>
                                </tr>
                                <tr style="height: 16px;"></tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left; font-size: 20px;"><strong>Delivery Charge</strong></td>
                                    <td colspan="3"></td>
                                    <td style="text-align: center; font-size: 18px; color: green;"><?php echo "Rs. " . number_format(250, 2); ?></td>
                                </tr>
                                <tr style="height: 16px;"></tr>
                                <tr>
                                    <?php
                                        $grand_total=$total+250;
                                    ?>
                                    <td></td>
                                    <td style="text-align: left; font-size: 26px;"><strong>Grand Total</strong></td>
                                    <td colspan="3"></td>
                                    <td style="text-align: center; font-size: 22px; color: green;"><strong><?php echo "Rs. " . number_format($grand_total, 2); ?></strong></td>
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
                                <?php
                            }
                        } else {
                                        $grand_total=0;
                            // Cookie does not exist or is empty
                            ?>
                            <div clas="empty" style="text-align: center;">
                                    <img src="icons/box.png" alt="Empty" width="200px"
                                    style="margin-top:20px;">
                                    <p style="font-size: 20px;">Your cart is empty.</p>
                            </div>
                            <?php
                        }                        
                    ?>
                </table>
                </div>
                <h2 id="loc-id">&#x2462 Verify Shipping Address</h2>
                <div class="location-details">
                    <label class="form-data">Street Name/Address</label><br>
                    <input type="text" value="<?php echo $row['address']; ?>" name="street_name" required><br>
                    <label class="form-data">Tole/Locality</label><br>
                    <input type="text" required name="tole" required><br>
                    <label class="form-data">Municipality</label><br>
                    <input type="text" required name="municipality"
                    pattern="^[a-z ,.'-]+$" title="Address not in proper format" required><br>
                    <label class="form-data">District</label><br>
                    <input type="text" required name="district"
                    pattern="^[a-z ,.'-]+$" title="Address not in proper format" required><br>
                </div>
                <h2 id="pay-id">&#x2463 Select and Verify Payment Method</h2>
                <div class="payment-details" id="payment-details">
                    <div class="cod <?php echo $disable_cod; ?>" onclick="glow0()" id="myDiv0">
                        <input type="radio">
                        <img src="cash-on-delivery.png" alt="COD">
                        <h2>Cash on Delivery</h2>
                    </div>
                    <div class="avail" onclick="glow()" id="myDiv">
                        <h1>Online payment methods unavailabe</h1>
                    </div>
                </div>
            </div>
            <div class="order-btn">
                <input type="hidden" name="payment_method" id="p_method" value="">
                <input type="submit" name="order" value="PLACE ORDER" id="showBtn" class="hiddenBtn">
            </div>
        </form>
    </div>
    <script src="cookie.js"></script>
    <script>
        function glow0()
        {
            document.getElementById("p_method").value = "Cash-on-Delivery";
            document.getElementById("showBtn").style.display = "inline-block";
            document.getElementById("myDiv0").classList.add("glow");
            document.getElementById("myDiv").classList.remove("glow");
        }
        function glow()
        {
            document.getElementById("showBtn").style.display = "none";
            document.getElementById("myDiv0").classList.remove("glow");
            document.getElementById("myDiv").classList.add("glow");
        }
    </script>
</body>
    <?php
        include('../footer.php');
    ?>
</html>