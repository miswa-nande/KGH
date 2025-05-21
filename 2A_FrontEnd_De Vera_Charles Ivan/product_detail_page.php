<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail - Kushy Gadget Hub</title>
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

    <!-- Product Detail Section -->
    <section class="py-5">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                    <li class="breadcrumb-item category-breadcrumb"><a href="#" id="categoryLink">Phones</a></li>
                    <li class="breadcrumb-item active" aria-current="page" id="productName">iPhone 16 Pro</li>
                </ol>
            </nav>

            <div class="row" id="productDetailContainer">
                <!-- Product Images -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0">
                        <div class="position-relative">
                            <img src="https://placehold.co/600x600" class="img-fluid rounded-3" id="mainProductImage"
                                alt="iPhone 16 Pro">
                            <span class="badge bg-danger position-absolute top-0 end-0 m-3" id="productBadge">NEW</span>
                        </div>
                        <div class="d-flex mt-3 thumbnail-container">
                            <div class="thumbnail-image active me-2">
                                <img src="https://placehold.co/600x600" class="img-fluid rounded-3 thumbnail"
                                    alt="iPhone 16 Pro - Front">
                            </div>
                            <div class="thumbnail-image me-2">
                                <img src="https://placehold.co/600x600" class="img-fluid rounded-3 thumbnail"
                                    alt="iPhone 16 Pro - Back">
                            </div>
                            <div class="thumbnail-image me-2">
                                <img src="https://placehold.co/600x600" class="img-fluid rounded-3 thumbnail"
                                    alt="iPhone 16 Pro - Side">
                            </div>
                            <div class="thumbnail-image">
                                <img src="https://placehold.co/600x600" class="img-fluid rounded-3 thumbnail"
                                    alt="iPhone 16 Pro - Camera">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-md-6">
                    <div class="product-header mb-3">
                        <h1 id="productDetailName">iPhone 16 Pro</h1>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <span class="me-2">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                </span>
                                <span class="text-muted">4.5 (124 reviews)</span>
                            </div>
                            <span class="badge bg-success">In Stock</span>
                        </div>
                        <h2 class="price mt-2" id="productPrice">₱65,999.00</h2>
                    </div>

                    <!-- Product Options Selection -->
                    <div class="product-options mb-4">
                        <div class="mb-3">
                            <h5>Available Colors</h5>
                            <div class="d-flex color-options">
                                <div class="color-option me-2 active" data-color="Titanium Black"></div>
                                <div class="color-option me-2" data-color="Titanium White"></div>
                                <div class="color-option me-2" data-color="Titanium Gold"></div>
                                <div class="color-option me-2" data-color="Titanium Blue"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h5>Storage Options</h5>
                            <div class="btn-group storage-options" role="group">
                                <button type="button" class="btn btn-outline-secondary">128GB</button>
                                <button type="button" class="btn btn-outline-secondary active">256GB</button>
                                <button type="button" class="btn btn-outline-secondary">512GB</button>
                                <button type="button" class="btn btn-outline-secondary">1TB</button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center qty-section">
                                <h5 class="me-3 mb-0">Quantity:</h5>
                                <div class="input-group quantity-selector" style="width: 120px;">
                                    <button class="btn btn-outline-secondary" id="decreaseQty" type="button">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="text" class="form-control text-center" id="quantity" value="1" min="1">
                                    <button class="btn btn-outline-secondary" id="increaseQty" type="button">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button id="addToCartBtn" class="btn btn-primary btn-lg">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                            <button id="buyNowBtn" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-bolt me-2"></i>Buy Now
                            </button>
                        </div>
                    </div>

                    <!-- Product Services -->
                    <div class="product-services mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-truck me-2 text-primary"></i>
                            <span>Free shipping for orders over ₱2,500</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-exchange-alt me-2 text-primary"></i>
                            <span>30-day return policy</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shield-alt me-2 text-primary"></i>
                            <span>2-year warranty included</span>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p>Experience the cutting-edge technology of Apple's latest flagship smartphone with the A18 Pro
                            bionic chip, advanced camera system, and stunning 6.3-inch ProMotion XDR display.</p>
                        <a href="#full-description" class="text-decoration-none" data-bs-toggle="tab"
                            data-bs-target="#full-description">Read more</a>
                    </div>
                </div>
            </div>

            <!-- Product Details Tabs Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="full-description-tab" data-bs-toggle="tab"
                                data-bs-target="#full-description" type="button" role="tab"
                                aria-controls="full-description" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs"
                                type="button" role="tab" aria-controls="specs"
                                aria-selected="false">Specifications</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq"
                                type="button" role="tab" aria-controls="faq" aria-selected="false">FAQ</button>
                        </li>
                    </ul>

                    <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabsContent">
                        <!-- Full Description Tab -->
                        <div class="tab-pane fade show active" id="full-description" role="tabpanel"
                            aria-labelledby="full-description-tab">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4>Product Description</h4>
                                    <p>Experience the cutting-edge technology of Apple's latest flagship smartphone. The
                                        iPhone 16
                                        Pro combines sleek design with powerful performance for the ultimate mobile
                                        experience.</p>

                                    <p>Featuring the new A18 Pro bionic chip, this device delivers lightning-fast
                                        processing speeds
                                        and incredible energy efficiency. The advanced camera system includes a 48MP
                                        main camera
                                        with enhanced low-light capabilities, a 12MP ultra-wide lens with macro
                                        photography, and a
                                        12MP telephoto lens with 5x optical zoom.</p>

                                    <p>The stunning 6.3-inch ProMotion XDR display offers vibrant colors, incredible
                                        contrast, and
                                        adaptive refresh rates up to 120Hz. With all-day battery life and fast charging
                                        capabilities, you'll never miss a moment.</p>

                                    <h5 class="mt-4">Key Features</h5>
                                    <ul class="feature-list">
                                        <li>A18 Pro bionic chip with enhanced Neural Engine</li>
                                        <li>6.3-inch Super Retina XDR display with ProMotion technology</li>
                                        <li>Triple camera system (48MP main, 12MP ultra-wide, 12MP telephoto)</li>
                                        <li>Up to 1TB storage capacity</li>
                                        <li>iOS 18 with new customization options</li>
                                        <li>All-day battery life with fast charging</li>
                                        <li>Titanium frame with Ceramic Shield front</li>
                                        <li>IP68 water and dust resistance</li>
                                        <li>Face ID for secure authentication</li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3 mb-3">
                                        <h5>What's in the box</h5>
                                        <ul>
                                            <li>iPhone 16 Pro</li>
                                            <li>USB-C to Lightning Cable</li>
                                            <li>Documentation</li>
                                        </ul>
                                    </div>
                                    <div class="card p-3">
                                        <h5>Payment Options</h5>
                                        <p>Pay in full or in 12 monthly installments of ₱5,499.92*</p>
                                        <small class="text-muted">*Subject to credit approval</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Specifications Tab -->
                        <div class="tab-pane fade" id="specs" role="tabpanel" aria-labelledby="specs-tab">
                            <h4>Technical Specifications</h4>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th scope="row">Display</th>
                                        <td>6.3-inch Super Retina XDR display with ProMotion technology (120Hz)</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Processor</th>
                                        <td>A18 Pro bionic chip with enhanced Neural Engine</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Storage</th>
                                        <td>128GB / 256GB / 512GB / 1TB</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Rear Camera</th>
                                        <td>Triple camera system (48MP main, 12MP ultra-wide, 12MP telephoto)</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Front Camera</th>
                                        <td>12MP TrueDepth camera</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Battery</th>
                                        <td>Up to 25 hours video playback</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Dimensions</th>
                                        <td>146.6 x 70.6 x 8.25 mm</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Weight</th>
                                        <td>187 grams</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Water Resistance</th>
                                        <td>IP68 (max depth of 6 meters up to 30 minutes)</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Operating System</th>
                                        <td>iOS 18</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="review-summary mb-4">
                                        <h4>Customer Reviews</h4>
                                        <div class="d-flex align-items-center">
                                            <h2 class="mb-0 me-2">4.5</h2>
                                            <div>
                                                <div>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star-half-alt text-warning"></i>
                                                </div>
                                                <small class="text-muted">Based on 124 reviews</small>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <a href="#" class="btn btn-primary">Write a Review</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="mb-4 p-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-1">James K.</h5>
                                            <div>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-secondary"></i>
                                            </div>
                                        </div>
                                        <small class="text-muted">Purchased 2 months ago</small>
                                        <p class="mt-2">This product exceeded my expectations. The performance is
                                            outstanding
                                            and the battery life is impressive. Highly recommended!</p>
                                    </div>

                                    <div class="mb-4 p-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-1">Sarah M.</h5>
                                            <div>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                                <i class="fas fa-star text-secondary"></i>
                                            </div>
                                        </div>
                                        <small class="text-muted">Purchased 3 weeks ago</small>
                                        <p class="mt-2">Great value for the price. The design is sleek and modern. My
                                            only
                                            complaint is that it runs a bit hot during intensive tasks.</p>
                                    </div>

                                    <div class="text-center">
                                        <a href="#" class="btn btn-outline-secondary">Load More Reviews</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Tab -->
                        <div class="tab-pane fade" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                            <h4>Frequently Asked Questions</h4>
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Does this product come with a warranty?
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Yes, this product comes with a standard 2-year manufacturer warranty that
                                            covers defects in materials and workmanship.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            Is international shipping available?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            We currently ship to over 50 countries worldwide. Shipping costs and
                                            delivery times vary by location. Please check our shipping policy for more
                                            details.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree">
                                            What is your return policy?
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            We offer a 30-day money-back guarantee on all purchases. Items must be
                                            returned in their original packaging and in like-new condition to qualify
                                            for a full refund.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                            aria-expanded="false" aria-controls="collapseFour">
                                            Do you offer installment payment options?
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Yes, we offer installment payment options for up to 12 months with select
                                            credit cards.
                                            You can also use our Buy Now Pay Later partners. Please check our payment
                                            options during checkout.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">You May Also Like</h3>
                    <div class="row">
                        <div class="col-6 col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="iPhone 16">
                                <div class="card-body">
                                    <h5 class="card-title">iPhone 16</h5>
                                    <p class="card-text text-success">₱55,990.00</p>
                                    <button class="btn btn-sm btn-outline-primary">View Details</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="iPhone 16 Pro Max">
                                <div class="card-body">
                                    <h5 class="card-title">iPhone 16 Pro Max</h5>
                                    <p class="card-text text-success">₱75,990.00</p>
                                    <button class="btn btn-sm btn-outline-primary">View Details</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="https://placehold.co/300x300" class="card-img-top" alt="AirPods Pro 2">
                                <div class="card-body">
                                    <h5 class="card-title">AirPods Pro 2</h5>
                                    <p class="card-text text-success">₱14,990.00</p>
                                    <button class="btn btn-sm btn-outline-primary">View Details</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="https://placehold.co/300x300" class="card-img-top"
                                    alt="Apple Watch Series 10">
                                <div class="card-body">
                                    <h5 class="card-title">Apple Watch Series 10</h5>
                                    <p class="card-text text-success">₱24,990.00</p>
                                    <button class="btn btn-sm btn-outline-primary">View Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Scripts -->
    <script>
        // Quantity Selector
        document.getElementById('decreaseQty').addEventListener('click', function () {
            let qtyInput = document.getElementById('quantity');
            let currentQty = parseInt(qtyInput.value);
            if (currentQty > 1) {
                qtyInput.value = currentQty - 1;
            }
        });

        document.getElementById('increaseQty').addEventListener('click', function () {
            let qtyInput = document.getElementById('quantity');
            let currentQty = parseInt(qtyInput.value);
            qtyInput.value = currentQty + 1;
        });

        // Thumbnail Images
        document.querySelectorAll('.thumbnail').forEach(img => {
            img.addEventListener('click', function () {
                document.querySelectorAll('.thumbnail-image').forEach(thumb => {
                    thumb.classList.remove('active');
                });
                this.parentElement.classList.add('active');
                document.getElementById('mainProductImage').src = this.src;
            });
        });

        // Color Options
        document.querySelectorAll('.color-option').forEach(option => {
            option.addEventListener('click', function () {
                document.querySelectorAll('.color-option').forEach(opt => {
                    opt.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Storage Options
        document.querySelectorAll('.storage-options .btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.storage-options .btn').forEach(b => {
                    b.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Add to Cart Button
        document.getElementById('addToCartBtn').addEventListener('click', function () {
            let cartCount = document.getElementById('cart-count');
            cartCount.textContent = parseInt(cartCount.textContent) + 1;
            alert('Product added to cart!');
        });
    </script>
</body>

</html>