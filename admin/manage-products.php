<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="jquery-3.7.1.min.js"></script>
<?php
include("../dbconn.php");
session_start();
    if(!isset($_SESSION['AID'])) {
        header('location: SignIn.php');
        die();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve and escape inputs to handle special characters and single quotes
        $name = isset($_POST["name"]) ? addslashes($_POST["name"]) : '';
        $price = isset($_POST["price"]) ? addslashes($_POST["price"]) : '';
        $category = isset($_POST["category"]) ? addslashes($_POST["category"]) : '';
        $sub_category = isset($_POST["sub_category"]) ? addslashes($_POST["sub_category"]) : '';
        $brand = isset($_POST["brand"]) ? addslashes($_POST["brand"]) : '';
        $stock = isset($_POST["stock"]) ? addslashes($_POST["stock"]) : '';
        $description = isset($_POST["description"]) ? addslashes($_POST["description"]) : '';
        $features = isset($_POST["features"]) ? addslashes($_POST["features"]) : '';
        $images = isset($_FILES['images']) ? $_FILES['images'] : [];
    
        // Validation
        if (empty($sub_category)) {
            echo "<script>
                alert('Sub-category is required.');
                window.location.href = 'manage-products.php';
                </script>";
            exit();
        }
    
        $uploadDirectory = 'products/';
        $uploadedFiles = [];
        $validImageExtension = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
        $errors = [];
    
        // Ensure the upload directory exists
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }
    
        foreach ($images["name"] as $key => $fileName) {
            $fileSize = $images["size"][$key];
            $tmpName = $images["tmp_name"][$key];
            $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
            if (!in_array($imageExtension, $validImageExtension)) {
                $errors[] = "Invalid Image: $fileName";
            } else if ($fileSize > 10000000) {
                $errors[] = "Image size is too large: $fileName";
            } else {
                $targetFilePath = $uploadDirectory . basename($fileName);
                if (move_uploaded_file($tmpName, $targetFilePath)) {
                    $uploadedFiles[] = basename($fileName);
                } else {
                    $errors[] = "Error uploading: $fileName";
                }
            }
        }
    
        if (empty($errors)) {
            // Escape `$name` to avoid SQL injection and handle single quotes
            $sql = "SELECT * FROM motoproducts WHERE name='$name'";
            $result = mysqli_query($conn, $sql);
            $count_name = mysqli_num_rows($result);
    
            if ($count_name == 0) {
                $imagePath = !empty($uploadedFiles) ? addslashes($uploadedFiles[0]) : '';
                $sql = "INSERT INTO motoproducts (name, price, brand_fid, category_fid, sub_cat_fid, stock, description, features, image, discount_percent)
                        VALUES ('$name', '$price', '$brand', '$category', '$sub_category', '$stock', '$description', '$features', '$imagePath',NULL)";
                $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Product added successfully',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'manage-products.php';
                    });
                });
            </script>";
            } else {
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Database error!',
                        icon: 'error'
                    }).then(() => {
                        window.location.href = 'manage-products.php';
                    });
                });
            </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Product already exists',
                        text: 'The order has been deleted.',
                        icon: 'warning'
                    }).then(() => {
                        window.location.href = 'manage-products.php';
                    });
                });
            </script>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<script>
            alert('$error');
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="Monsterrat.css">
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
        .custom-input {
            width: 300px;
            height: 50px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: Oswald, sans-serif;
        }
        .sub-container1
        {
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            padding: 20px;
            margin-bottom: 40px;
        }
        .sub-container2
        {
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12);
            padding: 20px;
        }
        .btn {
            padding: 10px;
            width: 10vh;
            background-color: black;
            border: 1px solid black;
            font-weight: bolder;
            color: white;
            cursor: pointer;
            letter-spacing: 0.8px;
            border-radius: 4px;
            transition: 0.2s linear;
            font-family: Oswald, sans-serif;
        }

        .btn:hover {
            color: black;
            background-color: white;
        }
        .product-img {
            width: 200px;
            object-fit: contain;
            display: block;
            margin: auto;
        }

    </style>
</head>

