<?php
session_start();
require_once 'conn.php';

// If user is already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
    
    $email = escapeString($_POST['email']);
    $password = $_POST['password'];
    $login_type = isset($_POST['login_type']) ? $_POST['login_type'] : 'customer';
    
    // Initialize response
    $response = ['status' => '', 'message' => ''];
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = ['status' => 'error', 'message' => 'Invalid email format!'];
    } else {
        if ($login_type === 'admin') {
            // Check admin table specifically
            $admin_sql = "SELECT * FROM admin WHERE email = '$email'";
            $admin_result = executeQuery($admin_sql);
            
            if ($admin_result && $admin_result->num_rows > 0) {
                $admin = $admin_result->fetch_assoc();
                
                // For testing purposes, allow direct password comparison
                if ($password === 'admin123') {
                    // Set session variables for admin
                    $_SESSION['user_id'] = $admin['id'];
                    $_SESSION['user_email'] = $admin['email'];
                    $_SESSION['user_name'] = $admin['first_name'] . ' ' . $admin['last_name'];
                    $_SESSION['user_type'] = 'admin';
                    $_SESSION['admin_role'] = $admin['role'];
                    
                    $response = [
                        'status' => 'success',
                        'message' => 'Admin login successful!',
                        'redirect' => 'admin-dashboard.php'
                    ];
                } else {
                    $response = ['status' => 'error', 'message' => 'Invalid admin password!'];
                }
            } else {
                $response = ['status' => 'error', 'message' => 'Admin email not found in admin table!'];
            }
        } else {
            // Check users table for customer login only
            $user_sql = "SELECT * FROM users WHERE email = '$email' AND type = 'customer'";
            $user_result = executeQuery($user_sql);
            
            if ($user_result->num_rows > 0) {
                $user = $user_result->fetch_assoc();
                
                // Verify user password
                if (password_verify($password, $user['password'])) {
                    // Set session variables for user
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                    $_SESSION['user_type'] = 'customer';
                    
                    $response = [
                        'status' => 'success',
                        'message' => 'Login successful!',
                        'redirect' => 'home.php'
                    ];
                } else {
                    $response = ['status' => 'error', 'message' => 'Invalid password!'];
                }
            } else {
                $response = ['status' => 'error', 'message' => 'Customer email not found!'];
            }
        }
    }
    
    echo json_encode($response);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kushy Gadget Hub</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #D4AF37;
            --secondary-color: #222222;
            --accent-color: #FF9BB3;
            --text-light: #FFFFFF;
            --text-dark: #333333;
            --bg-dark: #1A1A1A;
            --bg-light: #f8f9fa;
            --bg-gold-gradient: linear-gradient(135deg, #D4AF37 0%, #F5E8A9 50%, #D4AF37 100%);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: var(--bg-dark);
            border-bottom: 3px solid var(--primary-color);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            letter-spacing: 1px;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 0;
            background: url('/api/placeholder/1920/1080') center/cover no-repeat;
            position: relative;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .login-card {
            max-width: 480px;
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            background-color: white;
            position: relative;
            z-index: 2;
            border: none;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .login-header {
            background: var(--bg-gold-gradient);
            color: var(--bg-dark);
            padding: 25px 20px;
            text-align: center;
            position: relative;
        }

        .login-header h3 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 1.75rem;
        }

        .login-header p {
            opacity: 0.8;
            font-size: 1rem;
        }

        .admin-login-info {
            background-color: rgba(212, 175, 55, 0.1);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .admin-login-info i {
            color: var(--primary-color);
            margin-right: 5px;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 12px 20px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(212, 175, 55, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            background-color: #c09c2c;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(192, 156, 44, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(192, 156, 44, 0.4);
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0) translate(-50%, -50%);
            transform-origin: left top;
            opacity: 0;
        }

        .btn-primary:active::after {
            animation: ripple 0.6s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0) translate(-50%, -50%);
                opacity: 1;
            }

            100% {
                transform: scale(20) translate(-50%, -50%);
                opacity: 0;
            }
        }

        .btn-link {
            color: var(--primary-color);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-link:hover {
            color: #c09c2c;
            text-decoration: underline !important;
            transform: translateY(-1px);
        }

        .footer {
            background: var(--bg-dark);
            color: var(--text-light);
            padding: 25px 0;
            margin-top: auto;
            border-top: 3px solid var(--primary-color);
        }

        .footer a {
            color: var(--text-light);
            transition: color 0.3s ease;
            text-decoration: none;
        }

        .footer a:hover {
            color: var(--primary-color);
        }

        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 25px;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 0;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover:not(.active) {
            color: #333;
            background-color: rgba(212, 175, 55, 0.05);
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            font-weight: 600;
            background: transparent;
        }

        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary-color);
            animation: slideIn 0.3s ease-out forwards;
        }

        @keyframes slideIn {
            from {
                width: 0;
                left: 50%;
            }

            to {
                width: 100%;
                left: 0;
            }
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            font-size: 0.9rem;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #6c757d;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .divider span {
            padding: 0 15px;
            font-size: 0.9rem;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .social-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            transition: all 0.3s ease;
        }

        .social-btn.fb {
            background-color: #3b5998;
        }

        .social-btn.google {
            background-color: #dd4b39;
        }

        .social-btn.apple {
            background-color: #000;
        }

        .social-btn:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .social-btn:active {
            transform: translateY(0) scale(0.95);
        }

        .alert {
            display: none;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        #loader {
            display: none;
            text-align: center;
            margin: 20px 0;
        }

        .input-group-text {
            transition: all 0.3s ease;
        }

        .form-control:focus+.input-group-text,
        .input-group:focus-within .input-group-text {
            border-color: var(--primary-color);
            background-color: rgba(212, 175, 55, 0.1);
        }

        .tab-pane {
            animation: fadeTab 0.4s ease-out forwards;
        }

        @keyframes fadeTab {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-mobile-alt me-2"></i> KGH HUB
            </a>
        </div>
    </nav>

    <!-- Login Container -->
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="login-card">
                        <div class="login-header">
                            <h3>Welcome Back!</h3>
                            <p>Sign in to your account</p>
                        </div>
                        <div class="login-body">
                            <!-- Login Type Tabs -->
                            <ul class="nav nav-tabs mb-4" id="loginTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="customer-tab" data-bs-toggle="tab" data-bs-target="#customer-login" type="button" role="tab" aria-controls="customer-login" aria-selected="true">
                                        <i class="fas fa-user me-2"></i>Customer Login
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin-login" type="button" role="tab" aria-controls="admin-login" aria-selected="false">
                                        <i class="fas fa-user-shield me-2"></i>Admin Login
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content" id="loginTabsContent">
                                <!-- Customer Login Tab -->
                                <div class="tab-pane fade show active" id="customer-login" role="tabpanel" aria-labelledby="customer-tab">
                                    <form id="customerLoginForm" method="POST">
                                        <input type="hidden" name="login_type" value="customer">
                                        <div class="mb-3">
                                            <label for="customer_email" class="form-label">Email address</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" class="form-control" id="customer_email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="customer_password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input type="password" class="form-control" id="customer_password" name="password" required>
                                                <span class="input-group-text toggle-password" style="cursor: pointer;">
                                                    <i class="fas fa-eye-slash"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Customer Login</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Admin Login Tab -->
                                <div class="tab-pane fade" id="admin-login" role="tabpanel" aria-labelledby="admin-tab">
                                    <div class="alert alert-info mb-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Admin Credentials:</strong><br>
                                        Email: admin@kgh.com<br>
                                        Password: admin123
                                    </div>
                                    <form id="adminLoginForm" method="POST">
                                        <input type="hidden" name="login_type" value="admin">
                                        <div class="mb-3">
                                            <label for="admin_email" class="form-label">Admin Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" class="form-control" id="admin_email" name="email" placeholder="admin@kgh.com" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="admin_password" class="form-label">Admin Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input type="password" class="form-control" id="admin_password" name="password" required>
                                                <span class="input-group-text toggle-password" style="cursor: pointer;">
                                                    <i class="fas fa-eye-slash"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Admin Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Alert Messages -->
                            <div id="alertMessage" class="alert mt-3"></div>
                            
                            <!-- Loader -->
                            <div id="loader">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Signing in...</p>
                            </div>

                            <div class="text-center mt-3">
                                <p class="mb-0">Don't have an account? <a href="sign up.php" class="text-decoration-none">Register here</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2024 Kushy Gadget Hub. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="privacy.php">Privacy Policy</a> | <a href="terms.php">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customerLoginForm = document.getElementById('customerLoginForm');
            const adminLoginForm = document.getElementById('adminLoginForm');
            const alertMessage = document.getElementById('alertMessage');
            const loader = document.getElementById('loader');
            const togglePasswordButtons = document.querySelectorAll('.toggle-password');
            
            // Toggle password visibility for all password fields
            togglePasswordButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const passwordInput = this.parentElement.querySelector('input[type="password"], input[type="text"]');
                    const icon = this.querySelector('i');
                    
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            });
            
            // Handle form submission for both forms
            function handleLogin(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Show loader
                    loader.style.display = 'block';
                    
                    // Get form data
                    const formData = new FormData(this);
                    
                    // Send login request
                    fetch(window.location.href, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Hide loader
                        loader.style.display = 'none';
                        
                        // Show message
                        alertMessage.textContent = data.message;
                        alertMessage.className = `alert alert-${data.status === 'success' ? 'success' : 'danger'}`;
                        alertMessage.style.display = 'block';
                        
                        if (data.status === 'success') {
                            // Redirect after successful login
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 1000);
                        }
                    })
                    .catch(error => {
                        // Hide loader
                        loader.style.display = 'none';
                        
                        // Show error message
                        alertMessage.textContent = 'An error occurred. Please try again.';
                        alertMessage.className = 'alert alert-danger';
                        alertMessage.style.display = 'block';
                    });
                });
            }
            
            // Initialize both forms
            handleLogin(customerLoginForm);
            handleLogin(adminLoginForm);
        });
    </script>
</body>

</html>