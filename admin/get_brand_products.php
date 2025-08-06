<?php
// get_brand_products.php
include("../dbconn.php");
header('Content-Type: application/json');

if (!isset($_GET['brand_id'])) {
    echo json_encode(['error' => 'Brand ID missing']);
    exit;
}

$brand_id = (int)$_GET['brand_id'];

$query = mysqli_query($conn, "SELECT product_id, name, image, price, discount_percent FROM motoproducts WHERE brand_fid = $brand_id");

$products = [];

while($row = mysqli_fetch_assoc($query)) {
    $price = (float)$row['price'];
    $discountPercent = (float)$row['discount_percent'];
    $discountAmt = round(($discountPercent / 100) * $price, 2);
    $finalAmount = round($price - $discountAmt, 2);

    $products[] = [
        'product_id' => $row['product_id'],
        'name' => $row['name'],
        'image' => $row['image'],
        'price' => number_format($price, 2),
        'discount_amt' => number_format($discountAmt, 2),
        'final_amount' => number_format($finalAmount, 2),
    ];
}

echo json_encode(['products' => $products]);
?>
