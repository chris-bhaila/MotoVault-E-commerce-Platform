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
        $id = addslashes($_POST['id']);
        $name = addslashes($_POST["name"]);
        $discount = addslashes($_POST["discount"]);
    
        // Update the database with the new image path
        $query1 = "UPDATE motoproducts 
                  SET discount_percent='$discount'
                  WHERE brand_fid='$id'";
        $query2 = "UPDATE brands 
                  SET brand_discount_percent='$discount'
                  WHERE brand_id='$id'";

    if (mysqli_query($conn, $query1) && mysqli_query($conn, $query2)) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Discount updated successfully',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'discountBrand.php';
                    });
                });
            </script>";
    } else {
        die('Query failed: ' . mysqli_error($conn));
    }
}
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $sql1 = "UPDATE motoproducts 
                  SET discount_percent=NULL
                  WHERE brand_fid='$remove_id'";
    $sql2 = "UPDATE brands 
                  SET brand_discount_percent=NULL
                  WHERE brand_id='$remove_id'";

    if(mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2))
    {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Removed successfully',
                    text: 'The discount for this brand has been removed.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'discountBrand.php';
                });
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to delete brand discount.',
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
        .main-container .brand-products-table-container
        {
            width: 40vw;
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
        .sub-container2 table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }
        th.p-image,
        td.p-image {
            width: 50%;
            text-align: center;
        }
        th.p-id,
        td.p-id {
            width: 10%;
        }
        th.p-name,
        td.p-name {
            width: 20%;
        }
        th.p-action,
        td.p-action {
            width: 20%;
            text-align: center;
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
                <td><input type="text" name="name" class="custom-input" id="name" readonly></td></tr>
                <tr><td>Discount %: </td>
                <td><input type="number" name="discount" class="custom-input" id="discount" required></td></tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Update" class="btn"></td>
                </tr>
            </form>
            </table>
            <div class="brand-products-table-container" id="brand-products-table-container"></div>


        </div>
        <div class="sub-container2">
            <h1>Current Inventory</h1>
            <table cellpadding="20">
                <tr>
                    <th class="p-id" style="border-bottom: 2px solid #000;">ID</th>
                    <th class="p-image" style="border-bottom: 2px solid #000;" width="50%">Image</th>
                    <th class="p-name" style="border-bottom: 2px solid #000;">Name</th>
                    <th class="p-action" style="border-bottom: 2px solid #000;">Action</th>
                </tr>
                <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `brands`") or die('Query failed.');
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                ?>
                    <tr>
                        <form action="" method="post" class="product-form">
                            <td class="p-id"><?php echo $fetch_product['brand_id']; ?></td>
                            <td class="p-image" width="50%"><img src="brands/<?php echo $fetch_product['image']; ?>" alt="" width="150"></td>
                            <td class="p-name" style="text-align: center;"><?php echo $fetch_product['name']; ?></td>
                            <td class="p-action">
                                <!-- Fix the data attributes in the update button -->
                                <button type="button" class="update-btn"
                                    data-id="<?php echo $fetch_product['brand_id']; ?>" 
                                    data-name="<?php echo $fetch_product['name']; ?>" 
                                    data-discount="<?php echo $fetch_product['brand_discount_percent']; ?>">Update</button><br><br>
                                <a href="discountBrand.php?remove=<?php echo $fetch_product['brand_id']; ?>" class="r-btn">Remove</a>
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
                    document.getElementById('discount').value = button.getAttribute('data-discount');
                });
            });
        });
        $('.r-btn').on('click',function(e){
            e.preventDefault();
            const href = $(this).attr('href')
            Swal.fire({
                title: 'Are you sure you want to remove the discount for this brand?',
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
        let currentBrandProducts = []; // store fetched products of brand

        document.addEventListener('DOMContentLoaded', (event) => {
            const discountInput = document.getElementById('discount');
            const container = document.getElementById('brand-products-table-container');

            function renderProductsTable(products, discountPercent) {
                if (!products.length) {
                    container.innerHTML = '<p>No products found for this brand.</p>';
                    return;
                }

                let html = `<h2>Products of Selected Brand</h2>
                    <table cellpadding="10" border="1" style="width:100%; border-collapse: collapse; margin-top:20px;">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Discount Amt</th>
                        <th>Amount after Discount</th>
                    </tr>`;

                products.forEach(product => {
                    const price = parseFloat(product.price.replace(/,/g, ''));
                    const discountAmt = ((discountPercent / 100) * price).toFixed(2);
                    const finalAmt = (price - discountAmt).toFixed(2);

                    html += `<tr>
                        <td>${product.product_id}</td>
                        <td style="text-align:center;"><img src="products/${product.image}" alt="" style="max-width:100px; max-height:80px;"></td>
                        <td>${product.name}</td>
                        <td>Rs. ${price.toFixed(2)}</td>
                        <td>Rs. ${discountAmt}</td>
                        <td>Rs. ${finalAmt}</td>
                    </tr>`;
                });

                html += '</table>';

                container.innerHTML = html;
            }

            document.querySelectorAll('.update-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const brandId = button.getAttribute('data-id');
                    const brandName = button.getAttribute('data-name');
                    let discountPercent = button.getAttribute('data-discount');

                    // If discount is 0, null, empty, or not a number, clear input
                    if (!discountPercent || parseFloat(discountPercent) === 0) {
                        discountPercent = '';
                    }

                    document.getElementById('id').value = brandId;
                    document.getElementById('name').value = brandName;
                    document.getElementById('discount').value = discountPercent;
                    // Fetch products of brand from server (only once)
                    fetch('get_brand_products.php?brand_id=' + brandId)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                container.innerHTML = '<p>' + data.error + '</p>';
                                currentBrandProducts = [];
                                return;
                            }
                            currentBrandProducts = data.products;
                            renderProductsTable(currentBrandProducts, discountPercent);
                        })
                        .catch(err => {
                            container.innerHTML = '<p>Error loading products.</p>';
                            currentBrandProducts = [];
                            console.error(err);
                        });
                });
            });

            // Real-time update of discount amounts table when typing in discount input
            discountInput.addEventListener('input', () => {
                let newDiscount = parseFloat(discountInput.value);
                if (isNaN(newDiscount) || newDiscount < 0) newDiscount = 0;
                if (newDiscount > 100) newDiscount = 100; // Optional: clamp max 100%

                renderProductsTable(currentBrandProducts, newDiscount);
            });
        });


    </script>
</body>
</html>
