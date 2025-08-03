<?php
include "../dbconn.php";

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

$sql = "SELECT product_id, name, price, stock, image FROM motoproducts LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

$products = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($products);
?>
