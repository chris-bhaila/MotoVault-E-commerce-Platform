<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="jquery-3.7.1.min.js"></script>
<?php
    include("../dbconn.php");
    session_start();
    if(!isset($_SESSION['AID'])) {
        header('location: SignIn.php');
        die();
    }
    if (isset($_GET['remove'])) {
        $remove_id = $_GET['remove'];
        $sql1 = "DELETE FROM `orders` WHERE user_id='$remove_id'";
        $sql2 = "DELETE FROM `review` WHERE user_id='$remove_id'";
        $sql3 = "DELETE FROM `user` WHERE id='$remove_id'";

        if(mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3))
        {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Deleted successfully',
                        text: 'The user has been removed.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'userAccounts.php';
                    });
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to delete user.',
                        icon: 'error'
                    });
                });
            </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Monsterrat.css">
    <style>
        body
        {
            font-family: 'Monsterrat', sans-serif;
        }
        .main-table
        {
            margin-top: 90px;
            padding: 40px;
        }
        table
        {
            width: 100%;
            padding: 20px;
            padding-bottom: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            border-radius: 20px;
        }
        .r-btn
        {
            text-decoration: none;
            padding: 5px;
            color: white;
            border: 2px solid red;
            background-color: red;
            border-radius: 12px;
            transition: 0.2s linear;
        }
        .r-btn:hover
        {
            
            background-color: crimson;
            border: 2px solid crimson;
        }
    </style>
</head>
<body>
    <?php
        include('header.php');
    ?>
    <div class="main-table">
        <table>
            <tr style="height: 80px; font-size: 24px;">
                <th style="text-align: center;" width="">S.N.</th>
                <th style="text-align: center;" width="">User ID</th>
                <th style="text-align: left;" width="">Name</th>
                <th style="text-align: left;" width="">Email</th>
                <th style="text-align: left;" width="">Phone Number</th>
                <th style="text-align: left;" width="">Address</th>
                <th style="text-align: center;" width="">Registered date & time</th>
                <th style="text-align: center;" width="">Action</th>
            </tr>
            <?php
                $select_user = mysqli_query($conn, "SELECT * FROM `user`") or die('Query failed.');
                $index=1;
                if (mysqli_num_rows($select_user) > 0) {
                    while ($fetch_user = mysqli_fetch_assoc($select_user)) {
                        ?>
                            <tr style="height: 60px">
                                <td style="text-align: center; font-weight: 500; font-size: 20px;"><?php echo $index++;?></td>
                                <td style="text-align: center; font-weight: 500; font-size: 20px;"><?php echo $fetch_user['id'];?></td>
                                <td style="text-align: left; font-weight: 500; font-size: 20px;"><?php echo $fetch_user['name'];?></td>
                                <td style="text-align: left; font-weight: 500; font-size: 20px;"><?php echo $fetch_user['email'];?></td>
                                <td style="text-align: left; font-weight: 500; font-size: 20px;"><?php 
                                if($fetch_user['phone_number']==0)
                                {
                                    echo '<span style="color: crimson;">Not Set</span>';
                                }
                                else
                                {
                                    echo $fetch_user['phone_number'];
                                }
                                ?></td>
                                <td style="text-align: left; font-weight: 500; font-size: 20px;"><?php 
                                if($fetch_user['address']==NULL)
                                {
                                    echo '<span style="color: crimson;">Not Set</span>';
                                }
                                else
                                {
                                    echo $fetch_user['address'];
                                }
                                ?></td>
                                <td style="text-align: center; font-weight: 500; font-size: 20px;"><?php echo $fetch_user['reg_date'];?></td>
                                <td style="text-align: center; font-weight: 500; font-size: 20px;"><a href="userAccounts.php?remove=<?php echo $fetch_user['id']; ?>" class="r-btn">Remove</a></td>
                                
                            </tr>
                        <?php
                    }
                }
                ?>
        </table>
    </div>
    <script>
        // Function to show confirmation dialog
        $('.r-btn').on('click',function(e){
            e.preventDefault();
            const href = $(this).attr('href')
            Swal.fire({
                title: 'Are you sure you want to remove this user?',
                text : 'Pending orders and product reviews made by this user will also be deleted.',
                icon : 'warning',
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