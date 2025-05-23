<?php
require_once 'conn.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = intval($_POST['cart_id']);
    
    // Check if cart item exists
    $cart_item = executeQuery("SELECT * FROM cart_items WHERE id = $cart_id")->fetch_assoc();
    
    if (!$cart_item) {
        echo json_encode(['success' => false, 'message' => 'Cart item not found']);
        exit;
    }
    
    // Remove item from cart
    $sql = "DELETE FROM cart_items WHERE id = $cart_id";
    if (executeNonQuery($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to remove item from cart']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
} 