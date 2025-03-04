<?php
    include("../dbconn.php");
    session_start();
    if(!isset($_SESSION['UID'])) {
        header('location: ../SignIn.php');
        die(); // Stop further execution
    }
    $id = $_SESSION['UID'];
    function checkUniqueEmail($conn, $email)
    {
        $sql = "SELECT COUNT(*) AS count FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $row1 = mysqli_fetch_assoc($result);
        return $row1['count'] == 0;
    }

    function checkUniquePhoneNumber($conn, $phone_number)
    {
        $sql = "SELECT COUNT(*) AS count FROM user WHERE phone_number = '$phone_number'";
        $result = mysqli_query($conn, $sql);
        $row1 = mysqli_fetch_assoc($result);
        return $row1['count'] == 0;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="../Monsterrat.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation active">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="bicycle-outline"></ion-icon>
                        </span>
                        <span class="title">My Dashboard</span>
                    </a>
                </li>

                <li style="font-size: 18px; transition: font-size 0.3s ease;"
                        onmouseover="this.style.fontSize='20px';" 
                        onmouseout="this.style.fontSize='18px';">
                    <a href="homepage.php">
                        <span class="icon">
                            <ion-icon name="arrow-back-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Back to Homepage</span>
                    </a>
                </li>

                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('cardBox').scrollIntoView({ behavior: 'smooth' }); this.classList.add('clicked');">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('edit-profile').scrollIntoView({ behavior: 'smooth' }); this.classList.add('clicked');">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Edit Profile</span>
                    </a>
                </li>

                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('c-password').scrollIntoView({ behavior: 'smooth' }); this.classList.add('clicked');">
                        <span class="icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="title">Password</span>
                    </a>
                </li>
                <!-- <h2 style="color: white; margin-top:12px;">Orders</h2> -->
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('recentOrders').scrollIntoView({ behavior: 'smooth' }); this.classList.add('clicked');">
                        <span class="icon">
                            <ion-icon name="bag-handle-outline"></ion-icon>
                        </span>
                        <span class="title">Recent Orders</span>
                    </a>
                </li>

                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('recentCustomers').scrollIntoView({ behavior: 'smooth' }); this.classList.add('clicked');">
                        <span class="icon">
                            <ion-icon name="receipt-outline"></ion-icon>
                        </span>
                        <span class="title">Order History</span>
                    </a>
                </li>

                <!-- <h2 style="color: white; margin-left:6px; margin-top:10px;">More</h2> -->

                <li>
                    <a href="../SignOut.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main active">
            <div class="topbar">
                <div class="toggle" id="toggle">
                    <ion-icon name="menu-outline" style="transition: font-size 0.3s ease;"
                    onmousedown="this.style.fontSize='20px';"
                    onmouseup="this.style.fontSize='40px';"></ion-icon>
                </div>

                <!-- <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div> -->
            </div>
            <?php
                $query = "SELECT * FROM user WHERE id = $id";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) > 0) 
                {
                    $value = mysqli_fetch_assoc($result);
                }
            ?>
            <!-- ======================= Cards ================== -->
            <div class="cardBox" id="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $value['name'];?></div>
                        <div class="cardName"><?php echo $value['email'];?></div>
                        <div class="cardName"><?php echo $value['phone_number'];?></div>
                    </div>
                </div>
            </div>
            

            <!-- =============UPDATE PROFILE SECTION============ -->
             <?php
                if (isset($_POST['update'])) 
                {
                    // Check if all required POST variables are set
                    if (isset($_POST['name'], $_POST['email'], $_POST['phone_number'], $_POST['address'])) 
                    {
                        // Get the new values from the form
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $phone_number = $_POST['phone_number'];
                        $address = $_POST['address'];
                    
                        // Fetch the user's current email and phone number
                        $sql = "SELECT email, phone_number FROM user WHERE ID = '".$_SESSION['UID']."'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                    
                        $current_email = $row['email'];
                        $current_phone_number = $row['phone_number'];
                    
                        // Check if the updated email or phone number is the same as the current one
                        if (($email == $current_email || checkUniqueEmail($conn, $email)) &&
                            ($phone_number == $current_phone_number || checkUniquePhoneNumber($conn, $phone_number))) 
                        {
                            // Update the user information in the database
                            $update_sql = "UPDATE user SET name='$name', email='$email', phone_number='$phone_number', address='$address' WHERE id='".$_SESSION['UID']."'";
                            mysqli_query($conn, $update_sql);
                            ?>
                                <script>
                                    swal({
                                        title: "Profile updated successfully!",
                                        icon: "success"
                                        }).then(() => {
                                        window.location.href = "dashboard.php";
                                    });
                                </script>
                            <?php
                        } 
                        else 
                        {
                            if ($email != $current_email && !checkUniqueEmail($conn, $email)) 
                            {
                                ?>
                                    <script>
                                        swal({
                                            title: "Email already in use!",
                                            text:"This email is used by an other customer.",
                                            icon: "error"
                                            }).then(() => {
                                            window.location.href = "dashboard.php";
                                        });
                                    </script>
                                <?php
                            }
                            if ($phone_number != $current_phone_number && !checkUniquePhoneNumber($conn, $phone_number)) 
                            {
                                ?>
                                    <script>
                                        swal({
                                            title: "Phone number already in use!",
                                            text:"This number is used by an other customer.",
                                            icon: "error"
                                            }).then(() => {
                                            window.location.href = "dashboard.php";
                                        });
                                    </script>
                                <?php
                            }
                        }
                    } else {
                        // Handle case where required POST variables are not set
                        ?>
                            <script>
                                swal({
                                    title: "Unknown Error",
                                    text:"Please try again later.",
                                    icon: "error"
                                    }).then(() => {
                                    window.location.href = "dashboard.php";
                                });
                            </script>
                        <?php
                    }
                }
             ?>
            <div class="edit-profile" id="edit-profile">
                <div class="e-card">
                    <h2>Edit Profile</h2>
                    <form action="" method="post" class="upform">
                        <h3>Name<br><br>
                            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($value['name']) ?>" required></h3>
                        <h3>Email<br><br>
                            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($value['email']) ?>" required>
                        </h>
                        <h3>Phone<br><br>
                            <input type="number" name="phone_number" id="num" maxlength="10" value="<?php echo $value['phone_number'] ?>" 
                            required max="9999999999" min="0" maxlength="10"></h3>
                        <h3>Address<br><br>
                            <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($value['address']) ?>" required></h3>

                        <input type="submit" name="update" value="Update" id="upd">
                    </form>
                </div>
            </div>
            <!-- =============CHANGE PASSWORD SECTION============ -->
            <?php
                include("changePWuser.php");
            ?>
            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders" id="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Orders</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td style="text-align:left;">Name</td>
                                <td>Price</td>
                                <td>Payment</td>
                                <td>Status</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $select_user = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id='$id'") or die('Query failed.');
                                if (mysqli_num_rows($select_user) > 0) {
                                    while ($fetch_user = mysqli_fetch_assoc($select_user)) {
                            ?>
                            <tr>
                                <td><?php echo $fetch_user['bulk_id']; ?></td>
                                <td style="text-align:left;"><?php echo $fetch_user['prod_name']; ?></td>
                                <td><?php echo "Rs. ".number_format($fetch_user['prod_price']); ?></td>
                                <td><?php
                                    if($fetch_user['payment_method'] == "Cash-on-Delivery")
                                    {
                                        echo "Due";
                                    }
                                    else
                                    {
                                        echo "Paid";
                                    }
                                ?></td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- ================= ORDER HISTORY ================ -->
                <div class="recentOrders" id="recentOrders">
                    <div class="cardHeader">
                        <h2>Order History</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td style="text-align:left;">Name</td>
                                <td>Price</td>
                                <td>Payment</td>
                                <td>Status</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $select_user1 = mysqli_query($conn, "SELECT * FROM `c_orders` WHERE user_id='$id'") or die('Query failed.');
                                if (mysqli_num_rows($select_user1) > 0) {
                                    while ($fetch_user1 = mysqli_fetch_assoc($select_user1)) {
                            ?>
                            <tr>
                                <td><?php echo $fetch_user1['bulk_id']; ?></td>
                                <td style="text-align:left;"><?php echo $fetch_user1['prod_name']; ?></td>
                                <td><?php echo "Rs. ".number_format($fetch_user1['prod_price']); ?></td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        document.getElementById('num').addEventListener('input', function (e) 
        {
            const value = e.target.value;
            if (!/^9[78]\d{8}$/.test(value)) 
            {
                e.target.setCustomValidity('Your number is not in proper format.');
            }
            else 
            {
                e.target.setCustomValidity('');
            }
        });

        document.getElementById('show').addEventListener('input', function (e) 
            {
                const value = e.target.value;
                if (!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(value)) 
                {
                    e.target.setCustomValidity('Passwords must contain at least 8 characters, including special characters, UPPER/lowercase and numbers.');
                }
                else 
                {
                    e.target.setCustomValidity('');
                }
            });

        document.getElementById('email').addEventListener('input', function (e) 
        {
            const value = e.target.value;
            if (!/^([a-zA-Z0-9._-]+)@([a-zA-Z0-9.-]+)\.([a-z]{2,20})(\.[a-z]{2,20})?$/.test(value)) 
            {
                e.target.setCustomValidity('Your email is not in proper format.');
            } 
            else 
            {
                e.target.setCustomValidity('');
            }
        });
        document.getElementById('name').addEventListener('input', function (e) 
        {
            const value = e.target.value;
            if (!/^[a-z ,.'-]+$/i.test(value)) 
            {
                e.target.setCustomValidity('Your name is not in proper format.');
            } 
            else 
            {
                e.target.setCustomValidity('');
            }
        });
        document.getElementById('address').addEventListener('input', function (e) 
        {
            const value = e.target.value;
            if (!/^[a-z ,.'-]+$/i.test(value)) 
            {
                e.target.setCustomValidity('Your address is not in proper format.');
            } 
            else 
            {
                e.target.setCustomValidity('');
            }
        });
        document.querySelectorAll('.navigation a').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelectorAll('.navigation a').forEach(link => link.classList.remove('clicked'));
            this.classList.add('clicked');
        });
    });

</script>
</body>

</html>