<?php
require_once('../conn.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $remember = isset($_POST['adminRemember']) ? true : false;

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format';
        header('Location: ../login_page.php');
        exit();
    }

    try {
        // Prepare SQL statement
        $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $admin['password'])) {
                // Set session variables
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['is_admin'] = true;

                // Handle remember me functionality
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    setcookie('admin_remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true);
                    
                    // Store token in database
                    $stmt = $conn->prepare("UPDATE admins SET remember_token = ? WHERE id = ?");
                    $stmt->bind_param("si", $token, $admin['id']);
                    $stmt->execute();
                }

                header('Location: ../admin-dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Invalid password';
            }
        } else {
            $_SESSION['error'] = 'Admin not found';
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'An error occurred. Please try again later.';
    }

    header('Location: ../login_page.php');
    exit();
}