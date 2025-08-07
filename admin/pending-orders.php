<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="jquery-3.7.1.min.js"></script>
<?php
    include('../dbconn.php');
    session_start();
    if(!isset($_SESSION['AID'])) {
        header('location: SignIn.php');
        die();
    }
    if (isset($_GET['remove'])) {
        $remove_id = $_GET['remove'];
        if (mysqli_query($conn, "DELETE FROM orders WHERE bulk_id='$remove_id'")) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Deleted successfully',
                        text: 'The order has been deleted.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'pending-orders.php';
                    });
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to delete the record.',
                        icon: 'error'
                    });
                });
            </script>";
        }
    }

    if (isset($_GET['update'])) 
    {
        $update_id = $_GET['update'];
        $sql="SELECT * FROM orders WHERE bulk_id='$update_id'";
        while($sql)
        {
            $res = mysqli_query($conn, $sql) or die('Query failed');
            if ($res) 
            {
                while ($row = mysqli_fetch_array($res)) 
                {
                    $user_id = $row['user_id'];
                    $bulk_id = $row['bulk_id'];
                    $prod_id = $row['product_id'];;
                    $name = $row['name'];
                    $email = $row['email'];
                    $ph_num = $row['ph_num'];
                    $alt_ph_num = $row['alt_ph_num'];
                    $prod_name = $row['prod_name'];
                    $prod_price = $row['prod_price'];
                    $prod_quantity = $row['prod_quantity'];
                    $street_name = $row['street_name'];
                    $tole = $row['tole'];
                    $municipality = $row['municipality'];
                    $district = $row['district'];
                    $payment_method = $row['payment_method'];
                    $placed_date = $row['placed_date'];

                    $result = mysqli_query($conn, "INSERT INTO c_orders (bulk_id, user_id, product_id, name, email, ph_num, alt_ph_num, prod_name, prod_price,
                            prod_quantity, street_name, tole, municipality, district, payment_method, placed_date) 
                            VALUES('$bulk_id','$user_id', '$prod_id', '$name', '$email', '$ph_num', '$alt_ph_num', '$prod_name', '$prod_price', '$prod_quantity',
                            '$street_name', '$tole', '$municipality', '$district', '$payment_method', '$placed_date')");

                    if ($result) {
                        if(mysqli_query($conn, "DELETE FROM orders WHERE bulk_id='$update_id'"))
                        {
                        echo "<script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        title: 'Order Completed',
                                        text: 'The order has been delivered to the customer.',
                                        icon: 'success'
                                    }).then(() => {
                                        window.location.href = 'pending-orders.php';
                                    });
                                });
                            </script>";
                        }
                    } else {
                        echo "<script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        title: 'System Error',
                                        text: 'Failed to complete order.',
                                        icon: 'error'
                                    });
                                });
                            </script>";
                    }
                }
                header('location: pending-orders.php');
            }
            else
            {
                die('Query failed');
            }
        }
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
        .c-btn, .r-btn
        {
            padding: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s linear;
            border-radius: 12px;
        }
        .c-btn
        {
            color: white;
            border: 1px solid green;
            background-color: green;
        }
        .r-btn
        {
            color: white;
            border: 1px solid red;
            background-color: red;
        }
        .c-btn:hover
        {
            color: white;
            border: 1px solid darkgreen;
            background-color: darkgreen;
        }
        .r-btn:hover
        {
            color: white;
            border: 1px solid crimson;
            background-color: crimson;
        }
        .search-btn
        {
            color: black;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
        include("header.php");
    ?>
    <div class="main-container">
        <h1>Pending Orders</h1>
        <div class="search">
            <form action="" method="POST">
                <tr>
                    <td>Enter order ID: </td>
                    <td><input type="text" name="search-box" class="search-box"></td>
                    <td><input type="submit" name="search-btn" class="search-btn" value="Search"></td>
                </tr>
            </form>
        </div>
        <div class="sub-container">
        <table cellpadding="15" style="border-collapse: collapse; width: 100%;">
                <tr>
                    <th width="5%" style="border-bottom: 2px solid #000;">User ID</th>
                    <th width="15%" style="border-bottom: 2px solid #000;">Name</th>
                    <th width="20%" style="border-bottom: 2px solid #000;">Email</th>
                    <th width="15%" style="border-bottom: 2px solid #000;">Phone Number</th>
                    <th width="20%" style="border-bottom: 2px solid #000;">Address</th>
                    <th width="15%" style="border-bottom: 2px solid #000;">Payment Method</th>
                    <th width="10%" style="border-bottom: 2px solid #000;">Date of Order</th>
                </tr>
                <?php
                $index = 1;
                if (isset($_POST['search-box']) && $_POST['search-box'] != NULL) {
                    $search = $_POST['search-box'];
                    // Perform custom sanitization to prevent SQL injection
                    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); // Basic sanitization
                    $query = "SELECT * FROM orders WHERE bulk_id LIKE '%$search%' ORDER BY placed_date ASC";
                } else {
                    $query = "SELECT * FROM orders ORDER BY placed_date ASC";
                }
                
                $select_user = mysqli_query($conn, $query) or die('Query failed.');
                if (mysqli_num_rows($select_user) > 0) {
                    $prev_bulk_id = null; // Store previous bulk_id for comparison
                    $grand_total = 0; // Grand Total for each bulk_id

                    while ($fetch_user = mysqli_fetch_assoc($select_user)) {
                        // If bulk_id changes, display the grand total of previous bulk_id
                        if ($fetch_user['bulk_id'] != $prev_bulk_id && $prev_bulk_id != null) {
                            ?>
                            <tr>
                                <td></td>
                                <td colspan="5" style="text-align: left; font-weight: bold; border-top: 1px solid #000; font-size: 18px;">
                                    Grand Total (Including charges)
                                </td>
                                <td style="font-weight: bold; border-top: 1px solid #000; font-size: 20px; color: green;">
                                    <?php echo $grand_total1; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: right;">
                                    <a href="pending-orders.php?update=<?php echo $prev_bulk_id; ?>" class="c-btn">Complete Order</a>
                                    <a href="pending-orders.php?remove=<?php echo $prev_bulk_id; ?>" class="r-btn">Remove Order</a>
                                </td>
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
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: center; font-size: 20px; font-weight: 600;">
                                    Orders by <?php echo $fetch_user['name']; ?>:
                                </td>
                            </tr>
                            <tr style="font-size: 18px; font-weight: 600;">
                                <td style="border-bottom: none;"></td> <!-- Remove border-bottom from the first column -->
                                <td style="border-bottom: 1px solid #000;">Order ID</td>
                                <td colspan="2" style="border-bottom: 1px solid #000;">Product Name</td>
                                <td style="border-bottom: 1px solid #000;">Price</td>
                                <td style="border-bottom: 1px solid #000;">Quantity</td>
                                <td style="border-bottom: 1px solid #000;">Sub-Total</td>
                            </tr>

                            <?php
                        }

                        // Calculate Subtotal for current order and add to Grand Total
                        $subtotal = $fetch_user['prod_price'] * $fetch_user['prod_quantity'];
                        $grand_total += $subtotal;
                        $grand_total1 = number_format($grand_total + 250.00,2);
                        // Display current order row
                        ?>
                        <tr style="text-align: left;">
                            <td></td>
                            <td><?php echo $fetch_user['bulk_id']; ?></td>
                            <td colspan="2" style="font-weight: 600;"><?php echo $fetch_user['prod_name']; ?></td>
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
                            <td colspan="5" style="text-align: left; font-weight: bold; border-top: 1px solid #000; font-size: 18px;">
                                Grand Total (Including charges)
                            </td>
                            <td style="font-weight: bold; border-top: 1px solid #000; font-size: 20px; color: green;">
                                <?php echo $grand_total1; ?>
                            </td>
                        </tr>
                        <tr>
                                <td colspan="7" style="text-align: right;">
                                    <a href="pending-orders.php?update=<?php echo $prev_bulk_id; ?>" class="c-btn">Complete Order</a>
                                    <a href="pending-orders.php?remove=<?php echo $prev_bulk_id; ?>" class="r-btn">Remove Order</a>
                                </td>
                            </tr>
                        <?php
                    }
                }
                else
                {
                    echo "<tr style='text-align: center;
                    padding-top: 30px;
                    font-weight: 600;
                    font-size: 18px;'><td colspan='7';>No pending orders</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
    <script>
        // Function to show confirmation dialog
        $('.c-btn').on('click',function(e){
            e.preventDefault();
            const href = $(this).attr('href')
            Swal.fire({
                title: 'Do you want to complete this order?',
                icon : 'question',
                showCancelButton:true,
                confirmButtonColor: 'green',
                cancelButtonColor: 'grey',
                confirmButtonText: 'Confirm',
            }).then((result) => {
                if (result.value) {
                    document.location.href = href;
                }
            })
        });
        $('.r-btn').on('click',function(e){
            e.preventDefault();
            const href = $(this).attr('href')
            Swal.fire({
                title: 'Are you sure you want to remove this order?',
                icon : 'warning',
                text : 'This action cannot be undone.',
                showCancelButton:true,
                confirmButtonColor: 'red',
                cancelButtonColor: 'grey',
                confirmButtonText: 'Confirm',
            }).then((result) => {
                if (result.value) {
                    document.location.href = href;
                }
            })
        });
    </script>
</body>
</html>