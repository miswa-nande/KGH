<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Kushy Gadget Hub</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="design.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="home.html">
                KGH HUB
            </a>
            <button class="navbar-toggler text-gold" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="phones.html">Phones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="laptops.html">Laptops</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="cart.html" class="btn btn-light position-relative me-3">
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

    <!-- Checkout Section -->
    <section class="py-5">
        <div class="container">
            <h1 class="mb-4">Checkout</h1>

            <!-- Checkout Progress -->
            <div class="checkout-progress mb-5">
                <div class="row">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="progress-step active">
                            <div class="step-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="step-text">Cart</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="progress-step active">
                            <div class="step-icon">
                                <i class="fas fa-address-card"></i>
                            </div>
                            <div class="step-text">Information</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="progress-step">
                            <div class="step-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="step-text">Payment</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="progress-step">
                            <div class="step-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="step-text">Confirmation</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Customer Information Form -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h3 class="mb-3">Customer Information</h3>
                            <form id="checkout-form">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName" class="form-label">First Name*</label>
                                        <input type="text" class="form-control" id="firstName" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName" class="form-label">Last Name*</label>
                                        <input type="text" class="form-control" id="lastName" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address*</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number*</label>
                                    <input type="tel" class="form-control" id="phone" required>
                                </div>

                                <h3 class="mb-3 mt-4">Shipping Information</h3>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Street Address*</label>
                                    <input type="text" class="form-control" id="address" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address2" class="form-label">Apartment, suite, etc. (optional)</label>
                                    <input type="text" class="form-control" id="address2">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">City*</label>
                                        <input type="text" class="form-control" id="city" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="state" class="form-label">State/Province*</label>
                                        <select class="form-select" id="state" required>
                                            <option value="" selected disabled>Select State</option>
                                            <option value="AL">Alabama</option>
                                            <option value="AK">Alaska</option>
                                            <!-- Add more states as needed -->
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="zipcode" class="form-label">ZIP/Postal Code*</label>
                                        <input type="text" class="form-control" id="zipcode" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="country" class="form-label">Country*</label>
                                        <select class="form-select" id="country" required>
                                            <option value="US" selected>United States</option>
                                            <option value="CA">Canada</option>
                                            <option value="UK">United Kingdom</option>
                                            <!-- Add more countries as needed -->
                                        </select>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="sameAsBilling">
                                    <label class="form-check-label" for="sameAsBilling">
                                        Billing address same as shipping
                                    </label>
                                </div>

                                <div id="billing-info" class="d-none">
                                    <h3 class="mb-3 mt-4">Billing Information</h3>
                                    <!-- Billing address fields (similar to shipping) -->
                                </div>

                                <div class="mb-3">
                                    <label for="orderNotes" class="form-label">Order Notes (optional)</label>
                                    <textarea class="form-control" id="orderNotes" rows="3"
                                        placeholder="Special instructions for delivery"></textarea>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <a href="cart.html" class="btn btn-outline-secondary me-md-2">Back to Cart</a>
                                    <button type="submit" class="btn btn-primary">Continue to Payment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h3 class="mb-3">Order Summary</h3>
                            <div class="order-items">
                                <div class="order-item d-flex mb-3">
                                    <div class="item-image me-3">
                                        <img src="img/products/smartphone1.jpg" alt="Smartphone" class="img-fluid"
                                            width="60">
                                    </div>
                                    <div class="item-details flex-grow-1">
                                        <h6 class="item-title mb-0">Premium Smartphone X21</h6>
                                        <p class="text-muted mb-0">Color: Space Gray</p>
                                        <div class="d-flex justify-content-between">
                                            <span>Qty: 1</span>
                                            <span class="fw-bold">$899.99</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-item d-flex mb-3">
                                    <div class="item-image me-3">
                                        <img src="img/products/laptop2.jpg" alt="Laptop" class="img-fluid" width="60">
                                    </div>
                                    <div class="item-details flex-grow-1">
                                        <h6 class="item-title mb-0">UltraBook Pro 15"</h6>
                                        <p class="text-muted mb-0">RAM: 16GB</p>
                                        <div class="d-flex justify-content-between">
                                            <span>Qty: 1</span>
                                            <span class="fw-bold">$1,299.99</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="order-summary-details">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span>$2,199.98</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping</span>
                                    <span>$25.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax</span>
                                    <span>$176.00</span>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <span class="fw-bold">Total</span>
                                    <span class="fw-bold fs-5">$2,400.98</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Promo code">
                                    <button class="btn btn-outline-secondary" type="button">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="mb-3">Need Help?</h5>
                            <p class="mb-2"><i class="fas fa-phone-alt me-2"></i> Call us: (800) 123-4567</p>
                            <p class="mb-0"><i class="fas fa-envelope me-2"></i> Email: support@kushygadgethub.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
                    <h5>Kushy Gadget Hub</h5>
                    <p class="mt-3">Your one-stop destination for premium tech products and accessories.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.html" class="text-white text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="phones.html" class="text-white text-decoration-none">Phones</a></li>
                        <li class="mb-2"><a href="laptops.html" class="text-white text-decoration-none">Laptops</a></li>
                        <li class="mb-2"><a href="about.html" class="text-white text-decoration-none">About Us</a></li>
                        <li><a href="contact.html" class="text-white text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
                    <h5>Customer Service</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Order Tracking</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Returns & Refunds</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Shipping Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Privacy Policy</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
                    <h5>Newsletter</h5>
                    <p>Subscribe to get updates on new products and special offers.</p>
                    <form class="mt-3">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Your Email" aria-label="Your Email"
                                aria-describedby="subscribe-btn">
                            <button class="btn btn-primary" type="button" id="subscribe-btn">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0">&copy; 2025 Kushy Gadget Hub. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <img src="img/payment-methods.png" alt="Payment Methods" class="img-fluid"
                        style="max-width: 250px;">
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script>
        // Toggle billing address form
        document.getElementById('sameAsBilling').addEventListener('change', function () {
            const billingInfo = document.getElementById('billing-info');
            if (this.checked) {
                billingInfo.classList.add('d-none');
            } else {
                billingInfo.classList.remove('d-none');
            }
        });
    </script>
</body>

</html>