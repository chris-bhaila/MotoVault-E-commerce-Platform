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
        $query = "UPDATE motoproducts 
                  SET discount_percent='$discount'
                  WHERE product_id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Discount updated successfully',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'discount.php';
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
                  WHERE product_id='$remove_id'";

    if(mysqli_query($conn, $sql1))
    {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Removed successfully',
                    text: 'The discount for this brand has been removed.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'discount.php';
                });
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to delete discount.',
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
                <td><input type="text" name="name" class="custom-input" id="name" readonly></td></tr>
                <tr><td>Price: </td>
                <td><input type="number" name="price" class="custom-input" id="price" readonly></td></tr>
                <tr><td>Discount %: </td>
                <td><input type="number" name="discount" class="custom-input" id="discount" required></td></tr>
                <tr><td>Discount amount: </td>
                <td><input type="number" name="discountAmt" class="custom-input" id="discountAmt" required></td></tr>
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
                            <td class="p-image"><img src="products/<?php echo $fetch_product['image']; ?>" alt="" height="100"></td>
                            <td class="p-name"><?php echo $fetch_product['name']; ?></td>
                            <td class="p-price"><?php echo $fetch_product['price']; ?></td>
                            <td class="p-stock" style="text-align: center;"><?php echo $fetch_product['stock']; ?></td>
                            <td>
                                <!-- Fix the data attributes in the update button -->
                                 <?php $disAmt = ($fetch_product['discount_percent']/100)*$fetch_product['price']; ?>
                                <button type="button" class="update-btn" 
                                    data-id="<?php echo $fetch_product['product_id']; ?>" 
                                    data-name="<?php echo $fetch_product['name']; ?>" 
                                    data-price="<?php echo $fetch_product['price']; ?>" 
                                    data-discount="<?php echo $fetch_product['discount_percent']; ?>" 
                                    data-discount-amt="<?php if($disAmt == 0)
                                        {
                                            echo '';
                                        }
                                        else
                                        {
                                            echo $disAmt;
                                        } ?>"?>Update</button><br><br>
                                <a href="discount.php?remove=<?php echo $fetch_product['product_id']; ?>" class="r-btn">Remove</a>
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
                    document.getElementById('discount').value = button.getAttribute('data-discount');
                    document.getElementById('discountAmt').value = button.getAttribute('data-discount-amt');
                });
            });
        });
        $('.r-btn').on('click',function(e){
            e.preventDefault();
            const href = $(this).attr('href')
            Swal.fire({
                title: 'Are you sure you want to remove the discount for this product?',
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

        document.addEventListener('DOMContentLoaded', () => {
        const priceInput = document.getElementById('price');
        const discountPercentInput = document.getElementById('discount');
        const discountAmtInput = document.getElementById('discountAmt');

        // When discount percent changes, update amount
        discountPercentInput.addEventListener('input', () => {
            const price = parseFloat(priceInput.value);
            const percentValue = discountPercentInput.value.trim();

            if (percentValue === '' || isNaN(price) || price === 0) {
                discountAmtInput.value = '';
                return;
            }

            const percent = parseFloat(percentValue);

            if (isNaN(percent) || percent === 0) {
                discountAmtInput.value = '';
                return;
            }

            const discountAmt = ((price * percent) / 100);
            discountAmtInput.value = discountAmt;
        });


        // When discount amount changes, update percent
        discountAmtInput.addEventListener('input', () => {
            const price = parseFloat(priceInput.value) || 0;
            const discountAmt = parseFloat(discountAmtInput.value);

            if (!discountAmt || discountAmt === 0 || price === 0) {
                discountPercentInput.value = '';
            } else {
                const percent = ((discountAmt / price) * 100).toFixed(2);
                discountPercentInput.value = percent;
            }
        });

    });
    </script>
</body>
</html>