<body>
    <?php
        include('header.php');
    ?>
    <div class="main-container">
        <div class="sub-container1">
            <h1>Enter details to add a new product</h1>
            <form action="" method="POST" enctype="multipart/form-data" class="form">
                <table cellpadding="10">
                    <tr>
                        <td>Name: </td>
                        <td><input type="text" name="name" class="custom-input" style="width: 20vw;" required></td>
                    </tr>
                    <tr>
                        <td>Price: </td>
                        <td><input type="number" name="price" class="custom-input" style="width: 20vw;" required></td>
                    </tr>
                    <tr>
                        <td>Category:</td>
                        <td>
                            <?php
                            $select_product = mysqli_query($conn, "SELECT * FROM `categories`") or die('Query failed.');
                            if (mysqli_num_rows($select_product) > 0) {
                                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                                    ?>
                                    <input type="radio" name="category" value="<?php echo $fetch_product['category_id']; ?>" onclick="loadSubCategories(this.value)" required>
                                    <?php echo $fetch_product['name']; ?>
                                    <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr id="subCategoryRow" class="fade" style="display:none;">
                        <td>Sub-Category:</td>
                        <td id="subCategoryContent">
                            <!-- Sub-categories will be loaded here by JavaScript -->
                        </td>
                    </tr>
                    <tr>
                        <td>Brand: </td>
                        <td>
                            <?php
                                $count = 0;
                                $select_product = mysqli_query($conn, "SELECT * FROM `brands`") or die('Query failed.');
                                if (mysqli_num_rows($select_product) > 0) {
                                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                                        $count++;
                                        if ($count > 7 && $count % 7 == 0) {
                                            echo "<br>";
                                        }
                                        ?>
                                        <input type="radio" name="brand" value="<?php echo $fetch_product['brand_id']; ?>" class="brand" required>
                                        <?php echo $fetch_product['name']; ?>
                                        <?php
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Stock: </td>
                        <td><input type="number" name="stock" class="custom-input" style="width: 20vw;" required></td>
                    </tr>
                    <tr>
                        <td>Description: </td>
                        <td><textarea name="description" class="custom-input" style="width: 20vw; height: 13vh;" required></textarea></td>
                    </tr>
                    <tr>
                        <td>Enter Points for Features:</td>
                        <td><textarea name="features" class="custom-input" style="width: 20vw; height: 13vh;" required></textarea>
                        <p style="color: red;">*Use '!' for line separation</p></td>
                    </tr>
                    <tr>
                        <td><label class="image">Image</label></td>
                        <td><input type="file" name="images[]" accept=".jpg, .jpeg, .png, .svg, .webp" class="image1" multiple required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" value="Add" class="btn"></td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="sub-container2">
            <h2>In Inventory</h2>
            <table cellpadding="20">
            <tr>
                <th class="p-id" style="border-bottom: 2px solid #000; border-right: 2px solid #000;">ID</th>
                <th class="p-image" style="border-bottom: 2px solid #000;">Image</th>
                <th class="p-name" style="border-bottom: 2px solid #000;">Name</th>
                <th class="p-price" style="border-bottom: 2px solid #000;">Price</th>
                <th class="" style="border-bottom: 2px solid #000;">Category</th>
                <th class="" style="border-bottom: 2px solid #000;">Sub-category</th>
                <th class="" style="border-bottom: 2px solid #000;">Brand</th>
                <th class="" style="border-bottom: 2px solid #000;">Remaining Stock</th>
                <th class="" style="border-bottom: 2px solid #000; text-align: left;">Description</th>
                <th class="" style="border-bottom: 2px solid #000; text-align: left;">Features</th>
            </tr>
                <?php
                $select_product = mysqli_query($conn, "
                    SELECT p.*, c.name AS category_name, s.name AS sub_cat_name, b.name AS brand_name
                    FROM motoproducts p
                    LEFT JOIN categories c ON p.category_fid = c.category_id
                    LEFT JOIN sub_category s ON p.sub_cat_fid = s.sub_cat_id
                    LEFT JOIN brands b ON p.brand_fid = b.brand_id
                    ORDER BY p.product_id DESC
                ") or die('Query failed.');
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                ?>
                        <tr>
                            <td class="p-id" style="border-right: 2px solid #000;"><?php echo $fetch_product['product_id'] ?></td>
                            <td class="p-image" style="text-align: center;"><img src="products/<?php echo $fetch_product['image']; ?>" alt="" class="product-img"></td>
                            <td class="p-name"><?php echo $fetch_product['name'] ?></td>
                            <td class="p-price"><?php echo $fetch_product['price'] ?></td>
                            <td class="p-cat" style="text-align: center;"><?php echo $fetch_product['category_name'] ?></td>
                            <td class="p-sub_category" style="text-align: center;"><?php echo $fetch_product['sub_cat_name'] ?></td>
                            <td class="p-brand" style="text-align: center;"><?php echo $fetch_product['brand_name'] ?></td>
                            <td class="p-stock" style="text-align: center;"><?php echo $fetch_product['stock'] ?></td>
                            <td class="p-desc"><?php echo $fetch_product['description'] ?></td>
                            <td class="p-feat"><?php echo $fetch_product['features'] ?></td>
                            <!-- <td><input type="submit" name="update" value="Update" class="option-btn">
                            <input type="hidden" name="id" value="<?php echo $fetch_product['product_id'] ?>">
                                <a href="manage-product.php?remove=<?php echo $fetch_product['product_id'] ?>" class="delete-btn" 
                                onclick="return confirm('Remove item from menu?');">Remove</a>
                                </form></td> -->
                        </tr>
                <?php
                    }
                }
                else
                {
                    echo "<tr style='text-align: center;
                    padding-top: 30px;
                    font-weight: 600;
                    font-size: 18px;'><td colspan='7';>No products</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
    <script>
        function loadSubCategories(categoryId) {
            var subCategoryRow = document.getElementById('subCategoryRow');
            var subCategoryContent = document.getElementById('subCategoryContent');
            
            subCategoryRow.style.display = 'table-row'; // Ensure the row is visible

            // Fetch existing sub-categories using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_sub_categories.php?cat_id=' + encodeURIComponent(categoryId), true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    subCategoryContent.innerHTML = xhr.responseText;
                    subCategoryRow.classList.add('show'); // Apply the fade-in effect

                    // Add event listeners to dynamically added sub-category elements
                    addNewSubCategoryEventListeners();
                }
            };
            xhr.send();
        }

        function addNewSubCategoryEventListeners() {
            var subCategoryInputs = document.querySelectorAll('input[name="sub_category"]');
            subCategoryInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    // Handle sub-category change here if needed
                });
            });
        }
    </script>
</body>

</html>
