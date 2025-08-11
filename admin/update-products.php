<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="jquery-3.7.1.min.js"></script>
<?php
    include("../dbconn.php");
    session_start();
    if(!isset($_SESSION['AID'])) {
        header('location: SignIn.php');
        die();
    }
    function normalize_quotes($input) {
        return str_replace(
            ["‘", "’", "“", "”"],
            ["'", "'", '"', '"'],
            $input
        );
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = mysqli_real_escape_string($conn, normalize_quotes($_POST['id']));
        $name = mysqli_real_escape_string($conn, normalize_quotes($_POST["name"]));
        $price = mysqli_real_escape_string($conn, normalize_quotes($_POST["price"]));
        $category = mysqli_real_escape_string($conn, normalize_quotes($_POST["category"]));
        $sub_category = mysqli_real_escape_string($conn, normalize_quotes($_POST["sub_category"]));
        $brand = mysqli_real_escape_string($conn, normalize_quotes($_POST['brand']));
        $stock = mysqli_real_escape_string($conn, normalize_quotes($_POST['stock']));
        $description = mysqli_real_escape_string($conn, normalize_quotes($_POST['description']));
        $features = mysqli_real_escape_string($conn, normalize_quotes($_POST['features']));
        $tags = mysqli_real_escape_string($conn, normalize_quotes($_POST["tags"]));


        
        // Fetch the current image from the database
        $result = mysqli_query($conn, "SELECT image FROM motoproducts WHERE product_id='$id'");
        $currentImage = mysqli_fetch_assoc($result);
        $currentImagePath = $currentImage['image'];
    
        // Handle the new image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image'];
            $newImagePath = basename($image['name']);
    
            // Ensure the upload directory exists
            if (!is_dir('products/')) {
                mkdir('products/', 0755, true);
            }
    
            // Move the uploaded image to the desired directory
            if (move_uploaded_file($image['tmp_name'], $newImagePath)) {
                if (file_exists($currentImagePath) && $currentImagePath != $newImagePath) {
                    unlink($currentImagePath);
                }
                $imagePath = mysqli_real_escape_string($conn, $newImagePath);
            } else {
                die('Failed to upload the new image.');
            }
            } else {
                $imagePath = mysqli_real_escape_string($conn, $currentImagePath);
            }
    
        // Update the database with the new image path
        $query = "UPDATE motoproducts 
                  SET name='$name', price='$price', brand_fid='$brand', category_fid='$category',
                      sub_cat_fid='$sub_category', stock='$stock',
                      description='$description', features='$features', image='$imagePath', tags='$tags'
                  WHERE product_id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Product updated successfully',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'update-products.php';
                    });
                });
            </script>";
    } else {
        die('Query failed: ' . mysqli_error($conn));
    }
}
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $sql1 = "DELETE FROM `review` WHERE product_id='$remove_id'";
    $sql2 = "DELETE FROM `motoproducts` WHERE product_id='$remove_id'";

    if(mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2))
    {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Deleted successfully',
                    text: 'The product has been deleted.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'update-products.php';
                });
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to delete the product.',
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
        *
        {
            font-family: 'Monsterrat', sans-serif;
        }
        body
        {
            margin-left: 2em;
            height: 100vh;
            overflow-y: hidden;
        }
        .custom-input {
            width: 27em;
            height: 50px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: 'Monsterrat', sans-serif;
        }
        #features,#description,#tags
        {
            width: 27em;
            height: 10em;
        }
        .update-btn,.btn {
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
            font-family: 'Monsterrat', sans-serif;
        }
        .update-btn:hover,
        .btn:hover {
            color: black;
            background-color: white;
        }
        .main-container {
            display: flex;
            margin-top: 25px;
            padding: 60px;
        }
        .main-container .sub-container1 {
            width: 93vw;
            position: absolute;
            /* box-shadow: 0 7px 25px rgba(0, 0, 0, 0.12); */
            overflow-y: auto;
            margin-right: 100vh;
            border-radius: 20px;
            padding: 20px;
            height: 90vh;
        }
        .main-container .sub-container2 {
            margin-top: 20px;
            width: auto;
            position: relative;
            margin-left: 90vh;
            overflow-x: auto;
            height: 90vh;
        }
        .main-container .sub-container1::-webkit-scrollbar {
            display: none;
        }
        .main-container .sub-container2::-webkit-scrollbar {
            display: none;
        }
        /* .main-container .sub-container2::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .main-container .sub-container2::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        .main-container .sub-container2::-webkit-scrollbar-thumb:hover {
            background: #555;
        } 
        .main-container .sub-container2 {
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }*/
        .r-btn
        {
            font-size: 16px;
            padding: 10px;
            width: 10vh;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s linear;
            border-radius: 4px;
            color: white;
            border: 1px solid red;
            background-color: red;
            font-weight: bolder;
            letter-spacing: 0.8px;
        }
        .r-btn:hover
        {
            color: white;
            border: 1px solid crimson;
            background-color: crimson;
        }
    </style>
