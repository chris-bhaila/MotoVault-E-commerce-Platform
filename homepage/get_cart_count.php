<?php
session_start();
header('Content-Type: application/json');

$count = 0;

if (isset($_SESSION['UID'])) {
    $cart_data = isset($_COOKIE['shopping_cart']) ? json_decode($_COOKIE['shopping_cart'], true) : [];
    
    if (is_array($cart_data)) {
        foreach ($cart_data as $item) {
            if (isset($item['user_id']) && $item['user_id'] == $_SESSION['UID']) {
                $count += $item['item_quantity'] ?? 0;
            }
        }
    }
}

echo json_encode(['count' => $count]);
?>