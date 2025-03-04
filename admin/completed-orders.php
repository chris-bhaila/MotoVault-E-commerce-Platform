<?php
    include('../dbconn.php');
    session_start();
    if(!isset($_SESSION['AID'])) {
        header('location: SignIn.php');
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Monsterrat.css">
    <title>Document</title>
    <style>
        *
        {
            font-family: 'Monsterrat', sans-serif;
        }
        .main-container
        {
            margin-top: 40px;
            padding: 60px;
        }
        .sub-container
        {
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            padding: 20px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <?php
        include("header.php");
    ?>
    <div class="main-container">
        <h1>Completed Orders</h1>
        <div class="sub-container">
        <table cellpadding="15" style="border-collapse: collapse; width: 100%;">
                <tr>
                    <th width="5%" style="border-bottom: 2px solid #000;">User ID</th>
                    <th width="15%" style="border-bottom: 2px solid #000;">Name</th>
                    <th width="20%" style="border-bottom: 2px solid #000;">Email</th>
                    <th width="10%" style="border-bottom: 2px solid #000;">Phone Number</th>
                    <th width="15%" style="border-bottom: 2px solid #000;">Address</th>
                    <th width="15%" style="border-bottom: 2px solid #000;">Payment Method</th>
                    <th width="10%" style="border-bottom: 2px solid #000;">Date of Order</th>
                    <th width="10%" style="border-bottom: 2px solid #000;">Date of Completion</th>
                </tr>
                <?php
                $select_user = mysqli_query($conn, "SELECT * FROM `c_orders` ORDER BY placed_date ASC") or die('Query failed.');
                if (mysqli_num_rows($select_user) > 0) {
                    $prev_bulk_id = null; // Store previous bulk_id for comparison
                    $grand_total = 0; // Grand Total for each bulk_id

                    while ($fetch_user = mysqli_fetch_assoc($select_user)) {
                        // If bulk_id changes, display the grand total of previous bulk_id
                        if ($fetch_user['bulk_id'] != $prev_bulk_id && $prev_bulk_id != null) {
                            ?>
                            <tr>
                                <td></td>
                                <td colspan="6" style="text-align: left; font-weight: bold; border-top: 1px solid #000; font-size: 18px;">
                                    Grand Total (Including charges)
                                </td>
                                <td style="font-weight: bold; border-top: 1px solid #000; font-size: 20px; color: green;">
                                    <?php echo $grand_total1; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" style="
                                    text-align: right;
                                    color: green;
                                    font-weight: 600;
                                    font-size: 20px;
                                ">Transaction Complete &#10004;</td>
                            </tr>
                            <?php
                            $grand_total = 0; // Reset grand total for the next bulk_id
                        }

                        // Display user details only once for each bulk_id
                        if ($fetch_user['bulk_id'] != $prev_bulk_id) {
                            ?>
                            <tr style="text-align: center; border-top: 2px solid #000; font-weight:450;">
                                <td><?php echo $fetch_user['user_id']; ?></td>
                                <td><?php echo $fetch_user['name']; ?></td>
                                <td><?php echo $fetch_user['email']; ?></td>
                                <td>
                                    <?php echo $fetch_user['ph_num'];
                                    if ($fetch_user['alt_ph_num'] != 0) {
                                        echo "/" . $fetch_user['alt_ph_num'];
                                    } ?>
                                </td>
                                <td>
                                    <?php echo "Street Name: " . $fetch_user['street_name'] . "<br>" .
                                        "Tole: " . $fetch_user['tole'] . "<br>" .
                                        "Municipality: " . $fetch_user['municipality'] . "<br>" .
                                        "District: " . $fetch_user['district']; ?>
                                </td>
                                <td style="color: green;"><?php echo $fetch_user['payment_method']; ?></td>
                                <td><?php echo $fetch_user['placed_date']; ?></td>
                                <td><?php echo $fetch_user['completed_date']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: center; font-size: 20px; font-weight: 600;">
                                    Orders by <?php echo $fetch_user['name']; ?>:
                                </td>
                            </tr>
                            <tr style="font-size: 18px; font-weight: 600;">
                                <td style="border-bottom: none;"></td> <!-- Remove border-bottom from the first column -->
                                <td style="border-bottom: 1px solid #000;">Order ID</td>
                                <td colspan="3" style="border-bottom: 1px solid #000;">Product Name</td>
                                <td style="border-bottom: 1px solid #000;">Price</td>
                                <td style="border-bottom: 1px solid #000;">Quantity</td>
                                <td style="border-bottom: 1px solid #000;">Sub-Total</td>
                            </tr>

                            <?php
                        }

                        // Calculate Subtotal for current order and add to Grand Total
                        $subtotal = $fetch_user['prod_price'] * $fetch_user['prod_quantity'];
                        $grand_total += $subtotal;
                        $grand_total1 = number_format($grand_total + 0.13*$grand_total + 250.00,2);
                        // Display current order row
                        ?>
                        <tr style="text-align: left;">
                            <td></td>
                            <td><?php echo $fetch_user['bulk_id']; ?></td>
                            <td colspan="3" style="font-weight: 600;"><?php echo $fetch_user['prod_name']; ?></td>
                            <td><?php echo $fetch_user['prod_price']; ?></td>
                            <td><?php echo $fetch_user['prod_quantity']; ?></td>
                            <td><?php echo $subtotal; ?></td>
                        </tr>
                        <?php
                        $prev_bulk_id = $fetch_user['bulk_id']; // Update bulk_id for next iteration
                    }

                    // Display the final Grand Total after the last bulk_id
                    if ($prev_bulk_id != null) {
                        ?>
                        <tr>
                            <td></td>
                            <td colspan="6" style="text-align: left; font-weight: bold; border-top: 1px solid #000; font-size: 18px;">
                                Grand Total (Including charges)
                            </td>
                            <td style="font-weight: bold; border-top: 1px solid #000; font-size: 20px; color: green;">
                                <?php echo $grand_total1; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8" style="
                                text-align: right;
                                color: green;
                                font-weight: 600;
                                font-size: 20px;
                            ">Transaction Complete &#10004;</td>
                        </tr>
                        <?php
                    }
                }
                else
                {
                    echo "<tr style='text-align: center;
                    padding-top: 30px;
                    font-weight: 600;
                    font-size: 18px;'><td colspan='8';>No completed orders</td></tr>";
                }
                ?>
            </table>`
        </div>
    </div>
</body>
</html>