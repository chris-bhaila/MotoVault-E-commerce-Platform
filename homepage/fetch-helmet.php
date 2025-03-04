<?php
include("../dbconn.php");

if(isset($_POST['subcategories']) && !empty($_POST['subcategories'])) {
    $subcategories = $_POST['subcategories'];
    $subcategory_list = implode("','", $subcategories);

    // Query to select products based on the selected subcategories
    $query = "SELECT m.product_id, m.name AS product_name, m.image, m.price, m.stock 
              FROM motoproducts m 
              WHERE m.sub_cat_fid IN ('$subcategory_list') AND m.category_fid = '2'";

    $result = mysqli_query($conn, $query);

} else {
    // If no subcategories are selected, get all products in the main category
    $query = "SELECT m.product_id, m.name AS product_name, m.image, m.price, m.stock 
              FROM motoproducts m 
              WHERE m.category_fid = '2'";

    $result = mysqli_query($conn, $query);
}

// Check if there are any results
if(mysqli_num_rows($result) > 0) {
    while($fetch_product = mysqli_fetch_assoc($result)) {
        ?>
        <form method="post" class="product" action="productPage.php">
                            <a href="productPage.php?id=<?php echo $fetch_product['product_id'];?>">
                                <img src="../admin/products/<?php echo $fetch_product['image']; ?>" 
                                alt="<?php echo $fetch_product['product_name']; ?>" class="image">
                            </a>
                            <div class="box">
                                <div class="name"><?php echo $fetch_product['product_name']; ?></div>
                            </div>
                            <div class="price">
                                <?php if ($fetch_product['stock'] > 0) { ?>
                                    NPR <?php echo number_format($fetch_product['price']); ?>
                                <?php } else { ?>
                                    <span class="out-of-stock" style="color: grey;">Out of Stock</span>
                                <?php } ?>
                            </div>
                            <?php if ($fetch_product['stock'] <= 5 && $fetch_product['stock']>0) { ?>
                                <div class="l-stock">Limited Stock</div>
                            <?php } ?>
                        </form>
        <?php
    }
} else {
    echo "Nothing found";
}
?>
