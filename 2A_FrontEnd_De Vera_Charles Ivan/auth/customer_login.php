<?php
require_once('../conn.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $remember = isset($_POST['customerRemember']) ? true : false;

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format';
        header('Location: ../login_page.php');
        exit();
    }

    try {
        // Prepare SQL statement
        $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['customer_id'] = $user['id'];
                $_SESSION['customer_email'] = $user['email'];
                $_SESSION['customer_name'] = $user['name'];

                // Handle remember me functionality
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true);
                    
                    // Store token in database
                    $stmt = $conn->prepare("UPDATE customers SET remember_token = ? WHERE id = ?");
                    $stmt->bind_param("si", $token, $user['id']);
                    $stmt->execute();
                }

                header('Location: ../index.php');
                exit();
            } else {
                $_SESSION['error'] = 'Invalid password';
            }
        } else {
            $_SESSION['error'] = 'User not found';
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'An error occurred. Please try again later.';
    }

    header('Location: ../login_page.php');
    exit();
}