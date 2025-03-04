<?php
    session_start();
    if(isset($_SESSION['AID'])) {
        header('location: homepage.php');
        die();
    }
    $conn=mysqli_connect('localhost','root','','motovault');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Login/Register</title>
</head>
<body>
    <?php
        if(isset($_POST['signup']))
        {
            $semail = filter_input(INPUT_POST,"s-email", FILTER_SANITIZE_EMAIL);
            $spassword = filter_input(INPUT_POST,"s-password", FILTER_SANITIZE_SPECIAL_CHARS);
            $sname = filter_input(INPUT_POST,"s-name", FILTER_SANITIZE_SPECIAL_CHARS);
            $snumber = filter_input(INPUT_POST,"s-number", FILTER_SANITIZE_SPECIAL_CHARS);
        
            $sql = "SELECT * FROM admin WHERE email='$semail'";
            $result = mysqli_query($conn, $sql);
            $count_email = mysqli_num_rows($result);
            
            $sql = "SELECT * FROM admin WHERE phone_number='$snumber'";
            $result = mysqli_query($conn, $sql);
            $count_phone_number = mysqli_num_rows($result);
            
            $adminCode = $_POST['adminCode'];
            if($count_email == 0 && $count_phone_number == 0)
            {
                if($adminCode == "AX980Chris_Bhaila")
                {
                    $sql1 = "INSERT INTO admin (email, password, name, phone_number) VALUES ('$semail','$spassword','$sname','$snumber')";
                    $result = mysqli_query($conn, $sql1);
                    if($result)
                    {
                        ?>
                            <script>
                                swal({
                                    title:"Your account has been created.",
                                    text:"Please login now to gain access to our services.",
                                    icon: "success"
                                }).then(() => {
                                    window.location.href = "SignIn.php";
                                });
                            </script>
                        <?php
                    }
                }
                else
                {
                    ?>
                        <script>
                            swal({
                                title: "Wrong Admin Code",
                                text: "Please enter the correct admin code to gain access to the admin panel.",
                                icon: "error"
                            }).then(() => {
                                window.location.href = "SignIn.php";
                            });
                        </script>
                    <?php
                }
            }
            else
            {
                if($count_email>0)
                {
                    ?>
                        <script>
                            swal({
                                title: "Email already in use!",
                                text:"This email is used by an other customer.",
                                icon: "error"
                                }).then(() => {
                                window.location.href = "SignIn.php";
                            });
                        </script>
                    <?php
                }
                if($count_phone_number>0)
                {
                    ?>
                        <script>
                            swal({
                                title: "Phone number already in use!",
                                text:"This number is used by an other customer.",
                                icon: "error"
                                }).then(() => {
                                window.location.href = "SignIn.php";
                            });
                        </script>
                    <?php
                }
            }
        }
    ?>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="" method="post">
                <h1>Create Account</h1>
                <!-- <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div> -->
                <!-- <span>or use your email for registeration</span> -->
                <input type="text" placeholder="Name" name="s-name" id="name" required>
                <input type="email" placeholder="Email" name="s-email" id="email" required>
                <input type="number" placeholder="Phone Number" name="s-number" id="num" required>
                <input type="password" placeholder="Password" name="s-password" id="password" required>
                <input type="password" placeholder="Admin Code" name="adminCode" required>
                <input type="submit" value="Sign Up" name="signup" class="button">
            </form>
        </div>
        <?php
            if(isset($_POST['signin']))
            {
                $email=mysqli_real_escape_string($conn,$_POST['email']);
                $password=mysqli_real_escape_string($conn,$_POST['password']);
                $res=mysqli_query($conn,"select * from admin where email='$email' and password='$password'");
                if(mysqli_num_rows($res)> 0)
                {
                    $row=mysqli_fetch_assoc($res);
                    $_SESSION['AID']= $row['aid'];
                    // setcookie('UID',$row['id'],time()+ 60*60*24*30);
                    header('location: homepage.php');
                    die();
                }
                else
                {
                    ?>
                        <script>
                            swal({
                                title:"Incorrect password",
                                text:"Please enter your correct credentials",
                                icon: "warning"
                            }).then(() => {
                                window.location.href = "SignIn.php";
                                });
                        </script>
                    <?php
                }
            }
        ?>
        <div class="form-container sign-in">
            <form action="" method="post">
                <h1>Sign In</h1>
                <!-- <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div> -->
                <!-- <span>or use your email password</span> -->
                <form action="" method="post">
                    <input type="email" placeholder="Email" name="email">
                    <input type="password" placeholder="Password" name="password">
                    <a href="#">Forget Your Password?</a>
                    <input type="submit" value="Sign In" name="signin" class="button">
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <!-- <h1>Hello, Friend!</h1> -->
                    <img src="tmoto_zoom.png" alt="MotoVault" class="logo" style="width: 14vw; height: fit-content;">
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        document.getElementById('num').addEventListener('input', function (e) 
        {
            const value = e.target.value;
            if (!/^9[78]\d{8}$/.test(value)) 
            {
                e.target.setCustomValidity('Number not in proper format');
            }
            else 
            {
                e.target.setCustomValidity('');
            }
        });

        document.getElementById('password').addEventListener('input', function (e) 
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
                e.target.setCustomValidity('Email not in proper format.');
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
    </script>
</body>

</html>