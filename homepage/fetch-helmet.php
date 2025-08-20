<?php
include("../dbconn.php");

if(isset($_POST['subcategories']) && !empty($_POST['subcategories'])) {
    $subcategories = $_POST['subcategories'];
    $subcategory_list = implode("','", $subcategories);

    // Query to select products based on the selected subcategories
    $query = "SELECT m.product_id, m.name AS product_name, m.image, m.price, m.stock, m.discount_percent 
              FROM motoproducts m 
              WHERE m.sub_cat_fid IN ('$subcategory_list') AND m.category_fid = '2'";

    $result = mysqli_query($conn, $query);

} else {
    // If no subcategories are selected, get all products in the main category
    $query = "SELECT m.product_id, m.name AS product_name, m.image, m.price, m.stock, m.discount_percent
              FROM motoproducts m 
              WHERE m.category_fid = '2'";

    $result = mysqli_query($conn, $query);
}

// Check if there are any results
$products = [];
if(mysqli_num_rows($result) > 0) {
    // Fetch all products into an array
    while($fetch_product = mysqli_fetch_assoc($result)) {
        $products[] = $fetch_product;
    }

    // Sort: in-stock first, out-of-stock last
    usort($products, function($a, $b) {
        return ($b['stock'] > 0) - ($a['stock'] > 0);
    });

    // Loop through sorted products
    foreach($products as $fetch_product) {
        ?>
        <form method="post" class="product" action="productPage.php">
            <a href="productPage.php?id=<?php echo $fetch_product['product_id']; ?>" style="position: relative; display: inline-block;">
                <?php if (!empty($fetch_product['discount_percent']) && $fetch_product['discount_percent'] > 0 && $fetch_product['stock'] > 0) { ?>
                    <div style="position: absolute; top: 8px; right: 8px; background-color: red; color: white; padding: 4px 8px; font-size: 12px; font-weight: bold; border-radius: 5px; z-index: 5;">
                        -<?php echo $fetch_product['discount_percent']; ?>% off
                    </div>
                <?php } ?>
                <img src="../admin/products/<?php echo $fetch_product['image']; ?>" 
                alt="<?php echo $fetch_product['product_name']; ?>" class="image">
            </a>

            <div class="box">
                <div class="name"><?php echo $fetch_product['product_name']; ?></div>
            </div>

            <div class="price">
                <?php 
                if ($fetch_product['stock'] > 0) { 
                    $truePrice = $fetch_product['price'] - ($fetch_product['discount_percent'] / 100) * $fetch_product['price'];
                    echo '<p style="font-size: 18px; color: green; font-weight: 500;">NPR ' . number_format($truePrice) . '</p>';
                } else { ?>
                    <span class="out-of-stock" style="color: grey;">Out of Stock</span>
                <?php } ?>
            </div>

            <?php if ($fetch_product['stock'] < 5 && $fetch_product['stock'] > 0) { ?>
                <div class="l-stock">Limited Stock</div>
            <?php } ?>
        </form>
        <?php
    }
} else {
    echo "Nothing found";
}

?>
