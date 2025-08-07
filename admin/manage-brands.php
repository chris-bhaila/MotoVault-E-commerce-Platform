<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="jquery-3.7.1.min.js"></script>
<?php     
    include("../dbconn.php");
    session_start();
    if(!isset($_SESSION['AID'])) {
        header('location: SignIn.php');
        die();
    }
    if (isset($_POST["submit"])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $desc = mysqli_real_escape_string($conn, $_POST['desc']);

        if ($_FILES["image"]["error"] === 4) {
            echo "<script>
            alert('No file uploaded. Please upload an image.');
            </script>";
        } else {
            $fileName = stripslashes($_FILES["image"]["name"]);
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];
            
            $validImageExtensions = ['jpg', 'jpeg', 'png', 'svg'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));
            
            if (!in_array($imageExtension, $validImageExtensions)) {
                echo "<script>
                alert('Invalid Image');
                </script>";
            } elseif ($fileSize > 10000000) { // 10MB limit
                echo "<script>
                alert('Image size is too large.');
                </script>";
            } else {
                move_uploaded_file($tmpName, 'brands/' . $fileName);
                $query = "INSERT INTO brands (`name`, `image`, `brand_desc`) 
                        VALUES('$name','$fileName','$desc')";
                $res = mysqli_query($conn, $query);
                if ($res) {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    title: 'Brand added successfully',
                                    icon: 'success'
                                }).then(() => {
                                    window.location.href = 'manage-brands.php';
                                });
                            });
                        </script>";
                } else {
                    echo "<script>
                    alert('Error: " . mysqli_error($conn) . "');
                    </script>";
                }
            }
        }
    }    

    if (isset($_POST['update'])) {
        $update_id = stripslashes($_POST['id']);
        $update_name = mysqli_real_escape_string($conn, $_POST['p-name']);
        $update_desc = mysqli_real_escape_string($conn, $_POST['p-desc']);
        
        if (mysqli_query($conn, "UPDATE brands SET name='$update_name', brand_desc='$update_desc' WHERE brand_id='$update_id'")) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Brand updated successfully',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'manage-brands.php';
                    });
                });
                </script>";
        } else {
            die('Query failed');
        }
    }    

    if (isset($_GET['remove'])) {
        $remove_id = $_GET['remove'];
        $sql1 = "DELETE FROM `motoproducts` WHERE brand_fid='$remove_id'";
        $sql2 = "DELETE FROM `brands` WHERE brand_id='$remove_id'";

        if(mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2))
        {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Brand deleted successfully',
                        icon: 'success'
                        }).then(() => {
                        window.location.href = 'manage-brands.php';
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
    <title>Manage Brands</title>
    <link rel="stylesheet" href="../mainFont.css">
    <link rel="stylesheet" href="Monsterrat.css">
    <style>
        body
        {
            overflow-x: hidden;
            font-family: 'Monsterrat', sans-serif;
        }
        h1 {
            font-size: 22px;
            margin-bottom: 30px;
        }
        form {
            padding: 20px;
            padding-bottom: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            border-radius: 20px;
        }
        .main
        {
            margin-top: 20px;
            padding: 70px;
        }
        .name,
        .price,
        .desc,
        .image {
            font-size: 20px;
            margin-left: 10px;
        }
        .image1,
        .btn {
            margin-left: 10px;
        }
        .btn {
            font-family: 'Monsterrat', sans-serif;
            width: 80px;
            padding: 8px;
            font-size: 17px;
            background-color: black;
            color: white;
            border-radius: 8px;
            border: 1px solid black;
            cursor: pointer;
            transition: 0.2s ease-in;
        }
        .btn:hover {
            background-color: white;
            color: black;
        }
        .brandsav table {
            margin-left: 10px;
            padding: 20px;
            width: 100%;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            border-radius: 20px;
        }
        .brandsav table th {
            border-bottom: 1px solid black;
        }
        .brandsav .p-id
        {
            width: 45px;
        }
        .brandsav .p-image
        {
            width: 250px;
        }
        .brandsav .p-name
        {
            width: 250px;
        }
        .brandsav .p-name textarea
        {
            width: 150px;
            font-size: 20px;
            border: transparent;
        }
        .brandsav .p-price
        {
            width: 100px;
        }
        .brandsav .p-price input
        {
            border: transparent;
            width: 50px;
        }
        .brandsav .p-desc
        {
            width: auto;
        }
        .brandsav .p-desc textarea
        {
            text-align: left;
            width: 300px;
            height: 100px;
            border: transparent;
        }
        .brandsav .delete-btn
        {
            font-size: 14px;
            padding:10px;
            width: 110px;
            height: 40px;
            text-align: center;
            text-decoration: none;
            color: white;
            background-color: crimson;
            cursor: pointer;
            transition: 0.3s ease-in;
            border-radius: 12px;
            border: 1px solid crimson;
        }
        .brandsav .delete-btn:hover
        {
            color: crimson;
            margin: 12px 0;
            background-color: white;
            width: 100px;
            height: 35px;
        }
        .brandsav .option-btn
        {
            font-family: 'Monsterrat', sans-serif;
            font-size: 14px;
            width: 80px;
            height: 40px;
            text-align: center;
            text-decoration: none;
            color: white;
            background-color: black;
            cursor: pointer;
            transition: 0.3s ease-in;
            border-radius: 12px;
            border: 1px solid black;
        }
        .brandsav .option-btn:hover
        {
            color: black;
            background-color: white;
        }
    </style>
</head>
<body>
    <?php
        include('header.php');
    ?>
    <div class="main">
        <h1>Enter the details to add a new brand to homepage strip.</h1>
        <form method="post" enctype="multipart/form-data">
            <table class="first">
                <tr>
                    <td><label class="name">Name</label></td>
                    <td><input type="text" name="name" class="name" required></td>
                </tr>
                <tr>
                    <td><label class="image">Image</label></td>
                    <td><input type="file" name="image" accept=".jpg, .jpeg, .png" class="image1"></td>
                </tr>
                <tr>
                    <td><label class="desc">Description</label></td>
                    <td><textarea name="desc" class="desc" style="width: 20vw; height: 13vh;" required></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Add" class="btn"></td>
                </tr>
            </table>
        </form>

        <div class="brandsav">
            <h2>Current Brands</h2>
            <table cellpadding="20" class="second">
                <tr>
                    <th class="p-id" style="border-right: 1px solid black;" width="10%">S.N.</th>
                    <th class="p-image" width="40%">Image</th>
                    <th class="p-name">Name</th>
                    <th class="p-desc" width="40%">Description</th>
                    <th class="p-action" width="20%">Action</th>
                </tr>
                <?php
                $index=1;
                $select_product = mysqli_query($conn, "SELECT * FROM `brands`") or die('Query failed.');
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                        ?>
                        <tr>
                            <form action="" method="post">
                                <td class="p-id" style="text-align: center; border-right: 1px solid black;"><?php echo $index++; ?></td>
                                <td class="p-image" style="text-align: center;"><img src="brands/<?php echo $fetch_product['image']; ?>" alt="" height="100"></td>
                                <td class="p-name" style="text-align: center;"><textarea name="p-name"><?php echo $fetch_product['name']; ?></textarea></td>
                                <td class="p-name" style="text-align: center;"><textarea name="p-desc" style="width: 20vw; height: 14vh; font-size: 14px;"><?php echo $fetch_product['brand_desc']; ?></textarea></td>
                                <td style="text-align: center;">
                                    <input type="submit" name="update" value="Update" class="option-btn">
                                    <input type="hidden" name="id" value="<?php echo $fetch_product['brand_id']; ?>">
                                    <a href="manage-strip.php?remove=<?php echo $fetch_product['brand_id']; ?>" class="delete-btn" 
                                    onclick="return confirm('Remove item from menu?');">Remove</a>
                                </td>
                            </form>
                        </tr>
                        <?php
                    }
                }
                else
                {
                    echo "<tr style='text-align: center;
                    padding-top: 30px;
                    font-weight: 600;
                    font-size: 18px;'><td colspan='7';>No brands</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
