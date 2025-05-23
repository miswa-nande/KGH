<?php
session_start();
require_once 'conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    // Check if product exists and has enough stock
    $product = executeQuery("SELECT stock FROM products WHERE id = $product_id")->fetch_assoc();
    if (!$product) {
        $message = '<div class="alert alert-danger fade-in">Product not found.</div>';
    } else if ($quantity > $product['stock']) {
        $message = '<div class="alert alert-danger fade-in">Requested quantity exceeds available stock.</div>';
    } else {
        // Check if product already exists in cart
        $check_sql = "SELECT * FROM cart_items WHERE user_id = $user_id AND product_id = $product_id";
        $check_result = executeQuery($check_sql);
        
        if ($check_result->num_rows > 0) {
            // Update quantity if product exists
            $cart_item = $check_result->fetch_assoc();
            $new_quantity = $cart_item['quantity'] + $quantity;
            
            if ($new_quantity > $product['stock']) {
                $message = '<div class="alert alert-danger fade-in">Total quantity exceeds available stock.</div>';
            } else {
                $update_sql = "UPDATE cart_items SET quantity = $new_quantity WHERE id = " . $cart_item['id'];
                if (executeNonQuery($update_sql)) {
                    $message = '<div class="alert alert-success fade-in">Cart updated successfully!</div>';
                } else {
                    $message = '<div class="alert alert-danger fade-in">Failed to update cart.</div>';
                }
            }
        } else {
            // Add new item if product doesn't exist
            $sql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
            if (executeNonQuery($sql)) {
                $message = '<div class="alert alert-success fade-in">Item added to cart successfully!</div>';
            } else {
                $message = '<div class="alert alert-danger fade-in">Failed to add item to cart.</div>';
            }
        }
    }
}

// Handle Update Cart Item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart_item'])) {
    $cart_id = intval($_POST['cart_id']);
    $quantity = intval($_POST['quantity']);
    
    // Check if product has enough stock
    $cart_item = executeQuery("SELECT c.*, p.stock FROM cart_items c JOIN products p ON c.product_id = p.id WHERE c.id = $cart_id")->fetch_assoc();
    if ($cart_item && $quantity <= $cart_item['stock']) {
        $update_sql = "UPDATE cart_items SET quantity = $quantity WHERE id = $cart_id AND user_id = $user_id";
        if (executeNonQuery($update_sql)) {
            $message = '<div class="alert alert-success fade-in">Cart updated successfully!</div>';
        } else {
            $message = '<div class="alert alert-danger fade-in">Failed to update cart.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger fade-in">Requested quantity exceeds available stock.</div>';
    }
}

// Handle Delete Cart Item
if (isset($_GET['delete_cart_item'])) {
    $cart_id = intval($_GET['delete_cart_item']);
    $sql = "DELETE FROM cart_items WHERE id = $cart_id AND user_id = $user_id";
    if (executeNonQuery($sql)) {
        $message = '<div class="alert alert-success fade-in">Item removed from cart successfully!</div>';
    } else {
        $message = '<div class="alert alert-danger fade-in">Failed to remove item from cart.</div>';
    }
}

