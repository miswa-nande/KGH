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
        }

        .quantity-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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
                    <a href="cart.html" class="btn btn-light position-relative me-3 active">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge rounded-pill badge-cart" id="cart-count">0</span>
                    </a>
                    <a href="login_page.html" class="btn btn-light me-2" id="loginBtn">
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

            <div class="row" id="cartContainer">
                <!-- Cart Items Container -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div id="cartItems">
                                <!-- Cart items will be dynamically added here -->
                                <!-- Example Cart Item -->
                                <div class="cart-item mb-3" id="cart-item-1">
                                    <div class="row align-items-center">
                                        <div class="col-md-2 col-4 mb-md-0 mb-3">
                                            <img src="https://placehold.co/150x150" class="img-fluid rounded"
                                                alt="iPhone 16 Pro">
                                        </div>
                                        <div class="col-md-4 col-8 mb-md-0 mb-3">
                                            <h5 class="mb-0">iPhone 16 Pro</h5>
                                            <small class="text-muted">256GB, Midnight Black</small>
                                        </div>
                                        <div class="col-md-2 col-4 mb-md-0 mb-3">
                                            <div class="quantity-control">
                                                <button class="btn btn-sm btn-outline-secondary quantity-btn"
                                                    data-action="decrease" data-id="1">-</button>
                                                <input type="number" class="form-control form-control-sm quantity-input"
                                                    value="1" min="1" max="10" data-id="1">
                                                <button class="btn btn-sm btn-outline-secondary quantity-btn"
                                                    data-action="increase" data-id="1">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-4 mb-md-0 mb-3">
                                            <span class="price" id="price-1">₱1,199.99</span>
                                        </div>
                                        <div class="col-md-2 col-4 mb-md-0 mb-3 text-end">
                                            <button class="btn btn-sm btn-outline-danger remove-item" data-id="1">
                                                <i class="fas fa-trash-alt"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- Example Cart Item -->
                                <div class="cart-item mb-3" id="cart-item-2">
                                    <div class="row align-items-center">
                                        <div class="col-md-2 col-4 mb-md-0 mb-3">
                                            <img src="https://placehold.co/150x150" class="img-fluid rounded"
                                                alt="MacBook Air M2">
                                        </div>
                                        <div class="col-md-4 col-8 mb-md-0 mb-3">
                                            <h5 class="mb-0">MacBook Air M2</h5>
                                            <small class="text-muted">8GB RAM, 256GB SSD, Space Gray</small>
                                        </div>
                                        <div class="col-md-2 col-4 mb-md-0 mb-3">
                                            <div class="quantity-control">
                                                <button class="btn btn-sm btn-outline-secondary quantity-btn"
                                                    data-action="decrease" data-id="2">-</button>
                                                <input type="number" class="form-control form-control-sm quantity-input"
                                                    value="1" min="1" max="10" data-id="2">
                                                <button class="btn btn-sm btn-outline-secondary quantity-btn"
                                                    data-action="increase" data-id="2">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-4 mb-md-0 mb-3">
                                            <span class="price" id="price-2">₱23, 000.99</span>
                                        </div>
                                        <div class="col-md-2 col-4 mb-md-0 mb-3 text-end">
                                            <button class="btn btn-sm btn-outline-danger remove-item" data-id="2">
                                                <i class="fas fa-trash-alt"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Empty Cart Message (hidden when cart has items) -->
                            <div id="emptyCartMessage" class="text-center py-5" style="display: none;">
                                <i class="fas fa-shopping-cart fa-3x mb-3 text-muted"></i>
                                <h4>Your cart is empty</h4>
                                <p class="text-muted">Browse our collection and add items to your cart.</p>
                                <div class="mt-4">
                                    <a href="phones.html" class="btn btn-primary me-2">Shop Phones</a>
                                    <a href="laptops.html" class="btn btn-secondary">Shop Laptops</a>
                                </div>
                            </div>

                            <!-- Cart Controls -->
                            <div class="d-flex justify-content-between align-items-center mt-4" id="cartControls">
                                <a href="index.html" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                                </a>
                                <button id="clearCartBtn" class="btn btn-outline-danger">
                                    <i class="fas fa-trash-alt me-2"></i> Clear Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h4 class="mb-3">Order Summary</h4>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span id="subtotal">₱2,399.98</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span id="shipping">₱0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax</span>
                                <span id="tax">₱192.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong>Total</strong>
                                <strong id="total" class="price">₱2,591.98</strong>
                            </div>

                            <!-- Promo Code -->
                            <div class="mb-4">
                                <label for="promoCode" class="form-label">Promo Code</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="promoCode" placeholder="Enter code">
                                    <button class="btn btn-secondary" type="button" id="applyPromo">Apply</button>
                                </div>
                                <div id="promoMessageContainer">
                                    <small id="promoMessage" class="text-success" style="display: none;">Promo code
                                        applied!</small>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <a href="checkout.html" class="btn btn-primary w-100 py-2" id="checkoutBtn">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>

                    <!-- Secure Payment -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-3">Secure Payment</h5>
                            <p class="text-muted small mb-2">We accept the following payment methods:</p>
                            <div class="payment-methods">
                                <i class="fab fa-cc-visa fa-2x me-2"></i>
                                <i class="fab fa-cc-mastercard fa-2x me-2"></i>
                                <i class="fab fa-cc-amex fa-2x me-2"></i>
                                <i class="fab fa-cc-paypal fa-2x"></i>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-lock text-success me-2"></i>
                                <small class="text-muted">Your transaction is secured with SSL encryption</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recently Viewed Products -->
            <div class="mt-5">
                <h3 class="mb-4">Recently Viewed</h3>
                <div class="row">
                    <!-- Product 1 -->
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card product-card">
                            <img src="https://placehold.co/300x300" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title">Samsung Galaxy S25</h5>
                                <p class="price mb-2">₱999.99</p>
                                <a href="product_detail_page.html" class="btn btn-outline-primary btn-sm w-100">View
                                    Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card product-card">
                            <img src="https://placehold.co/300x300" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title">Dell XPS 15</h5>
                                <p class="price mb-2">₱1,899.99</p>
                                <a href="product_detail_page.html" class="btn btn-outline-primary btn-sm w-100">View
                                    Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card product-card">
                            <img src="https://placehold.co/300x300" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title">iPhone 16</h5>
                                <p class="price mb-2">₱899.99</p>
                                <a href="product_detail_page.html" class="btn btn-outline-primary btn-sm w-100">View
                                    Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- Product 4 -->
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card product-card">
                            <img src="https://placehold.co/300x300" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title">MacBook Pro 16</h5>
                                <p class="price mb-2">₱2,499.99</p>
                                <a href="product_detail_page.html" class="btn btn-outline-primary btn-sm w-100">View
                                    Details</a>
                            </div>
                        </div>
                    </div>
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
    <script src="cart_config.js"></script>
</body>

</html>