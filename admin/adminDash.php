<?php
    include('../dbconn.php');
    session_start();
    if(!isset($_SESSION['AID'])) {
        header('location: SignIn.php');
        die();
    }
    $id = $_SESSION['AID'];
    function checkUniqueEmail($conn, $email)
    {
        $sql = "SELECT COUNT(*) AS count FROM admin WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $row1 = mysqli_fetch_assoc($result);
        return $row1['count'] == 0;
    }

    function checkUniquePhoneNumber($conn, $phone_number)
    {
        $sql = "SELECT COUNT(*) AS count FROM admin WHERE phone_number = '$phone_number'";
        $result = mysqli_query($conn, $sql);
        $row1 = mysqli_fetch_assoc($result);
        return $row1['count'] == 0;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="Monsterrat.css">
    <title>Document</title>
    <style>
         .main {
            font-family: 'Monsterrat', sans-serif;
            position: absolute;
            width: 90%;
            margin-top: 20px;
            padding: 20px;
            margin-left: 20px;
            margin-right: 20px;
            min-height: 100vh;
            background: var(--white);
            transition: 0.5s;
         }

         .topbar {
            width: 100%;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10px;
         }

         .toggle {
            position: relative;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2.5rem;
            cursor: pointer;
         }

         .search {
            position: relative;
            width: 400px;
            margin: 0 10px;
            }

         .search label {
            position: relative;
            width: 100%;
         }

         .search label input {
            width: 100%;
            height: 40px;
            border-radius: 40px;
            padding: 5px 20px;
            padding-left: 35px;
            font-size: 18px;
            outline: none;
            border: 1px solid var(--black2);
         }

         .search label ion-icon {
            position: absolute;
            top: 0;
            left: 10px;
            font-size: 1.2rem;
         }

         .user {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
         }

         .user img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
         }

         /* ======================= Cards ====================== */
         .cardBox {
            position: relative;
            width: 100%;
            font-family: 'Monsterrat', sans-serif;
            padding: 20px;
         }

         .cardBox .card {
            position: relative;
            background: rgb(234, 233, 233);
            padding: 30px;
            border-radius: 20px;
            display: flex;
            justify-content: space-between;
            cursor: pointer;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
            width: 100%;
            transition: 0.3s ease-in;
         }

         .cardBox .card .numbers {
            position: relative;
            font-weight: 500;
            font-size: 2.5rem;
            color: var(--blue);
         }

         .cardBox .card .cardName {
            color: var(--black2);
            font-size: 1.1rem;
            margin-top: 5px;
         }

         .cardBox .card .iconBx {
            font-size: 3.5rem;
            color: var(--black2);
         }

         /*===============EDIT PROFILE================*/
         .edit-profile {
            position: relative;
            width: 100%;
            padding: 20px;
         }
         .edit-profile .e-card {
            position: relative;
            background: var(--white);
            padding: 30px;
            border-radius: 20px;
            justify-content: space-between;
            cursor: pointer;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            transition: 0.3s ease-in;
         }
         .edit-profile .e-card h2
         {
            margin-bottom: 10px;
         }

         .upform
         {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
         }
         form #name,
         #email,
         #num,
         #address
         {
            width: 90%;
            height: 50px;
            outline: none;
            font-size: 18px;
            background-color: transparent;
            caret-color: black;
            border-radius: 5px;
            border: 0.5px solid #bfbfbf;
            border-bottom-width: 2px;
            transition: all 0.2s ease;
            color: black;
            margin-bottom: 15px;
            font-family: 'Monsterrat', sans-serif;
            padding-left: 30px;
         }
         input[type="number"]::-webkit-inner-spin-button {
            display: none;
         }
         form #upd
         {
            border-radius: 5px;
            font-size: 18px;
            margin-top: 10px ;
            width: 110px;
            height: 40px;
            text-align: center;
            background-color: black;
            cursor: pointer;
            transition: 0.3s ease-in;
            font-family: 'Monsterrat', sans-serif;
            color: white;
         }
         form #upd:hover
         {
            background-color: white;
            color: black;
         }

         /* ================== CHANGE PASSWORD ============== */
         .c-password {
            position: relative;
            width: 100%;
            padding: 20px;
         }
         .c-password .cpass {
            position: relative;
            background: var(--white);
            padding: 30px;
            border-radius: 20px;
            justify-content: space-between;
            cursor: pointer;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            transition: 0.3s ease-in;
         }
         .c-password .cpass h2
         {
            margin-bottom: 10px;
         }
         form #show,
         form #show1
         {
            width: 50%;
            height: 50px;
            outline: none;
            font-size: 18px;
            background-color: transparent;
            caret-color: black;
            border-radius: 5px;
            border: 0.5px solid #bfbfbf;
            border-bottom-width: 2px;
            transition: all 0.2s ease;
            color: black;
            margin-bottom: 15px;
            font-family: 'Monsterrat', sans-serif;
            padding-left: 30px;
         }
         form #pass-up
         {
            border-radius: 5px;
            font-size: 18px;
            margin-top: 10px ;
            width: 150px;
            height: 40px;
            text-align: center;
            background-color: black;
            cursor: pointer;
            transition: 0.3s ease-in;
            font-family: 'Monsterrat', sans-serif;
            color: white;
         }
         form #pass-up:hover
         {
            background-color: white;
            color: black;
         }
         form input[type=checkbox] {
            width: 20px; /* Makes the checkbox larger */
            height: 20px;
            accent-color: #007BFF; /* Changes the color of the checkbox (supported in modern browsers) */
            cursor: pointer; /* Changes cursor to a pointer when hovering over the checkbox */
            margin: 10px; /* Adds space around the checkbox */
            border: 2px solid #ddd; /* Adds a border to the checkbox */
            border-radius: 4px; /* Makes the checkbox corners rounded */
         }

    </style>