// Fetch user's cart items with product details
$cart_items = executeQuery("
    SELECT ci.*, p.name as product_name, p.price, p.image_url, p.stock
    FROM cart_items ci 
    JOIN products p ON ci.product_id = p.id 
    WHERE ci.user_id = $user_id 
    ORDER BY ci.created_at DESC
");

// Calculate total
$total = 0;
$cart_items_array = [];
while ($item = $cart_items->fetch_assoc()) {
    $total += $item['price'] * $item['quantity'];
    $cart_items_array[] = $item;
}

// Fetch available products for adding to cart
$products = executeQuery("
    SELECT id, name, price, stock, image_url 
    FROM products 
    WHERE stock > 0 
    ORDER BY name ASC
");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Kushy Gadget Hub</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="design.css">
    <style>
        /* Animation styles */
        .cart-item {
            transition: all 0.3s ease-out;
        }

        .cart-item.removing {
            opacity: 0;
            transform: translateX(50px);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        .fade-out {
            animation: fadeOut 0.5s ease-in-out;
        }

        .price-update {
            animation: highlight 1s ease-out;
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        .slide-up {
            animation: slideUp 0.3s ease-out forwards;
        }

        .slide-down {
            animation: slideDown 0.3s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @keyframes highlight {

            0%,
            100% {
                background-color: transparent;
            }

            50% {
                background-color: rgba(255, 220, 40, 0.2);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            50% {
                transform: translateX(5px);
            }

            75% {
                transform: translateX(-5px);
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Cart badge notification */
        .badge-cart {
            transition: all 0.3s ease;
        }

        .badge-cart.pulse {
            animation: pulse 0.5s ease-in-out;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.5);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Promo code feedback */
        #promoMessage {
            transition: all 0.3s ease;
        }

        /* Smooth quantity changes */
        .quantity-input {
            transition: all 0.2s ease;
            width: 80px;
        }

        .quantity-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                KGH HUB
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
                    <li class="nav-item">
                        <a class="nav-link" href="phones.php">Phones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="laptops.php">Laptops</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                <form class="d-flex me-3">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Search products" aria-label="Search">
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <div class="d-flex align-items-center">
                    <a href="cart.php" class="btn btn-light position-relative me-3 active">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge rounded-pill badge-cart" id="cart-count"><?php echo count($cart_items_array); ?></span>
                    </a>
                    <a href="login_page.php" class="btn btn-light me-2" id="loginBtn">
                        <i class="fas fa-user"></i> Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Cart Section -->
    <section class="py-5">
        <div class="container">
            <h1 class="mb-4">Shopping Cart</h1>
            
            <?php if (!empty($message)) echo $message; ?>

            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <?php if (empty($cart_items_array)): ?>
                        <div class="alert alert-info fade-in">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Your cart is empty. Add some products to get started!
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_items_array as $item): ?>
                                        <tr class="cart-item">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($item['image_url']): ?>
                                                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                                             alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                                             class="img-thumbnail me-3" style="width: 60px;">
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="mb-0"><?php echo htmlspecialchars($item['product_name']); ?></h6>
                                                        <small class="text-muted">Stock: <?php echo $item['stock']; ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                                            <td>
                                                <form method="POST" class="d-flex align-items-center">
                                                    <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                                    <input type="number" name="quantity" class="form-control form-control-sm quantity-input" 
                                                           value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>"
                                                           onchange="this.form.submit()">
                                                    <input type="hidden" name="update_cart_item" value="1">
                                                </form>
                                            </td>
                                            <td class="price-update">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                            <td>
                                                <a href="?delete_cart_item=<?php echo $item['id']; ?>" 
                                                   class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('Are you sure you want to remove this item?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td colspan="2"><strong>$<?php echo number_format($total, 2); ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Order Summary</h5>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>$<?php echo number_format($total, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>Free</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <strong>$<?php echo number_format($total, 2); ?></strong>
                            </div>
                            <?php if (!empty($cart_items_array)): ?>
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="home.php" class="btn btn-outline-primary">
                                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                                    </a>
                                    <a href="check_out page.php" class="btn btn-primary">
                                        <i class="fas fa-shopping-cart me-2"></i>Proceed to Checkout
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add to Cart Section -->
            <div class="mt-5">
                <h3>Add Products to Cart</h3>
                <div class="row">
                    <?php while ($product = $products->fetch_assoc()): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                     class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                    <p class="card-text">$<?php echo number_format($product['price'], 2); ?></p>
                                    <form method="POST" class="d-flex align-items-center">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <input type="number" name="quantity" class="form-control quantity-input me-2" 
                                               value="1" min="1" max="<?php echo $product['stock']; ?>">
                                        <button type="submit" name="add_to_cart" class="btn btn-primary">
                                            <i class="fas fa-cart-plus"></i> Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>Kushy Gadget Hub</h5>
                    <p>Your destination for premium phones and laptops.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h5>Shop</h5>
                    <ul class="list-unstyled">
                        <li><a href="phones.html" class="text-white">Phones</a></li>
                        <li><a href="laptops.html" class="text-white">Laptops</a></li>
                        <li><a href="accessories.html" class="text-white">Accessories</a></li>
                        <li><a href="deals.html" class="text-white">Deals</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h5>About</h5>
                    <ul class="list-unstyled">
                        <li><a href="about.html" class="text-white">Our Story</a></li>
                        <li><a href="blog.html" class="text-white">Blog</a></li>
                        <li><a href="careers.html" class="text-white">Careers</a></li>
                        <li><a href="contact.html" class="text-white">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <address class="mb-0">
                        <p><i class="fas fa-map-marker-alt me-2"></i> 123 Tech Street, Silicon Valley, CA</p>
                        <p><i class="fas fa-phone me-2"></i> (123) 456-7890</p>
                        <p><i class="fas fa-envelope me-2"></i> info@kghhub.com</p>
                    </address>
                </div>
            </div>
            <hr class="mt-4 mb-4 bg-white">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2025 Kushy Gadget Hub. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="terms.html" class="text-white">Terms of Service</a></li>
                        <li class="list-inline-item"><a href="privacy.html" class="text-white">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
    <script>
        // Update cart count badge
        function updateCartCount() {
            const cartCount = document.querySelector('.badge-cart');
            const count = <?php echo count($cart_items_array); ?>;
            cartCount.textContent = count;
            if (count > 0) {
                cartCount.classList.add('pulse');
                setTimeout(() => cartCount.classList.remove('pulse'), 500);
            }
        }

        // Initialize cart count
        updateCartCount();

        // Add animation to cart items
        document.querySelectorAll('.cart-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-outline-danger')) {
                    this.classList.add('removing');
                }
            });
        });

        // Add animation to price updates
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const row = this.closest('tr');
                const priceCell = row.querySelector('.price-update');
                priceCell.classList.add('price-update');
                setTimeout(() => priceCell.classList.remove('price-update'), 1000);
            });
        });
    </script>
</body>

</html>