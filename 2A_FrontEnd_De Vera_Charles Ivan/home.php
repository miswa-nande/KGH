<?php require_once 'conn.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kushy Gadget Hub - Premium Gadgets Store</title>
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
                        <a class="nav-link active" href="contact.php">Contact</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="cart.php" class="nav-link me-3 position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge rounded-pill badge-cart" id="cart-count">0</span>
                    </a>
                    <a href="user_account.php" class="nav-link me-3">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="login_page.php" class="btn btn-sm btn-primary">
                        Login / Register
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>Premium Gadgets for Modern Life</h1>
            <p class="lead mb-4">Discover the latest phones and laptops at Kushy Gadget Hub</p>
            <div>
                <a href="phones.php" class="btn btn-primary btn-lg me-2">Shop Phones</a>
                <a href="laptops.php" class="btn btn-secondary btn-lg">Shop Laptops</a>
            </div>
        </div>
    </section>

    <!-- Category Section -->
    <section class="category-section">
        <div class="container">
            <h2 class="text-center mb-5">Shop by Category</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <img src="images/phone_1.jpg" class="card-img-top" alt="Phones">
                        <div class="card-body text-center">
                            <h3>Smartphones</h3>
                            <p>Discover the latest mobile technology with premium features and performance.</p>
                            <a href="phones.php" class="btn btn-primary">Browse Phones</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <img src="images/laptop_1.jpg" class="card-img-top" alt="Laptops">
                        <div class="card-body text-center">
                            <h3>Laptops</h3>
                            <p>Find powerful laptops for work, gaming, and everyday use with premium specs.</p>
                            <a href="laptops.php" class="btn btn-primary">Browse Laptops</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="featured-section bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Featured Products</h2>
            <div class="row">
                <?php
                // Fetch featured products (customize the query as needed)
                $sql = "SELECT * FROM products LIMIT 4";
                $result = executeQuery($sql);
                while ($product = $result->fetch_assoc()): ?>
                    <div class="col-md-3 col-6">
                        <div class="card product-card">
                            <?php if (!empty($product['is_new'])): ?>
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2">NEW</span>
                            <?php elseif (!empty($product['is_sale'])): ?>
                                <span class="badge bg-warning position-absolute top-0 end-0 m-2">SALE</span>
                            <?php endif; ?>
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text small"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="price mb-2">₱<?php echo number_format($product['price'], 2); ?></p>
                                <button class="btn btn-primary btn-sm w-100 add-to-cart"
                                    data-id="<?php echo $product['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($product['name']); ?>"
                                    data-price="<?php echo $product['price']; ?>">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="text-center mt-4">
                <a href="products.php" class="btn btn-primary">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">What Our Customers Say</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text">"The MacBook Pro I purchased from KGH Hub exceeded all my expectations.
                                The customer service was exceptional and delivery was faster than expected."</p>
                            <p class="font-weight-bold mb-0">- Jennifer L.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text">"Best prices on premium gadgets! I compared prices everywhere and KGH
                                Hub offered the best deals without compromising on quality or warranty."</p>
                            <p class="font-weight-bold mb-0">- Michael K.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star-half-alt text-warning"></i>
                            </div>
                            <p class="card-text">"The Galaxy S25 Ultra I bought works flawlessly. The website made it
                                easy to compare different models and choose the right one for my needs."</p>
                            <p class="font-weight-bold mb-0">- Sarah T.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h3>Stay Updated with Our Latest Offers</h3>
                    <p class="mb-4">Subscribe to our newsletter and be the first to know about new product launches and
                        exclusive deals.</p>
                    <form class="row g-3 justify-content-center">
                        <div class="col-md-8">
                            <input type="email" class="form-control" placeholder="Your email address">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Subscribe</button>
                        </div>
                    </form>
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
                        <p><i class="fas fa-map-marker-alt me-2"></i>Daet, Camarines Norte</p>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Cart functionality
        document.addEventListener('DOMContentLoaded', function () {
            // Load cart from localStorage
            let cart = JSON.parse(localStorage.getItem('kghCart')) || [];

            // Update cart count on page load
            updateCartCount();

            // Add to cart buttons
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const price = parseFloat(this.getAttribute('data-price'));

                    // Check if product is already in cart
                    const existingItemIndex = cart.findIndex(item => item.id === id);

                    if (existingItemIndex !== -1) {
                        cart[existingItemIndex].quantity += 1;
                    } else {
                        cart.push({
                            id: id,
                            name: name,
                            price: price,
                            quantity: 1
                        });
                    }

                    // Save to localStorage
                    localStorage.setItem('kghCart', JSON.stringify(cart));

                    // Update cart count
                    updateCartCount();

                    // Format price for display
                    const formattedPrice = new Intl.NumberFormat('en-PH', {
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2
                    }).format(price);

                    // Show success message
                    alert(`${name} (${formattedPrice}) has been added to your cart!`);
                });
            });

            // Update cart count badge
            function updateCartCount() {
                const cartCountElement = document.getElementById('cart-count');
                if (cartCountElement) {
                    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
                    cartCountElement.textContent = totalItems;
                }
            }
        });
    </script>
</body>

</html>