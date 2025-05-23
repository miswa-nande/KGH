<?php
session_start();
require_once 'conn.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to add items to cart']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $user_id = $_SESSION['user_id'];
    
    // Validate quantity
    if ($quantity < 1) {
        echo json_encode(['success' => false, 'message' => 'Quantity must be at least 1']);
        exit;
    }
    
    // Check if product exists and has enough stock
    $product = executeQuery("SELECT * FROM products WHERE id = $product_id")->fetch_assoc();
    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }
    
    if ($quantity > $product['stock']) {
        echo json_encode(['success' => false, 'message' => 'Requested quantity exceeds available stock']);
        exit;
    }
    
    // Check if product already exists in cart
    $check_sql = "SELECT * FROM cart_items WHERE user_id = $user_id AND product_id = $product_id";
    $check_result = executeQuery($check_sql);
    
    if ($check_result->num_rows > 0) {
        // Update quantity if product exists
        $cart_item = $check_result->fetch_assoc();
        $new_quantity = $cart_item['quantity'] + $quantity;
        
        if ($new_quantity > $product['stock']) {
            echo json_encode(['success' => false, 'message' => 'Total quantity exceeds available stock']);
            exit;
        }
        
        $update_sql = "UPDATE cart_items SET quantity = $new_quantity WHERE id = " . $cart_item['id'];
        if (executeNonQuery($update_sql)) {
            echo json_encode(['success' => true, 'message' => 'Cart updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
        }
    } else {
        // Add new item if product doesn't exist
        $sql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
        if (executeNonQuery($sql)) {
            echo json_encode(['success' => true, 'message' => 'Item added to cart successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add item to cart']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
} 