</head>
<body>
    <?php
        include('header.php');
    ?>
    <div class="main-container">
        <div class="sub-container1">
            <h1>Update selected product</h1>
            <table cellpadding="10">
            <form action="" method="POST" enctype="multipart/form-data" class="form">
                <input type="hidden" name="id" id="id">
                <tr><td>Name: </td>
                <td><input type="text" name="name" class="custom-input" id="name" required></td></tr>
                <tr><td>Price: </td>
                <td><input type="number" name="price" class="custom-input" id="price" required></td></tr>
                <tr><td>Category: </td>
                <td>
                    <?php
                    $count = 0;
                    $select_product = mysqli_query($conn, "SELECT * FROM `categories`") or die('Query failed.');
                    if (mysqli_num_rows($select_product) > 0) {
                        while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                            $count++;
                            if ($count > 2 && $count % 2 == 0) {
                                echo "<br>";
                            }
                            ?>
                            <input type="radio" name="category" value="<?php echo $fetch_product['category_id']; ?>" class="category">
                            <?php echo $fetch_product['name'];
                        }
                    }
                    ?>
                </td></tr>
                <tr id="subCategoryRow" class="fade">
                        <td>Sub-Category:</td>
                        <td>
                            <?php
                                $count = 0;
                                $select_product1 = mysqli_query($conn, "SELECT * FROM `sub_category`") or die('Query failed.');
                                if (mysqli_num_rows($select_product1) > 0) {
                                    while ($fetch_product1 = mysqli_fetch_assoc($select_product1)) {
                                        $count++;
                                        if ($count > 2 && $count % 2 == 0) {
                                            echo "<br>";
                                        }
                                        ?>
                                        <input type="radio" name="sub_category" value="<?php echo $fetch_product1['sub_cat_id']; ?>" class="sub_category">
                                        <?php echo $fetch_product1['name']; ?>
                                        <?php
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                <tr><td>Brand: </td>
                <td>
                    <?php
                    $count = 0;
                    $select_product = mysqli_query($conn, "SELECT * FROM `brands`") or die('Query failed.');
                    if (mysqli_num_rows($select_product) > 0) {
                        while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                            $count++;
                            if ($count > 3 && $count % 3 == 0) {
                                echo "<br>";
                            }
                            ?>
                            <input type="radio" name="brand" value="<?php echo $fetch_product['brand_id']; ?>" class="brand">
                            <?php echo $fetch_product['name']; ?>
                            <?php
                        }
                    }
                    ?>
                </td></tr>
                <tr><td>Stock: </td>
                <td><input type="number" name="stock" class="custom-input" id="stock" required></td></tr>
                <tr><td>Description: </td>
                <td><textarea name="description" class="custom-input" id="description" required></textarea></td></tr>
                <tr><td>Enter Points for Features:</td>
                <td><textarea name="features" id="features" class="custom-input" required></textarea>
                <p style="color: red;">*Use '!' for line separation</p></td></tr>
                <tr>
                    <td>Tags:</td>
                    <td style="position: relative;">
                        <textarea name="tags" class="custom-input" required id="tags"></textarea>
                    </td>
                    <td></td>
                    </tr>
                    <td><label class="image">Image</label></td>
                    <td><input type="file" name="image" accept=".jpg, .jpeg, .png, .svg" class="image1"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Update" class="btn"></td>
                </tr>
            </form>



            </table>
        </div>
        <div class="sub-container2">
            <h1>Current Inventory</h1>
            <table cellpadding="20">
                <tr>
                    <th class="p-id" style="border-bottom: 2px solid #000;">ID</th>
                    <th class="p-image" style="border-bottom: 2px solid #000;">Image</th>
                    <th class="p-name" style="border-bottom: 2px solid #000;">Name</th>
                    <th class="p-price" style="border-bottom: 2px solid #000;">Price</th>
                    <th class="" style="border-bottom: 2px solid #000;">Stock</th>
                    <th class="p-action" style="border-bottom: 2px solid #000;">Action</th>
                </tr>
                <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `motoproducts`") or die('Query failed.');
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                ?>
                    <tr>
                        <form action="" method="post" class="product-form">
                            <td class="p-id"><?php echo $fetch_product['product_id']; ?></td>
                            <td class="p-image"><img src="products/<?php echo $fetch_product['image']; ?>" alt="" width="200px"></td>
                            <td class="p-name"><?php echo $fetch_product['name']; ?></td>
                            <td class="p-price"><?php echo $fetch_product['price']; ?></td>
                            <td class="p-stock" style="text-align: center;"><?php echo $fetch_product['stock']; ?></td>
                            <td>
                                <!-- Fix the data attributes in the update button -->
                                <button type="button" class="update-btn" 
                                    data-id="<?php echo $fetch_product['product_id']; ?>" 
                                    data-name="<?php echo $fetch_product['name']; ?>" 
                                    data-price="<?php echo $fetch_product['price']; ?>" 
                                    data-category="<?php echo $fetch_product['category_fid']; ?>" 
                                    data-sub-category="<?php echo $fetch_product['sub_cat_fid']; ?>"
                                    data-brand="<?php echo $fetch_product['brand_fid']; ?>" 
                                    data-stock="<?php echo $fetch_product['stock']; ?>" 
                                    data-description="<?php echo $fetch_product['description']; ?>" 
                                    data-features="<?php echo $fetch_product['features']; ?>" 
                                    data-tags="<?php echo $fetch_product['tags']; ?>">Update</button><br><br>
                                <a href="update-products.php?remove=<?php echo $fetch_product['product_id']; ?>" class="r-btn">Remove</a>
                            </td>
                        </form>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('.update-btn').forEach(button => {
                button.addEventListener('click', () => {
                    document.getElementById('id').value = button.getAttribute('data-id');
                    document.getElementById('name').value = button.getAttribute('data-name');
                    document.getElementById('price').value = button.getAttribute('data-price');
                    document.getElementById('stock').value = button.getAttribute('data-stock');
                    document.getElementById('description').value = button.getAttribute('data-description');
                    document.getElementById('features').value = button.getAttribute('data-features');
                    document.getElementById('tags').value = button.getAttribute('data-tags');

                    let category = button.getAttribute('data-category');
                    document.querySelectorAll('.category').forEach((elem) => {
                        if (elem.value == category) {
                            elem.checked = true;
                        }
                    });
                    let sub_category = button.getAttribute('data-sub-category');
                    document.querySelectorAll('.sub_category').forEach((elem) => {
                        if (elem.value == sub_category) {
                            elem.checked = true;
                        }
                    });

                    let brand = button.getAttribute('data-brand');
                    document.querySelectorAll('.brand').forEach((elem) => {
                        if (elem.value == brand) {
                            elem.checked = true;
                        }
                    });
                });
            });
        });
        $('.r-btn').on('click',function(e){
            e.preventDefault();
            const href = $(this).attr('href')
            Swal.fire({
                title: 'Are you sure you want to remove this product?',
                icon : 'warning',
                text : 'This action cannot be undone. Please make sure there are no orders of this product before removing.',
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
        function showHint(str) {
            const suggestionsBox = document.getElementById("suggestions");
            if (str.length === 0) {
                suggestionsBox.innerHTML = "";
                return;
            }

            const lastWord = getLastWord(str);

            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    const tags = this.responseText.split(",");
                    let html = "";
                    tags.forEach(tag => {
                        tag = tag.trim();
                        if (tag !== "No Suggestions Found" && tag !== "") {
                            html += `<div onclick="addTag('${tag}')"
                                        style="padding: 5px; cursor: pointer;"
                                        onmouseover="this.style.backgroundColor='#eee'"
                                        onmouseout="this.style.backgroundColor='white'">${tag}</div>`;
                        }
                    });
                    suggestionsBox.innerHTML = html;
                }
            };
            xhr.open("GET", "tagList.php?q=" + encodeURIComponent(lastWord), true);
            xhr.send();
        }

        // Helper: Get the last word (partial tag) from textarea
        function getLastWord(inputText) {
            let parts = inputText.split(',');
            return parts[parts.length - 1].trim(); // Last segment after comma
        }

        // Insert selected tag, replacing the last typed word
        function addTag(selectedTag) {
            const input = document.getElementById("tags");
            let currentValue = input.value;
            let parts = currentValue.split(',');
            
            // Replace the last word with selectedTag
            parts[parts.length - 1] = " " + selectedTag; // Add space before tag
            let newTags = parts.map(tag => tag.trim()).filter(tag => tag !== "");

            // Remove duplicates
            newTags = [...new Set(newTags)];

            // Add trailing comma and space
            input.value = newTags.join(", ") + ", ";

            // Clear suggestions box
            document.getElementById("suggestions").innerHTML = "";
        }
    </script>
</body>
</html>
