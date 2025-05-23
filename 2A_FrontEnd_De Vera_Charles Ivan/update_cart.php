<?php
require_once 'conn.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = intval($_POST['cart_id']);
    $quantity = intval($_POST['quantity']);
    
    // Validate quantity
    if ($quantity < 1) {
        echo json_encode(['success' => false, 'message' => 'Quantity must be at least 1']);
        exit;
    }
    
    // Check if cart item exists and get product stock
    $cart_item = executeQuery("SELECT c.*, p.stock 
                             FROM cart_items c 
                             JOIN products p ON c.product_id = p.id 
                             WHERE c.id = $cart_id")->fetch_assoc();
    
    if (!$cart_item) {
        echo json_encode(['success' => false, 'message' => 'Cart item not found']);
        exit;
    }
    
    // Check if requested quantity is available in stock
    if ($quantity > $cart_item['stock']) {
        echo json_encode(['success' => false, 'message' => 'Requested quantity exceeds available stock']);
        exit;
    }
    
    // Update cart quantity
    $sql = "UPDATE cart_items SET quantity = $quantity WHERE id = $cart_id";
    if (executeNonQuery($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
} 