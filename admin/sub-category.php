<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="jquery-3.7.1.min.js"></script>
<?php     
    include("../dbconn.php");
    session_start();
    if(!isset($_SESSION['AID'])) {
        header('location: SignIn.php');
        die();
    }
    if(isset($_POST["submit"])) {
        $name = $_POST["name"];
        $category = $_POST["category"];
    
        if($_FILES["image"]["error"] === 4) {
            echo "<script>
            alert('Image does not exist');
            </script>";
        } else {
            $fileName = $_FILES["image"]["name"];
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];
            
            $validImageExtension = ['jpg','jpeg','png','svg'];
            $imageExtension = explode('.',$fileName);
            $imageExtension = strtolower(end($imageExtension));
            
            if(!in_array($imageExtension, $validImageExtension)) {
                echo "<script>
                alert('Invalid Image');
                </script>";
            } else if($fileSize > 10000000) {
                echo "<script>
                alert('Image size is too large.');
                </script>";
            } else {
                move_uploaded_file($tmpName, 'subcategories/'. $fileName);
                $query = "INSERT INTO sub_category (name, cat_id, image) 
                          VALUES('$name','$category','$fileName')";
                $res = mysqli_query($conn, $query);
                if($res) {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    title: 'Sub-category added successfully',
                                    icon: 'success'
                                }).then(() => {
                                    window.location.href = 'sub-category.php';
                                });
                            });
                        </script>";
                } else {
                    echo "<script>
                    alert('Error');
                    </script>";
                }
            }
        }
    }
    if(isset($_POST['update']))
    {
        $update_id=$_POST['id'];
        $update_name=$_POST['p-name'];
        if(mysqli_query($conn, "UPDATE sub_category SET name='$update_name' WHERE sub_cat_id='$update_id'"))
        {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Sub-category updated successfully',
                    icon: 'success'
                    }).then(() => {
                        window.location.href = 'sub-category.php';
                    });
                });
                </script>";
        }
        else
        {
            die('Query failed');
        }
    }

    if(isset($_GET['remove']))
    {
        $remove_id=$_GET['remove'];
        $sql1 = "DELETE FROM `motoproducts` WHERE sub_cat_fid='$remove_id'";
        $sql2 = "DELETE FROM `sub_category` WHERE sub_cat_id='$remove_id'";

        if(mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2))
        {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Sub-category deleted successfully',
                        icon: 'success'
                        }).then(() => {
                        window.location.href = 'sub-category.php';
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
    <link rel="stylesheet" href="admin.css">
    <style>
        body
        {
            font-family: 'Monsterrat', sans-serif;
            overflow-x: hidden;
        }
        .main {
            margin-top: 20px;
            padding: 70px;
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
        .name{
            font-size: 20px;
            margin-left: 10px;
            height: 30px;
            margin-bottom: 20px;
        }
        .category {
            font-size: 20px;
            margin-left: 10px;
            margin-bottom: 30px;
            height: 50px;
        }
        .image {
            font-size: 20px;
            margin-left: 10px;
            margin-bottom: 30px;
        }
        .image1{
            margin-left: 10px;
            margin-top: 20px;
        }
        .btn {
            font-family: 'Monsterrat', sans-serif;
            margin-left: 10px;
            margin-top: 20px;
            width: 80px;
            height: 35px;
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
            width: 60%;
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
            width: 180px;
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
        .brandsav .p-action
        {
            width: 300px;
            text-align: center;
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
            background-color: red;
            cursor: pointer;
            transition: 0.3s ease-in;
            border-radius: 12px;
            border: 1px solid red;
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
            background-color: rgb(42, 42, 205);
            cursor: pointer;
            transition: 0.3s ease-in;
            border-radius: 12px;
        }
        .brandsav .option-btn:hover
        {
            color: blue;
            background-color: white;
        }
        .first input
        {
            margin-left: 30px;
        }
    </style>
</head>
<body>
    <?php
        include('header.php');
    ?>
    <div class="main">
        <h1>Enter the details to add a new sub-category.</h1>
        <form method="post" enctype="multipart/form-data">
            <table class="first">
                <tr>
                    <td><label class="name">Name</label></td>
                    <td><input type="text" name="name" class="name" required></td>
                </tr>
                <tr>
                    <td><label class="category">Sub-category </label></td>
                    <td><?php
                            $count = 0;
                            $select_product = mysqli_query($conn, "SELECT * FROM `categories`") or die('Query failed.');
                            if (mysqli_num_rows($select_product) > 0) {
                                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                                    $count++;
                                    if ($count % 2 == 0) {
                                        echo "<br>";
                                    }
                                    ?>
                                    <input type="radio" name="category" value="<?php echo $fetch_product['category_id']; ?>" required>
                                    <?php echo $fetch_product['name']; ?>
                                    <?php
                                }
                            }
                            ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="image">Image</label></td>
                    <td><input type="file" name="image" accept=".jpg, .jpeg, .png, .svg" class="image1" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Add" class="btn"></td>
                </tr>
            </table>
        </form>

        <div class="brandsav">
            <h2>Current Sub-Categories</h2>
            <table cellpadding="20">
                <tr>
                    <th class="p-id" style="border-right: 1px solid black;">S.N.</th>
                    <th class="p-id">Image</th>
                    <th class="p-name">Name</th>
                    <th class="p-name">Main Category</th>
                    <th class="p-action">Action</th>
                </tr>
                <?php
                $index=1;
                // Query with JOIN to fetch subcategory details along with category name
                $select_product = mysqli_query($conn, "
                    SELECT sub_category.*, categories.name AS category_name
                    FROM sub_category
                    JOIN categories ON sub_category.cat_id = categories.category_id
                ") or die('Query failed.');
                
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                ?>
                        <tr>
                            <form action="" method="post">
                                <td class="p-id" style="text-align: center; border-right: 1px solid black;">
                                    <?php echo $index++; ?>
                                </td>
                                <td class="p-image" style="text-align: center;">
                                    <img src="subcategories/<?php echo $fetch_product['image']; ?>" alt="" height="100">
                                </td>
                                <td class="p-name" style="text-align: center;">
                                    <textarea name="p-name"><?php echo $fetch_product['name'] ?></textarea>
                                </td>
                                <td style="text-align: center; font-size: 18px; font-weight: 500;">
                                    <?php echo $fetch_product['category_name']; ?>
                                </td>
                                <td style="text-align: center;">
                                    <input type="submit" name="update" value="Update" class="option-btn">
                                    <input type="hidden" name="id" value="<?php echo $fetch_product['sub_cat_id'] ?>">
                                    <a href="sub-category.php?remove=<?php echo $fetch_product['sub_cat_id'] ?>" class="delete-btn" 
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
                    font-size: 18px;'><td colspan='7';>No sub categories</td></tr>";
                }
                ?>
            </table>

        </div>
    </div>
</body>
</html>
