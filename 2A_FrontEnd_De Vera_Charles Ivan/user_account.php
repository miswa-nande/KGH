<?php
require_once 'conn.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

// Get user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = executeQuery($sql);
$user = $result->fetch_assoc();

// Initialize message variables
$success_message = '';
$error_message = '';

// Handle form submission for profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_profile'])) {
        $first_name = escapeString($_POST['first_name']);
        $last_name = escapeString($_POST['last_name']);
        $email = escapeString($_POST['email']);
        $phone = escapeString($_POST['phone']);
        $birthdate = escapeString($_POST['birthdate']);

        // Update user data
        $update_sql = "UPDATE users SET 
                      first_name = '$first_name',
                      last_name = '$last_name',
                      email = '$email',
                      phone = '$phone',
                      birthdate = '$birthdate'
                      WHERE id = '$user_id'";

        if (executeNonQuery($update_sql)) {
            $success_message = "Profile updated successfully! Your changes have been saved.";
            // Refresh user data
            $result = executeQuery($sql);
            $user = $result->fetch_assoc();
        } else {
            $error_message = "Error updating profile. Please try again.";
        }
    }

    // Handle password change
    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // First verify current password
        if (!empty($current_password)) {
            // Get the stored hashed password from database
            $check_sql = "SELECT password FROM users WHERE id = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("i", $user_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $stored_user = $check_result->fetch_assoc();
            $check_stmt->close();

            // Verify current password against stored hash
            if (password_verify($current_password, $stored_user['password'])) {
                // Current password is correct, now check new password fields
                if (empty($new_password)) {
                    $error_message = "Please enter a new password!";
                }
                else if (empty($confirm_password)) {
                    $error_message = "Please confirm your new password!";
                }
                else if ($new_password === $confirm_password) {
                    // Hash the new password
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    
                    // Update password in database using prepared statement
                    $password_sql = "UPDATE users SET password = ? WHERE id = ?";
                    if (executePreparedStatement($password_sql, "si", [$hashed_password, $user_id])) {
                        // Verify the password was actually changed
                        $verify_sql = "SELECT password FROM users WHERE id = ?";
                        $verify_stmt = $conn->prepare($verify_sql);
                        $verify_stmt->bind_param("i", $user_id);
                        $verify_stmt->execute();
                        $verify_result = $verify_stmt->get_result();
                        $updated_user = $verify_result->fetch_assoc();
                        $verify_stmt->close();

                        if (password_verify($new_password, $updated_user['password'])) {
                            $success_message = "Password changed successfully! Please use your new password next time you log in.";
                            // Refresh user data
                            $result = executeQuery($sql);
                            $user = $result->fetch_assoc();
                            // Clear the password fields
                            $_POST['current_password'] = '';
                            $_POST['new_password'] = '';
                            $_POST['confirm_password'] = '';
                        } else {
                            $error_message = "Error: Password was not updated correctly. Please try again.";
                        }
                    } else {
                        $error_message = "Error changing password. Please try again.";
                    }
                } else {
                    $error_message = "New passwords do not match!";
                }
            } else {
                $error_message = "Current password is incorrect!";
                // Clear new password fields if current password is wrong
                $_POST['new_password'] = '';
                $_POST['confirm_password'] = '';
            }
        } else {
            $error_message = "Please enter your current password!";
        }
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Kushy Gadget Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="design.css">
    <style>
        /* Base Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: bold;
            color: #333;
        }

        .nav-link {
            color: #555;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #0d6efd;
        }

        .badge-cart {
            background-color: #dc3545;
            color: white;
            position: absolute;
            top: -5px;
            right: -8px;
        }

        /* Main Content Container */
        .main-content {
            flex: 1;
            padding: 1.5rem 0;
        }

        /* Account Content */
        .account-content {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        /* Tab Content */
        .tab-content {
            padding: 0.5rem 0;
        }

        .tab-pane {
            padding: 0.5rem 0;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* Row Spacing */
        .row {
            margin-bottom: 1rem;
        }

        .row:last-child {
            margin-bottom: 0;
        }

        /* Footer Styles */
        .footer {
            background: var(--bg-dark);
            color: var(--text-light);
            padding: 30px 0;
            border-top: 3px solid var(--primary-color);
            margin-top: 1.5rem;
        }

        /* Section Headers */
        .section-header {
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #eee;
        }

        /* Profile Header */
        .profile-header {
            margin-bottom: 1.5rem;
        }

        /* Form Spacing */
        .form-group {
            margin-bottom: 1.25rem;
        }

        /* Table Spacing */
        .table {
            margin-bottom: 0;
        }

        .table th {
            border-top: none;
            background: #f8f9fa;
        }

        /* Button Spacing */
        .btn {
            margin-right: 0.5rem;
        }

        .btn:last-child {
            margin-right: 0;
        }

        /* Alert Spacing */
        .alert {
            margin-bottom: 1.25rem;
        }

        /* Account Sidebar */
        .account-sidebar {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .list-group-item {
            border: none;
            padding: 0.75rem 1.25rem;
        }

        .list-group-item.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .list-group-item:hover:not(.active) {
            background-color: #f8f9fa;
        }

        /* Order History */
        .order-history .card {
            margin-bottom: 0.75rem;
        }

        .order-label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }

        /* Payment Methods */
        .payment-method-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 0.75rem;
        }

        .payment-method-card .card-body {
            padding: 1.25rem;
        }

        .payment-method-card .card-title {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .payment-method-card .card-title i {
            margin-right: 0.75rem;
            font-size: 1.5rem;
        }

        /* Payment Section Specific */
        #payment .profile-header {
            margin-bottom: 0.5rem !important;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        #payment .payment-methods-grid {
            margin-top: 0 !important;
        }

        #payment {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        /* Responsive Adjustments */
        @media (max-width: 767.98px) {
            .account-content {
                padding: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .section-header {
                margin-bottom: 1.25rem;
            }

            .account-sidebar {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <i class="fas fa-mobile-alt me-2"></i>KGH HUB
            </a>
            <button class="navbar-toggler text-gold" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="phones.php">Smartphones</a></li>
                            <li><a class="dropdown-item" href="laptops.php">Laptops</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="cart.php" class="nav-link me-3 position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge rounded-pill badge-cart">3</span>
                    </a>
                    <a href="user_account.php" class="nav-link me-3 active">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="login_page.php" class="btn btn-sm btn-primary">
                        Login / Register
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Account Page Content -->
    <div class="container main-content" style="margin-bottom: 0; padding-bottom: 0;">
        <div class="row">
            <div class="col-12 mb-4">
                <h2 class="section-header">My Account</h2>
            </div>

            <!-- Account Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="account-sidebar">
                    <div class="text-center p-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-secondary"></i>
                        </div>
                        <h5 class="mt-3 mb-1"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
                        <p class="text-muted mb-0"><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#dashboard" class="list-group-item active" data-bs-toggle="tab">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="#orders" class="list-group-item" data-bs-toggle="tab">
                            <i class="fas fa-shopping-bag me-2"></i> Orders
                        </a>
                        <a href="#wishlist" class="list-group-item" data-bs-toggle="tab">
                            <i class="fas fa-heart me-2"></i> Wishlist
                        </a>
                        <a href="#profile" class="list-group-item" data-bs-toggle="tab">
                            <i class="fas fa-user-edit me-2"></i> Profile
                        </a>
                        <a href="#address" class="list-group-item" data-bs-toggle="tab">
                            <i class="fas fa-map-marker-alt me-2"></i> Addresses
                        </a>
                        <a href="#payment" class="list-group-item" data-bs-toggle="tab">
                            <i class="fas fa-credit-card me-2"></i> Payment Methods
                        </a>
                        <a href="?logout=1" class="list-group-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Account Content -->
            <div class="col-lg-9">
                <div class="account-content tab-content">
                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active" id="dashboard">
                        <div class="profile-header">
                            <h4>Dashboard</h4>
                            <p class="text-muted">Welcome back, John!</p>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="card text-center h-100">
                                    <div class="card-body">
                                        <i class="fas fa-shopping-bag fa-3x text-primary mb-3"></i>
                                        <h5 class="card-title">3</h5>
                                        <p class="card-text">Total Orders</p>
                                        <a href="#orders" class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="tab">View Orders</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-center h-100">
                                    <div class="card-body">
                                        <i class="fas fa-heart fa-3x text-danger mb-3"></i>
                                        <h5 class="card-title">5</h5>
                                        <p class="card-text">Wishlist Items</p>
                                        <a href="#wishlist" class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="tab">View Wishlist</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-center h-100">
                                    <div class="card-body">
                                        <i class="fas fa-tag fa-3x text-success mb-3"></i>
                                        <h5 class="card-title">2</h5>
                                        <p class="card-text">Active Coupons</p>
                                        <button class="btn btn-sm btn-outline-primary">View Coupons</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Recent Orders</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>KGH10023</td>
                                                <td>Apr 1, 2025</td>
                                                <td><span class="badge bg-success">Delivered</span></td>
                                                <td>$1,299.99</td>
                                                <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                                            </tr>
                                            <tr>
                                                <td>KGH10022</td>
                                                <td>Mar 15, 2025</td>
                                                <td><span class="badge bg-warning text-dark">Shipped</span></td>
                                                <td>$499.99</td>
                                                <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                                            </tr>
                                            <tr>
                                                <td>KGH10021</td>
                                                <td>Feb 28, 2025</td>
                                                <td><span class="badge bg-success">Delivered</span></td>
                                                <td>$89.99</td>
                                                <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Tab -->
                    <div class="tab-pane fade" id="orders">
                        <div class="profile-header">
                            <h4>My Orders</h4>
                            <p class="text-muted">View and track your orders</p>
                        </div>

                        <div class="order-history">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <span class="order-label">Order #:</span>
                                            <p>KGH10023</p>
                                            <span class="order-label">Date:</span>
                                            <p>Apr 1, 2025</p>
                                        </div>
                                        <div class="col-md-5">
                                            <span class="order-label">Items:</span>
                                            <p>MacBook Pro 16" M3 Pro</p>
                                            <span class="order-label">Total:</span>
                                            <p class="text-primary fw-bold">$1,299.99</p>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <span class="badge bg-success mb-3">Delivered</span>
                                            <div>
                                                <a href="#" class="btn btn-sm btn-primary me-2">Track Order</a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <span class="order-label">Order #:</span>
                                            <p>KGH10022</p>
                                            <span class="order-label">Date:</span>
                                            <p>Mar 15, 2025</p>
                                        </div>
                                        <div class="col-md-5">
                                            <span class="order-label">Items:</span>
                                            <p>iPhone 16 Pro, 256GB</p>
                                            <span class="order-label">Total:</span>
                                            <p class="text-primary fw-bold">$499.99</p>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <span class="badge bg-warning text-dark mb-3">Shipped</span>
                                            <div>
                                                <a href="#" class="btn btn-sm btn-primary me-2">Track Order</a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <span class="order-label">Order #:</span>
                                            <p>KGH10021</p>
                                            <span class="order-label">Date:</span>
                                            <p>Feb 28, 2025</p>
                                        </div>
                                        <div class="col-md-5">
                                            <span class="order-label">Items:</span>
                                            <p>AirPods Pro 2</p>
                                            <span class="order-label">Total:</span>
                                            <p class="text-primary fw-bold">$89.99</p>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <span class="badge bg-success mb-3">Delivered</span>
                                            <div>
                                                <a href="#" class="btn btn-sm btn-primary me-2">Track Order</a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist Tab -->
                    <div class="tab-pane fade" id="wishlist">
                        <div class="profile-header">
                            <h4>My Wishlist</h4>
                            <p class="text-muted">Items you've saved for later</p>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card h-100">
                                    <img src="/api/placeholder/400/320" alt="Galaxy S24 Ultra" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title">Samsung Galaxy S24 Ultra</h5>
                                        <p class="card-text price">$1,199.99</p>
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-primary btn-sm">Add to Cart</button>
                                            <button class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card h-100">
                                    <img src="/api/placeholder/400/320" alt="Dell XPS 15" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title">Dell XPS 15 (2025)</h5>
                                        <p class="card-text price">$1,899.99</p>
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-primary btn-sm">Add to Cart</button>
                                            <button class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card h-100">
                                    <img src="/api/placeholder/400/320" alt="iPad Pro" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title">iPad Pro 12.9" M3</h5>
                                        <p class="card-text price">$1,099.99</p>
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-primary btn-sm">Add to Cart</button>
                                            <button class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card h-100">
                                    <img src="/api/placeholder/400/320" alt="Sony WH-1000XM5" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title">Sony WH-1000XM5</h5>
                                        <p class="card-text price">$349.99</p>
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-primary btn-sm">Add to Cart</button>
                                            <button class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card h-100">
                                    <img src="/api/placeholder/400/320" alt="Google Pixel 8 Pro" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title">Google Pixel 8 Pro</h5>
                                        <p class="card-text price">$899.99</p>
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-primary btn-sm">Add to Cart</button>
                                            <button class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Tab -->
                    <div class="tab-pane fade" id="profile">
                        <div class="profile-header">
                            <h4>Edit Profile</h4>
                            <p class="text-muted">Update your personal information</p>
                        </div>

                        <?php if ($success_message): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo $success_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($error_message): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo $error_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="" id="profileForm">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" 
                                           value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" 
                                           value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" 
                                       value="<?php echo htmlspecialchars($user['birthdate']); ?>" required>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
                                <button type="submit" name="update_profile" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <h5>Change Password</h5>
                        <form method="POST" action="" id="passwordForm">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" 
                                       name="current_password" required>
                                <div class="invalid-feedback" id="currentPasswordFeedback">
                                    Current password is incorrect
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" 
                                       name="new_password" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" 
                                       name="confirm_password" disabled>
                                <div class="invalid-feedback" id="confirmPasswordFeedback">
                                    Passwords do not match
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" name="change_password" class="btn btn-success" id="changeBtn" disabled>
                                    Change Password
                                </button>
                            </div>
                        </form>

                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const currentPassword = document.getElementById('current_password');
                            const newPassword = document.getElementById('new_password');
                            const confirmPassword = document.getElementById('confirm_password');
                            const changeBtn = document.getElementById('changeBtn');
                            const currentPasswordFeedback = document.getElementById('currentPasswordFeedback');
                            const confirmPasswordFeedback = document.getElementById('confirmPasswordFeedback');
                            
                            // Initially disable new password fields and change button
                            newPassword.disabled = true;
                            confirmPassword.disabled = true;
                            changeBtn.disabled = true;
                            
                            // Verify current password when user leaves the field
                            currentPassword.addEventListener('blur', function() {
                                if (this.value.trim() !== '') {
                                    // Send AJAX request to verify current password
                                    fetch('verify_password.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded',
                                        },
                                        body: 'current_password=' + encodeURIComponent(this.value)
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // Enable new password fields and change button
                                            newPassword.disabled = false;
                                            confirmPassword.disabled = false;
                                            changeBtn.disabled = false;
                                            currentPassword.classList.remove('is-invalid');
                                            currentPassword.classList.add('is-valid');
                                            currentPasswordFeedback.style.display = 'none';
                                            
                                            // Focus on new password field
                                            newPassword.focus();
                                        } else {
                                            // Show error message
                                            currentPassword.classList.remove('is-valid');
                                            currentPassword.classList.add('is-invalid');
                                            currentPasswordFeedback.style.display = 'block';
                                            newPassword.disabled = true;
                                            confirmPassword.disabled = true;
                                            changeBtn.disabled = true;
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('An error occurred. Please try again.');
                                    });
                                }
                            });
                            
                            // Check if passwords match when user types in confirm password
                            confirmPassword.addEventListener('input', function() {
                                if (this.value !== newPassword.value) {
                                    this.classList.remove('is-valid');
                                    this.classList.add('is-invalid');
                                    confirmPasswordFeedback.style.display = 'block';
                                    changeBtn.disabled = true;
                                } else {
                                    this.classList.remove('is-invalid');
                                    this.classList.add('is-valid');
                                    confirmPasswordFeedback.style.display = 'none';
                                    changeBtn.disabled = false;
                                }
                            });
                            
                            // Handle password change
                            changeBtn.addEventListener('click', function(e) {
                                if (newPassword.value !== confirmPassword.value) {
                                    e.preventDefault();
                                    confirmPassword.classList.add('is-invalid');
                                    confirmPasswordFeedback.style.display = 'block';
                                }
                            });
                        });
                        </script>
                    </div>

                    <!-- Address Tab -->
                    <div class="tab-pane fade" id="address">
                        <div class="profile-header">
                            <h4>My Addresses</h4>
                            <p class="text-muted">Manage your shipping addresses</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="card-title mb-0">Home</h5>
                                            <span class="badge bg-primary">Default</span>
                                        </div>
                                        <address class="mb-3">
                                            John Doe<br>
                                            123 Tech Avenue<br>
                                            San Francisco, CA 94107<br>
                                            United States<br>
                                            <abbr title="Phone">P:</abbr> (555) 123-4567
                                        </address>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-sm btn-outline-primary me-2">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Office</h5>
                                        <address class="mb-3">
                                            John Doe<br>
                                            456 Business Park<br>
                                            San Francisco, CA 94103<br>
                                            United States<br>
                                            <abbr title="Phone">P:</abbr> (555) 987-6543
                                        </address>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-sm btn-outline-primary me-2">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <button class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Add New Address
                            </button>
                        </div>
                    </div>

                    <!-- Payment Methods Tab -->
                    <div class="tab-pane fade" id="payment">
                        <div class="profile-header payment-header">
                            <h4>Payment Methods</h4>
                            <p class="text-muted">Manage your payment options</p>
                        </div>

                        <div class="payment-methods-grid">
                            <div class="payment-method-card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <i class="fab fa-cc-visa text-primary"></i>
                                        <h5 class="mb-0">Visa ending in 4242</h5>
                                        <span class="badge bg-primary ms-auto">Default</span>
                                    </div>
                                    <p class="mb-1"><span class="order-label">Card Holder:</span> John Doe</p>
                                    <p class="mb-1"><span class="order-label">Expires:</span> 05/2027</p>
                                    <p class="mb-3"><span class="order-label">Billing Address:</span> Home</p>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                            </div>

                            <div class="payment-method-card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <i class="fab fa-cc-mastercard text-warning"></i>
                                        <h5 class="mb-0">Mastercard ending in 8889</h5>
                                    </div>
                                    <p class="mb-1"><span class="order-label">Card Holder:</span> John Doe</p>
                                    <p class="mb-1"><span class="order-label">Expires:</span> 11/2026</p>
                                    <p class="mb-3"><span class="order-label">Billing Address:</span> Office</p>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Add New Payment Method
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer" style="margin-top: 0; padding-top: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5>About Kushy Gadget Hub</h5>
                    <p>Your trusted destination for premium tech products and accessories. Quality, innovation, and exceptional service since 2018.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="home.php">Home</a></li>
                        <li class="mb-2"><a href="phones.php">Phones</a></li>
                        <li class="mb-2"><a href="laptops.php">Laptops</a></li>
                        <li class="mb-2"><a href="about.php">About Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5>Categories</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="phones.php">Smartphones</a></li>
                        <li class="mb-2"><a href="laptops.php">Laptops</a></li>
                        <li class="mb-2"><a href="#">Accessories</a></li>
                        <li class="mb-2"><a href="#">Smart Home</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5>Newsletter</h5>
                    <p>Subscribe to receive updates on new products and special promotions.</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Your Email">
                        <button class="btn btn-primary" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2025 Kushy Gadget Hub. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <a href="#" class="text-white text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-white text-decoration-none me-3">Terms of Service</a>
                    <a href="#" class="text-white text-decoration-none">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap & JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function () {
            var tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltips.map(function (tooltip) {
                return new bootstrap.Tooltip(tooltip);
            });

            // Add active class to sidebar item based on hash
            function setActiveTab() {
                var hash = window.location.hash || '#dashboard';
                document.querySelector('.list-group-item[href="' + hash + '"]').click();
            }

            // Run on page load
            setActiveTab();

            // Run when hash changes
            window.addEventListener('hashchange', setActiveTab);

            // Cart badge animation
            var cartBadge = document.querySelector('.badge-cart');
            cartBadge.addEventListener('click', function () {
                this.classList.add('pulse-animation');
                setTimeout(() => {
                    this.classList.remove('pulse-animation');
                }, 1000);
            });
        });

        // Password validation
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');
        
        function validatePassword() {
            if (newPassword.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity("Passwords don't match");
            } else {
                confirmPassword.setCustomValidity('');
            }
        }

        newPassword.addEventListener('change', validatePassword);
        confirmPassword.addEventListener('keyup', validatePassword);

        // Add form submission confirmation
        const profileForm = document.getElementById('profileForm');
        if (profileForm) {
            profileForm.addEventListener('submit', function(e) {
                const passwordFields = document.querySelectorAll('input[type="password"]');
                let hasPasswordInput = false;
                
                passwordFields.forEach(field => {
                    if (field.value.trim() !== '') {
                        hasPasswordInput = true;
                    }
                });

                if (hasPasswordInput) {
                    if (!confirm('Are you sure you want to update your profile and change your password?')) {
                        e.preventDefault();
                    }
                } else {
                    if (!confirm('Are you sure you want to update your profile?')) {
                        e.preventDefault();
                    }
                }
            });
        }

        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Add JavaScript to disable new password fields until current password is verified
        document.addEventListener('DOMContentLoaded', function() {
            const currentPassword = document.getElementById('current_password');
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('confirm_password');
            
            // Initially disable new password fields
            newPassword.disabled = true;
            confirmPassword.disabled = true;
            
            // Add event listener to current password field
            currentPassword.addEventListener('input', function() {
                // Enable new password fields only if current password is not empty
                if (this.value.trim() !== '') {
                    newPassword.disabled = false;
                    confirmPassword.disabled = false;
                } else {
                    newPassword.disabled = true;
                    confirmPassword.disabled = true;
                    newPassword.value = '';
                    confirmPassword.value = '';
                }
            });
        });
    </script>
</body>

</html>