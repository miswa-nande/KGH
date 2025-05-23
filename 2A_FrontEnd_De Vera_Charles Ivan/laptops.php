<?php
session_start();
require_once 'conn.php';

// Get laptop products
$laptops = executeQuery("SELECT * FROM products WHERE category = 'laptop'");

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
    <title>Laptops - Kushy Gadget Hub</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="design.css">
    <style>
        /* Added animations and improved flow */
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 25px;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .add-to-cart {
            transition: background-color 0.3s ease;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .filter-sidebar {
            position: sticky;
            top: 80px;
        }

        .badge-cart {
            background-color: #ff6b6b;
            color: white;
        }

        .price {
            font-weight: bold;
            font-size: 1.1rem;
            color: #d62828;
        }

        .footer {
            background-color: #212529;
            color: white;
            padding: 3rem 0 2rem;
        }

        /* Animation classes */
        .fade-in {
            animation: fadeIn 1s ease;
        }

        .slide-in {
            animation: slideInRight 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(50px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand animate__animated animate__fadeIn" href="home.php">
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
                        <a class="nav-link active" aria-current="page" href="laptops.php">Laptops</a>
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
                    <a href="cart.php" class="btn btn-light position-relative me-3 animate__animated animate__pulse">
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
            <h1>Laptops</h1>
            <p class="lead">Discover high-performance computing for work and play</p>
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
                                <label for="priceRange" class="form-label">₱40,000 - ₱150,000</label>
                                <input type="range" class="form-range" min="40000" max="150000" step="5000"
                                    id="priceRange">
                                <div class="d-flex justify-content-between">
                                    <span>₱40,000</span>
                                    <span id="priceValue">₱75,000</span>
                                    <span>₱150,000</span>
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
                                <input class="form-check-input" type="checkbox" value="dell" id="dellCheck">
                                <label class="form-check-label" for="dellCheck">
                                    Dell
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="hp" id="hpCheck">
                                <label class="form-check-label" for="hpCheck">
                                    HP
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="lenovo" id="lenovoCheck">
                                <label class="form-check-label" for="lenovoCheck">
                                    Lenovo
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="asus" id="asusCheck">
                                <label class="form-check-label" for="asusCheck">
                                    ASUS
                                </label>
                            </div>
                        </div>

                        <!-- Processor Filter -->
                        <div class="mb-4">
                            <h6>Processor</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="intel-i5" id="i5Check">
                                <label class="form-check-label" for="i5Check">
                                    Intel Core i5
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="intel-i7" id="i7Check">
                                <label class="form-check-label" for="i7Check">
                                    Intel Core i7
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="intel-i9" id="i9Check">
                                <label class="form-check-label" for="i9Check">
                                    Intel Core i9
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="apple-m2" id="m2Check">
                                <label class="form-check-label" for="m2Check">
                                    Apple M2
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="amd-ryzen" id="ryzenCheck">
                                <label class="form-check-label" for="ryzenCheck">
                                    AMD Ryzen
                                </label>
                            </div>
                        </div>

                        <!-- RAM Filter -->
                        <div class="mb-4">
                            <h6>RAM</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="8gb" id="8gbCheck">
                                <label class="form-check-label" for="8gbCheck">
                                    8GB
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="16gb" id="16gbCheck">
                                <label class="form-check-label" for="16gbCheck">
                                    16GB
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="32gb" id="32gbCheck">
                                <label class="form-check-label" for="32gbCheck">
                                    32GB
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="64gb" id="64gbCheck">
                                <label class="form-check-label" for="64gbCheck">
                                    64GB
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
                        class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
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
                    <div class="row">
                        <!-- Product 1 -->
                        <div class="col-md-4 col-6">
                            <div class="card product-card animate__animated animate__fadeIn">
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2">NEW</span>
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="MacBook Pro 16">
                                <div class="card-body">
                                    <h5 class="card-title">MacBook Pro 16</h5>
                                    <div class="mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                        <small class="text-muted">(87)</small>
                                    </div>
                                    <p class="card-text small">M2 Pro, 16GB RAM, 512GB SSD</p>
                                    <p class="price mb-2">₱124,999.95</p>
                                    <a href="product_detail_page.php"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    <button class="btn btn-primary btn-sm w-100 add-to-cart" data-id="101"
                                        data-name="MacBook Pro 16" data-price="124999.95">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 2 -->
                        <div class="col-md-4 col-6">
                            <div class="card product-card animate__animated animate__fadeIn"
                                style="animation-delay: 0.1s">
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="Dell XPS 15">
                                <div class="card-body">
                                    <h5 class="card-title">Dell XPS 15</h5>
                                    <div class="mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <small class="text-muted">(65)</small>
                                    </div>
                                    <p class="card-text small">i7-12700H, 16GB RAM, 1TB SSD</p>
                                    <p class="price mb-2">₱94,999.95</p>
                                    <a href="product_detail_page.php"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    <button class="btn btn-primary btn-sm w-100 add-to-cart" data-id="102"
                                        data-name="Dell XPS 15" data-price="94999.95">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 3 -->
                        <div class="col-md-4 col-6">
                            <div class="card product-card animate__animated animate__fadeIn"
                                style="animation-delay: 0.2s">
                                <span class="badge bg-warning position-absolute top-0 end-0 m-2">SALE</span>
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="HP Spectre x360">
                                <div class="card-body">
                                    <h5 class="card-title">HP Spectre x360</h5>
                                    <div class="mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <small class="text-muted">(42)</small>
                                    </div>
                                    <p class="card-text small">i7-1255U, 16GB RAM, 512GB SSD</p>
                                    <p class="price mb-2">₱69,999.95 <small
                                            class="text-decoration-line-through text-muted">₱79,999.95</small></p>
                                    <a href="product_detail_page.php"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    <button class="btn btn-primary btn-sm w-100 add-to-cart" data-id="103"
                                        data-name="HP Spectre x360" data-price="69999.95">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 4 -->
                        <div class="col-md-4 col-6">
                            <div class="card product-card animate__animated animate__fadeIn"
                                style="animation-delay: 0.3s">
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="ASUS ROG Zephyrus">
                                <div class="card-body">
                                    <h5 class="card-title">ASUS ROG Zephyrus</h5>
                                    <div class="mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                        <small class="text-muted">(56)</small>
                                    </div>
                                    <p class="card-text small">AMD Ryzen 9, 32GB RAM, 1TB SSD</p>
                                    <p class="price mb-2">₱104,999.95</p>
                                    <a href="product_detail_page.php"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    <button class="btn btn-primary btn-sm w-100 add-to-cart" data-id="104"
                                        data-name="ASUS ROG Zephyrus" data-price="104999.95">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 5 -->
                        <div class="col-md-4 col-6">
                            <div class="card product-card animate__animated animate__fadeIn"
                                style="animation-delay: 0.4s">
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="Lenovo ThinkPad X1">
                                <div class="card-body">
                                    <h5 class="card-title">Lenovo ThinkPad X1</h5>
                                    <div class="mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <small class="text-muted">(38)</small>
                                    </div>
                                    <p class="card-text small">i7-1280P, 16GB RAM, 512GB SSD</p>
                                    <p class="price mb-2">₱89,999.95</p>
                                    <a href="product_detail_page.php"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    <button class="btn btn-primary btn-sm w-100 add-to-cart" data-id="105"
                                        data-name="Lenovo ThinkPad X1" data-price="89999.95">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 6 -->
                        <div class="col-md-4 col-6">
                            <div class="card product-card animate__animated animate__fadeIn"
                                style="animation-delay: 0.5s">
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="MacBook Air M2">
                                <div class="card-body">
                                    <h5 class="card-title">MacBook Air M2</h5>
                                    <div class="mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <small class="text-muted">(72)</small>
                                    </div>
                                    <p class="card-text small">M2 chip, 8GB RAM, 256GB SSD</p>
                                    <p class="price mb-2">₱59,999.95</p>
                                    <a href="product_detail_page.php"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    <button class="btn btn-primary btn-sm w-100 add-to-cart" data-id="106"
                                        data-name="MacBook Air M2" data-price="59999.95">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center animate__animated animate__fadeIn">
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
        // Price range slider
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');

        priceRange.addEventListener('input', function () {
            priceValue.textContent = '₱' + this.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });

        // Staggered animation for products on scroll
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.product-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__animated', 'animate__fadeIn');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            cards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>

</html>