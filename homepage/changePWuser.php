<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
    include("../dbconn.php");
    if(isset($_SESSION['UID'])) 
    {
        $id=$_SESSION['UID'];
        //echo $id;
        $res=mysqli_query($conn,"SELECT password FROM user WHERE id='$id'");
        $row=mysqli_fetch_assoc($res);
        $password = $row['password'];
        if(isset($_POST['submit'])) 
        {
            if(isset($_POST['cur_pass'], $_POST['new_pass'], $_POST['con_pass'])) 
            {
                $cur_pass = $_POST['cur_pass'];
                $new_pass = $_POST['new_pass'];
                $con_pass = $_POST['con_pass'];

                if($cur_pass == $new_pass && $cur_pass == $con_pass)
                {
                    ?>
                        <script>
                                swal({
                                    title: "New password cannot be same as current password",
                                    icon: "warning"
                                    }).then(() => {
                                    window.location.href = "dashboard.php";
                                });
                            </script>
                    <?php
                } 
                else if($cur_pass == $password) 
                {
                    if($new_pass == $con_pass) 
                    {
                        $update_user = $conn->prepare("UPDATE `user` SET password=? WHERE id=?");
                        $update_user->bind_param("si", $new_pass, $id);
                        $update_user->execute();
                    ?>
                        <script>
                                swal({
                                    title: "Password changed successfully!",
                                    icon: "success"
                                    }).then(() => {
                                    window.location.href = "dashboard.php";
                                });
                            </script>
                    <?php
                    } 
                    else 
                    {
                        ?>
                        <script>
                                swal({
                                    title: "Passwords do not match!",
                                    icon: "warning"
                                    }).then(() => {
                                    window.location.href = "dashboard.php";
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
                                title: "Current password incorrect",
                                icon: "error"
                                }).then(() => {
                                window.location.href = "dashboard.php";
                            });
                        </script>
                    <?php
                }
            }
        }
    }
?>
<div class="c-password" id="c-password">
    <div class="cpass">
        <h2>Change Password</h2><br>
        <form action="" method="post" class="passform">
            <h3>Current Password<br><br>
                <input type="password" name="cur_pass" value="" class="password-field" id="show1" required>
            </h3>
            <h3>New Password<br><br>
                <input type="password" name="new_pass" value="" class="password-field" id="show" required>
            </h3>
            <h3>Confirm Password<br><br>
                <input type="password" name="con_pass" value="" class="password-field" id="show" required>
            </h3>
            <input type="submit" name="submit" value="Save Changes" id="pass-up">
            <input type="checkbox" onclick="myFunction()">Show Password
        </form>
    </div>
</div>

<script>
    function myFunction() {
        // Get all elements with the class 'password-field'
        let fields = document.querySelectorAll(".password-field");
        fields.forEach(function(field) {
            if (field.type === "password") {
                field.type = "text";
            } else {
                field.type = "password";
            }
        });
    }
</script>
