<?php
header('Content-Type: application/json');

// Database connection
include('../dbconn.php');

// Get search term
$searchTerm = isset($_GET['q']) ? $_GET['q'] : '';

// Prepare SQL query (using prepared statements for security)
$stmt = $db->prepare("
    SELECT id, name, price, description 
    FROM products 
    WHERE name LIKE :search OR description LIKE :search
");

// Execute query with wildcards
$searchParam = "%$searchTerm%";
$stmt->bindParam(':search', $searchParam);
$stmt->execute();

// Fetch results
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return JSON response
echo json_encode($products);
?>