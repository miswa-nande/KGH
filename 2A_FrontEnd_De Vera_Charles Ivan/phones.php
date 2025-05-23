<?php
session_start();
require_once 'conn.php';

// Get phone products
$phones = executeQuery("SELECT * FROM products WHERE category = 'phone'");

// Get cart count if user is logged in
$cart_count = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $cart_result = executeQuery("SELECT SUM(quantity) as total FROM cart_items WHERE user_id = $user_id");
    $cart_count = $cart_result->fetch_assoc()['total'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phones - Kushy Gadget Hub</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="design.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/phones.css">
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
                        <a class="nav-link active" aria-current="page" href="phones.php">Phones</a>
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
                    <a href="cart.php" class="btn btn-light position-relative me-3">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge rounded-pill badge-cart" id="cart-count">0</span>
                    </a>
                    <a href="user_account.php" class="btn btn-light me-2" id="loginBtn">
                        <i class="fas fa-user"></i> Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Banner -->
    <section class="page-banner animate__animated animate__fadeIn">
        <div class="container">
            <h1>Smartphones</h1>
            <p class="lead">Discover the latest mobile technology with premium features</p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Filter Sidebar -->
                <div class="col-lg-3">
                    <div class="filter-sidebar mb-4 animate__animated animate__fadeInLeft">
                        <h4>Filters</h4>
                        <hr>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <h6>Price Range</h6>
                            <div class="mb-3">
                                <label for="priceRange" class="form-label">₱25,000 - ₱100,000</label>
                                <input type="range" class="form-range" min="25000" max="100000" step="5000"
                                    id="priceRange" value="50000">
                                <div class="d-flex justify-content-between">
                                    <span>₱25,000</span>
                                    <span id="priceValue">₱50,000</span>
                                    <span>₱100,000</span>
                                </div>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="mb-4">
                            <h6>Brand</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="apple" id="appleCheck">
                                <label class="form-check-label" for="appleCheck">
                                    Apple
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="samsung" id="samsungCheck">
                                <label class="form-check-label" for="samsungCheck">
                                    Samsung
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="google" id="googleCheck">
                                <label class="form-check-label" for="googleCheck">
                                    Google
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="xiaomi" id="xiaomiCheck">
                                <label class="form-check-label" for="xiaomiCheck">
                                    Xiaomi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="oneplus" id="oneplusCheck">
                                <label class="form-check-label" for="oneplusCheck">
                                    OnePlus
                                </label>
                            </div>
                        </div>

                        <!-- Memory Filter -->
                        <div class="mb-4">
                            <h6>Storage</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="128gb" id="128gbCheck">
                                <label class="form-check-label" for="128gbCheck">
                                    128GB
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="256gb" id="256gbCheck">
                                <label class="form-check-label" for="256gbCheck">
                                    256GB
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="512gb" id="512gbCheck">
                                <label class="form-check-label" for="512gbCheck">
                                    512GB
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1tb" id="1tbCheck">
                                <label class="form-check-label" for="1tbCheck">
                                    1TB
                                </label>
                            </div>
                        </div>

                        <!-- Apply Filters Button -->
                        <button class="btn btn-primary w-100">Apply Filters</button>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="col-lg-9">
                    <!-- Sort Options -->
                    <div
                        class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeInRight">
                        <p class="mb-0">Showing 12 of 36 products</p>
                        <div class="d-flex align-items-center">
                            <label for="sortOptions" class="me-2">Sort by:</label>
                            <select class="form-select form-select-sm" id="sortOptions" style="width: auto;">
                                <option value="recommended">Recommended</option>
                                <option value="price-low">Price: Low to High</option>
                                <option value="price-high">Price: High to Low</option>
                                <option value="newest">Newest First</option>
                                <option value="rating">Top Rated</option>
                            </select>
                        </div>
                    </div>

                    <!-- Products Row -->
                    <div class="row" id="productsContainer">
                        <!-- Product 1 -->
                        <div class="col-md-4 col-6 fade-in">
                            <div class="card product-card">
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2">NEW</span>
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="iPhone 16 Pro">
                                <div class="card-body">
                                    <h5 class="card-title">iPhone 16 Pro</h5>
                                    <div class="mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                        <small class="text-muted">(124)</small>
                                    </div>
                                    <p class="card-text small">6.1" Retina XDR, A18 chip, 256GB</p>
                                    <p class="price mb-2">₱59,999.95</p>
                                    <a href="product-detail.php?id=1"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    <button class="btn btn-primary btn-sm w-100 add-to-cart" data-id="1"
                                        data-name="iPhone 16 Pro" data-price="59999.95">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 2 -->
                        <div class="col-md-4 col-6 fade-in">
                            <div class="card product-card">
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="Galaxy S25 Ultra">
                                <div class="card-body">
                                    <h5 class="card-title">Galaxy S25 Ultra</h5>
                                    <div class="mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <small class="text-muted">(89)</small>
                                    </div>
                                    <p class="card-text small">6.8" AMOLED, 16GB RAM, 512GB</p>
                                    <p class="price mb-2">₱64,999.95</p>
                                    <a href="product-detail.php?id=2"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    <button class="btn btn-primary btn-sm w-100 add-to-cart" data-id="2"
                                        data-name="Galaxy S25 Ultra" data-price="64999.95">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 3 -->
                        <div class="col-md-4 col-6 fade-in">
                            <div class="card product-card">
                                <span class="badge bg-warning position-absolute top-0 end-0 m-2">SALE</span>
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="Pixel 8 Pro">
                                <div class="card-body">
                                    <h5 class="card-title">Pixel 8 Pro</h5>
                                    <div class="mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <small class="text-muted">(56)</small>
                                    </div>
                                    <p class="card-text small">6.7" OLED, Google Tensor, 256GB</p>
                                    <p class="price mb-2">₱44,999.95 <small
                                            class="text-decoration-line-through text-muted">₱49,999.95</small></p>
                                    <a href="product-detail.php?id=3"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    <button class="btn btn-primary btn-sm w-100 add-to-cart" data-id="3"
                                        data-name="Pixel 8 Pro" data-price="44999.95">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 4 -->
                        <div class="col-md-4 col-6 fade-in">
                            <div class="card product-card">
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="OnePlus 12">
                                <div class="card-body">
                                    <h5 class="card-title">OnePlus 12</h5>
                                    <div class="mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                        <small class="text-muted">(42)</small>
                                    </div>
                                    <p class="card-text small">6.7" Fluid AMOLED, 12GB RAM, 256GB</p>
                                    <p class="price mb-2">₱49,999.95</p>
                                    <a href="product-detail.php?id=4"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    <button class="btn btn-primary btn-sm w-100 add-to-cart" data-id="4"
                                        data-name="OnePlus 12" data-price="49999.95">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 5 -->
                        <div class="col-md-4 col-6 fade-in">
                            <div class="card product-card">
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="iPhone 16">
                                <div class="card-body">
                                    <h5 class="card-title">iPhone 16</h5>
                                    <div class="mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <small class="text-muted">(67)</small>
                                    </div>
                                    <p class="card-text small">6.1" Retina, A18 chip, 128GB</p>
                                    <p class="price mb-2">₱44,999.95</p>
                                    <a href="product-detail.php?id=5"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    <button class="btn btn-primary btn-sm w-100 add-to-cart" data-id="5"
                                        data-name="iPhone 16" data-price="44999.95">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 6 -->
                        <div class="col-md-4 col-6 fade-in">
                            <div class="card product-card">
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="Xiaomi 14 Ultra">
                                <div class="card-body">
                                    <h5 class="card-title">Xiaomi 14 Ultra</h5>
                                    <div class="mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <small class="text-muted">(38)</small>
                                    </div>
                                    <p class="card-text small">6.73" AMOLED, 12GB RAM, 256GB</p>
                                    <p class="price mb-2">₱52,499.95</p>
                                    <a href="product-detail.php?id=6"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    <button class="btn btn-primary btn-sm w-100 add-to-cart" data-id="6"
                                        data-name="Xiaomi 14 Ultra" data-price="52499.95">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
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
                        <li><a href="phones.php" class="text-white">Phones</a></li>
                        <li><a href="laptops.php" class="text-white">Laptops</a></li>
                        <li><a href="accessories.php" class="text-white">Accessories</a></li>
                        <li><a href="deals.php" class="text-white">Deals</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h5>About</h5>
                    <ul class="list-unstyled">
                        <li><a href="about.php" class="text-white">Our Story</a></li>
                        <li><a href="blog.php" class="text-white">Blog</a></li>
                        <li><a href="careers.php" class="text-white">Careers</a></li>
                        <li><a href="contact.php" class="text-white">Contact Us</a></li>
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
                        <li class="list-inline-item"><a href="terms.php" class="text-white">Terms of Service</a></li>
                        <li class="list-inline-item"><a href="privacy.php" class="text-white">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Cart Configuration -->
    <script src="cart_config.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Price range slider functionality
            const priceRange = document.getElementById('priceRange');
            const priceValue = document.getElementById('priceValue');

            if (priceRange && priceValue) {
                priceRange.addEventListener('input', function () {
                    priceValue.textContent = `₱${Number(this.value).toLocaleString()}`;
                });
            }

            // Check for login status
            const loginBtn = document.getElementById('loginBtn');
            const isLoggedIn = localStorage.getItem('kghLoggedIn');

            if (loginBtn && isLoggedIn === 'true') {
                loginBtn.innerHTML = '<i class="fas fa-user"></i> My Account';
                loginBtn.href = 'account.php';
            }

            // Staggered fade-in animation for products
            const productElements = document.querySelectorAll('.fade-in');
            productElements.forEach((element, index) => {
                setTimeout(() => {
                    element.classList.add('animate__animated', 'animate__fadeIn');
                }, 100 * index);
            });
        });
    </script>
</body>

</html>