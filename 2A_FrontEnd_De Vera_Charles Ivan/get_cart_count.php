<?php
session_start();
require_once 'conn.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['count' => 0]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Get total quantity of items in cart
$sql = "SELECT SUM(quantity) as total FROM cart_items WHERE user_id = $user_id";
$result = executeQuery($sql);
$row = $result->fetch_assoc();

echo json_encode(['count' => $row['total'] ?? 0]); 