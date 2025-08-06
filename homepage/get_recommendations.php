<?php
session_start();
include("../dbconn.php");

header('Content-Type: application/json');

// Validate product ID
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($product_id <= 0) {
    echo json_encode(['error' => 'Invalid product ID']);
    exit();
}

// Execute Python script
$command = escapeshellcmd("python sbert_recommender.py $product_id");
$output = shell_exec($command);
$recommendations = json_decode($output, true);

if (empty($recommendations)) {
    echo json_encode(['error' => 'No recommendations available']);
    exit();
}

// Get product details for recommendations
$placeholders = implode(',', array_fill(0, count($recommendations), '?'));
$query = "SELECT product_id, name, image, price, stock FROM motoproducts WHERE product_id IN ($placeholders)";
$stmt = mysqli_prepare($conn, $query);

// Bind parameters
$types = str_repeat('i', count($recommendations));
$ids = array_column($recommendations, 'product_id');
mysqli_stmt_bind_param($stmt, $types, ...$ids);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[$row['product_id']] = $row;
}

// Format response
$response = [];
foreach ($recommendations as $rec) {
    if (isset($products[$rec['product_id']])) {
        $product = $products[$rec['product_id']];
        $response[] = [
            'id' => $product['product_id'],
            'name' => $product['name'],
            'image' => $product['image'],
            'price' => $product['price'],
            'stock' => $product['stock'],
            'score' => round($rec['score'] * 100, 2)
        ];
    }
}

echo json_encode($response);
?>