</head>
<body>
    <?php
        include "header.php";
    ?>
</body>
<div class="main">
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
                $query = "SELECT * FROM admin WHERE aid = $id";
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
                    if (isset($_POST['name'], $_POST['email'], $_POST['phone_number'])) 
                    {
                        // Get the new values from the form
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $phone_number = $_POST['phone_number'];
                    
                        // Fetch the user's current email and phone number
                        $sql = "SELECT email, phone_number FROM admin WHERE aid = '".$_SESSION['AID']."'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                    
                        $current_email = $row['email'];
                        $current_phone_number = $row['phone_number'];
                    
                        // Check if the updated email or phone number is the same as the current one
                        if (($email == $current_email || checkUniqueEmail($conn, $email)) &&
                            ($phone_number == $current_phone_number || checkUniquePhoneNumber($conn, $phone_number))) 
                        {
                            // Update the user information in the database
                            $update_sql = "UPDATE admin SET name='$name', email='$email', phone_number='$phone_number' WHERE aid='".$_SESSION['AID']."'";
                            mysqli_query($conn, $update_sql);
                            ?>
                                <script>
                                    swal({
                                        title: "Profile updated successfully!",
                                        icon: "success"
                                        }).then(() => {
                                        window.location.href = "adminDash.php";
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
                                            text:"This email is used by an other admin.",
                                            icon: "error"
                                            }).then(() => {
                                            window.location.href = "adminDash.php";
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
                                            text:"This number is used by an other admin.",
                                            icon: "error"
                                            }).then(() => {
                                            window.location.href = "adminDash.php";
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
                                    window.location.href = "adminDash.php";
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
                        <br>
                        <input type="submit" name="update" value="Update" id="upd">
                    </form>
                </div>
            </div>
            <!-- =============CHANGE PASSWORD SECTION============ -->
            <?php
                include("changePWuser.php");
            ?>
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
</script>
</html>