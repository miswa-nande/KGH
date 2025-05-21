<?php require_once 'conn.php'; ?>
<?php
// Handle Add User
$add_user_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $first_name = escapeString($_POST['first_name']);
    $last_name = escapeString($_POST['last_name']);
    $email = escapeString($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $type = escapeString($_POST['type']);
    $sql = "INSERT INTO users (first_name, last_name, email, password, type) VALUES ('$first_name', '$last_name', '$email', '$password', '$type')";
    if (executeNonQuery($sql)) {
        $add_user_message = '<div class="alert alert-success">User added successfully!</div>';
    } else {
        $add_user_message = '<div class="alert alert-danger">Failed to add user.</div>';
    }
}
// Handle Delete User
if (isset($_GET['delete_user'])) {
    $user_id = intval($_GET['delete_user']);
    $sql = "DELETE FROM users WHERE id = $user_id";
    executeNonQuery($sql);
    header('Location: admin-dashboard.php');
    exit();
}
// Fetch all users
$users = executeQuery("SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kushy Gadget Hub</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.css">
    <link rel="stylesheet" href="css/admin-styles.css">
    <style>
        /* Custom admin styles */
        #sidebar {
            min-height: 100vh;
            background-color: #212529;
        }

        #sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 0.75rem 1.25rem;
            margin-bottom: 0.25rem;
            border-radius: 0.25rem;
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .icon-shape {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
        }

        .recent-activity-item {
            position: relative;
            padding-left: 45px;
        }

        .recent-activity-item::before {
            content: "";
            position: absolute;
            left: 22px;
            top: 0;
            bottom: 0;
            width: 1px;
            background-color: #e9ecef;
        }

        .recent-activity-item:last-child::before {
            display: none;
        }

        .activity-dot {
            position: absolute;
            left: 15px;
            top: 0;
            width: 15px;
            height: 15px;
            border-radius: 50%;
        }

        .admin-section { display: none; }
        .admin-section:not(.d-none) { display: block; }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">KGH Admin</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="admin-dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-products.php">
                                <i class="fas fa-box me-2"></i>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-orders.php">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-customers.php">
                                <i class="fas fa-users me-2"></i>
                                Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-reports.php">
                                <i class="fas fa-chart-bar me-2"></i>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-settings.php">
                                <i class="fas fa-cog me-2"></i>
                                Settings
                            </a>
                        </li>
                    </ul>

                    <hr class="text-white">

                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="fas fa-store me-2"></i>
                                View Store
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div id="dashboard-section" class="admin-section">
                    <!-- Dashboard content here (quick stats, charts, etc.) -->
                    <!-- Header with user info -->
                    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-3">
                                <a href="#" class="position-relative text-dark" id="notificationDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-bell fa-lg"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">New order #1283 received</a></li>
                                    <li><a class="dropdown-item" href="#">Product "Smartphone X21" low on stock</a></li>
                                    <li><a class="dropdown-item" href="#">3 customers left reviews</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-center" href="#">View all notifications</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                                    id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="img/admin-avatar.jpg" alt="Admin" width="32" height="32"
                                        class="rounded-circle me-2">
                                    <span>Admin User</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="login.php">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-4 mb-md-0">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body py-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-uppercase text-muted mb-2">Total Sales</h6>
                                            <h2 class="mb-0">$45,289</h2>
                                        </div>
                                        <div class="icon-shape rounded-circle bg-primary text-white">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0">
                                        <span class="text-success me-1"><i class="fas fa-arrow-up"></i> 13.2%</span>
                                        <span class="text-muted">Since last month</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4 mb-md-0">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body py-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-uppercase text-muted mb-2">Orders</h6>
                                            <h2 class="mb-0">458</h2>
                                        </div>
                                        <div class="icon-shape rounded-circle bg-success text-white">
                                            <i class="fas fa-shopping-bag"></i>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0">
                                        <span class="text-success me-1"><i class="fas fa-arrow-up"></i> 8.7%</span>
                                        <span class="text-muted">Since last month</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4 mb-md-0">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body py-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-uppercase text-muted mb-2">Customers</h6>
                                            <h2 class="mb-0">2,389</h2>
                                        </div>
                                        <div class="icon-shape rounded-circle bg-info text-white">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0">
                                        <span class="text-success me-1"><i class="fas fa-arrow-up"></i> 5.3%</span>
                                        <span class="text-muted">Since last month</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body py-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-uppercase text-muted mb-2">Avg. Order</h6>
                                            <h2 class="mb-0">$98.85</h2>
                                        </div>
                                        <div class="icon-shape rounded-circle bg-warning text-white">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0">
                                        <span class="text-danger me-1"><i class="fas fa-arrow-down"></i> 1.2%</span>
                                        <span class="text-muted">Since last month</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Chart and Top Products -->
                    <div class="row mb-4">
                        <div class="col-lg-8 mb-4 mb-lg-0">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Sales Overview</h5>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-secondary active">Day</button>
                                            <button type="button" class="btn btn-outline-secondary">Week</button>
                                            <button type="button" class="btn btn-outline-secondary">Month</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="salesChart" height="250"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0">Top Products</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <img src="img/products/smartphone1.jpg" alt="Product" width="40"
                                                            height="40" class="rounded">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Premium Smartphone X21</h6>
                                                        <small class="text-muted">Sold: 176 units</small>
                                                    </div>
                                                </div>
                                                <span class="badge bg-success">$899.99</span>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <img src="img/products/laptop2.jpg" alt="Product" width="40"
                                                            height="40" class="rounded">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">UltraBook Pro 15"</h6>
                                                        <small class="text-muted">Sold: 143 units</small>
                                                    </div>
                                                </div>
                                                <span class="badge bg-success">$1,299.99</span>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <img src="img/products/headphones3.jpg" alt="Product" width="40"
                                                            height="40" class="rounded">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">NoiseCancel Pro Headphones</h6>
                                                        <small class="text-muted">Sold: 112 units</small>
                                                    </div>
                                                </div>
                                                <span class="badge bg-success">$249.99</span>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <img src="img/products/tablet4.jpg" alt="Product" width="40"
                                                            height="40" class="rounded">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">SlimTab Pro 11"</h6>
                                                        <small class="text-muted">Sold: 89 units</small>
                                                    </div>
                                                </div>
                                                <span class="badge bg-success">$499.99</span>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0 border-bottom-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <img src="img/products/watch5.jpg" alt="Product" width="40"
                                                            height="40" class="rounded">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">SmartWatch Elite</h6>
                                                        <small class="text-muted">Sold: 78 units</small>
                                                    </div>
                                                </div>
                                                <span class="badge bg-success">$299.99</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders and Activity -->
                    <div class="row mb-4">
                        <div class="col-lg-8 mb-4 mb-lg-0">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Recent Orders</h5>
                                        <a href="admin-orders.php" class="btn btn-sm btn-outline-primary">View All</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#ORD-4851</td>
                                                    <td>Emma Watson</td>
                                                    <td>Apr 08, 2025</td>
                                                    <td>$1,299.99</td>
                                                    <td><span class="badge bg-success">Completed</span></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-light" type="button"
                                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                <li><a class="dropdown-item" href="#">View Details</a></li>
                                                                <li><a class="dropdown-item" href="#">Process Order</a></li>
                                                                <li><a class="dropdown-item text-danger" href="#">Cancel</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>#ORD-4850</td>
                                                    <td>Tom Hardy</td>
                                                    <td>Apr 08, 2025</td>
                                                    <td>$899.99</td>
                                                    <td><span class="badge bg-warning text-dark">Processing</span></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-light" type="button"
                                                                id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                                <li><a class="dropdown-item" href="#">View Details</a></li>
                                                                <li><a class="dropdown-item" href="#">Process Order</a></li>
                                                                <li><a class="dropdown-item text-danger" href="#">Cancel</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>#ORD-4849</td>
                                                    <td>Sarah Johnson</td>
                                                    <td>Apr 07, 2025</td>
                                                    <td>$249.99</td>
                                                    <td><span class="badge bg-info">Shipped</span></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-light" type="button"
                                                                id="dropdownMenuButton3" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                                <li><a class="dropdown-item" href="#">View Details</a></li>
                                                                <li><a class="dropdown-item" href="#">Process Order</a></li>
                                                                <li><a class="dropdown-item text-danger" href="#">Cancel</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>#ORD-4848</td>
                                                    <td>Michael Brown</td>
                                                    <td>Apr 07, 2025</td>
                                                    <td>$599.98</td>
                                                    <td><span class="badge bg-danger">Cancelled</span></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-light" type="button"
                                                                id="dropdownMenuButton4" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                                                <li><a class="dropdown-item" href="#">View Details</a></li>
                                                                <li><a class="dropdown-item" href="#">Process Order</a></li>
                                                                <li><a class="dropdown-item text-danger" href="#">Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>#ORD-4847</td>
                                                    <td>Jennifer Lopez</td>
                                                    <td>Apr 06, 2025</td>
                                                    <td>$799.99</td>
                                                    <td><span class="badge bg-success">Completed</span></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-light" type="button"
                                                                id="dropdownMenuButton5" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                                <li><a class="dropdown-item" href="#">View Details</a></li>
                                                                <li><a class="dropdown-item" href="#">Process Order</a></li>
                                                                <li><a class="dropdown-item text-danger" href="#">Cancel</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0">Recent Activity</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item border-0 recent-activity-item py-3">
                                            <div class="activity-dot bg-success"></div>
                                            <div class="d-flex w-100 justify-content-between mb-1">
                                                <h6 class="mb-0">New Order Received</h6>
                                                <small class="text-muted">Just now</small>
                                            </div>
                                            <p class="mb-0 text-muted">Order #ORD-4851 from Emma Watson</p>
                                        </div>
                                        <div class="list-group-item border-0 recent-activity-item py-3">
                                            <div class="activity-dot bg-primary"></div>
                                            <div class="d-flex w-100 justify-content-between mb-1">
                                                <h6 class="mb-0">Order Shipped</h6>
                                                <small class="text-muted">2 hours ago</small>
                                            </div>
                                            <p class="mb-0 text-muted">Order #ORD-4849 has been shipped</p>
                                        </div>
                                        <div class="list-group-item border-0 recent-activity-item py-3">
                                            <div class="activity-dot bg-warning"></div>
                                            <div class="d-flex w-100 justify-content-between mb-1">
                                                <h6 class="mb-0">Low Stock Alert</h6>
                                                <small class="text-muted">3 hours ago</small>
                                            </div>
                                            <p class="mb-0 text-muted">Smartphone X21 (3 items remaining)</p>
                                        </div>
                                        <div class="list-group-item border-0 recent-activity-item py-3">
                                            <div class="activity-dot bg-info"></div>
                                            <div class="d-flex w-100 justify-content-between mb-1">
                                                <h6 class="mb-0">New Customer Registered</h6>
                                                <small class="text-muted">5 hours ago</small>
                                            </div>
                                            <p class="mb-0 text-muted">Tom Hardy created a new account</p>
                                        </div>
                                        <div class="list-group-item border-0 recent-activity-item py-3">
                                            <div class="activity-dot bg-danger"></div>
                                            <div class="d-flex w-100 justify-content-between mb-1">
                                                <h6 class="mb-0">Order Cancelled</h6>
                                                <small class="text-muted">Yesterday</small>
                                            </div>
                                            <p class="mb-0 text-muted">Michael Brown cancelled order #ORD-4848</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <a href="#" class="btn btn-sm btn-light w-100">View All Activity</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Status -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Inventory Status</h5>
                                        <a href="admin-products.php" class="btn btn-sm btn-outline-primary">Manage
                                            Inventory</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Category</th>
                                                    <th>Stock</th>
                                                    <th>Price</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Premium Smartphone X21</td>
                                                    <td>Smartphones</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1" style="height: 5px;">
                                                                <div class="progress-bar bg-danger" role="progressbar"
                                                                    style="width: 15%;" aria-valuenow="15" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                            <span class="ms-2">3</span>
                                                        </div>
                                                    </td>
                                                    <td>$899.99</td>
                                                    <td><span class="badge bg-danger">Low Stock</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary">Restock</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>UltraBook Pro 15"</td>
                                                    <td>Laptops</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1" style="height: 5px;">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                    style="width: 35%;" aria-valuenow="35" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                            <span class="ms-2">18</span>
                                                        </div>
                                                    </td>
                                                    <td>$1,299.99</td>
                                                    <td><span class="badge bg-warning text-dark">Medium Stock</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary">Restock</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>NoiseCancel Pro Headphones</td>
                                                    <td>Audio</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1" style="height: 5px;">
                                                                <div class="progress-bar bg-success" role="progressbar"
                                                                    style="width: 75%;" aria-valuenow="75" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                            <span class="ms-2">42</span>
                                                        </div>
                                                    </td>
                                                    <td>$249.99</td>
                                                    <td><span class="badge bg-success">In Stock</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>SlimTab Pro 11"</td>
                                                    <td>Tablets</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1" style="height: 5px;">
                                                                <div class="progress-bar bg-success" role="progressbar"
                                                                    style="width: 60%;" aria-valuenow="60" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                            <span class="ms-2">27</span>
                                                        </div>
                                                    </td>
                                                    <td>$499.99</td>
                                                    <td><span class="badge bg-success">In Stock</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>SmartWatch Elite</td>
                                                    <td>Wearables</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1" style="height: 5px;">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                    style="width: 45%;" aria-valuenow="45" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                            <span class="ms-2">23</span>
                                                        </div>
                                                    </td>
                                                    <td>$299.99</td>
                                                    <td><span class="badge bg-warning text-dark">Medium Stock</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary">Restock</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="products-section" class="admin-section d-none">
                    <h2>Products Management</h2>
                    <p>Product management features go here.</p>
                </div>
                <div id="orders-section" class="admin-section d-none">
                    <h2>Orders Management</h2>
                    <p>Order management features go here.</p>
                </div>
                <div id="customers-section" class="admin-section d-none">
                    <h2 class="mb-4">User Management</h2>
                    <?php if (!empty($add_user_message)) echo $add_user_message; ?>
                    <form method="POST" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                        </div>
                        <div class="col-md-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-md-2">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="col-md-1">
                            <select name="type" class="form-select" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" name="add_user" class="btn btn-success">Add User</button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($user = $users->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $user['id']; ?></td>
                                        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['type']); ?></td>
                                        <td>
                                            <a href="admin-dashboard.php?delete_user=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="reports-section" class="admin-section d-none">
                    <h2>Reports</h2>
                    <p>Reports and analytics go here.</p>
                </div>
                <div id="settings-section" class="admin-section d-none">
                    <h2>Settings</h2>
                    <p>Admin settings go here.</p>
                </div>
                <!-- Footer -->
                <footer class="bg-white rounded shadow p-4 mb-4">
                    <div class="row">
                        <div class="col-12 col-md-4 col-xl-6 mb-4 mb-md-0">
                            <p class="mb-0 text-center text-lg-start">© 2025 <a href="index.php"
                                    class="text-decoration-none">Kushy Gadget Hub</a> - All Rights Reserved</p>
                        </div>
                        <div class="col-12 col-md-8 col-xl-6 text-center text-lg-end">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item"><a href="#" class="text-decoration-none">Support</a></li>
                                <li class="list-inline-item"><a href="#" class="text-decoration-none">Help Center</a>
                                </li>
                                <li class="list-inline-item"><a href="#" class="text-decoration-none">Privacy</a></li>
                                <li class="list-inline-item"><a href="#" class="text-decoration-none">Terms</a></li>
                            </ul>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script>
        // Sales Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['9 AM', '10 AM', '11 AM', '12 PM', '1 PM', '2 PM', '3 PM', '4 PM', '5 PM'],
                datasets: [{
                    label: 'Sales',
                    data: [1200, 1900, 1500, 2500, 2200, 3000, 2800, 3500, 3800],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [2, 4],
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Sidebar navigation logic
        const sections = [
            'dashboard', 'products', 'orders', 'customers', 'reports', 'settings'
        ];
        sections.forEach(section => {
            const link = document.querySelector(`#sidebar .nav-link[href*='${section}']`);
            if (link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Hide all sections
                    sections.forEach(sec => {
                        document.getElementById(`${sec}-section`).classList.add('d-none');
                    });
                    // Show the selected section
                    document.getElementById(`${section}-section`).classList.remove('d-none');
                    // Set active class
                    document.querySelectorAll('#sidebar .nav-link').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            }
        });
        // Show dashboard by default
        sections.forEach(sec => {
            document.getElementById(`${sec}-section`).classList.add('d-none');
        });
        document.getElementById('dashboard-section').classList.remove('d-none');
    </script>
</body>

</html>