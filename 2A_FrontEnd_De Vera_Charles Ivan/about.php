<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Kushy Gadget Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="design.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        /* Animation styles */
        .fade-in {
            opacity: 0;
            transition: opacity 0.6s ease-in;
        }

        .fade-in.visible {
            opacity: 1;
        }

        .slide-in-left {
            transform: translateX(-50px);
            opacity: 0;
            transition: all 0.6s ease-out;
        }

        .slide-in-right {
            transform: translateX(50px);
            opacity: 0;
            transition: all 0.6s ease-out;
        }

        .slide-in-up {
            transform: translateY(50px);
            opacity: 0;
            transition: all 0.6s ease-out;
        }

        .slide-in-left.visible,
        .slide-in-right.visible,
        .slide-in-up.visible {
            transform: translateX(0) translateY(0);
            opacity: 1;
        }

        /* Enhanced timeline styling */
        .timeline {
            position: relative;
        }

        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background-color: var(--primary);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
            z-index: 1;
        }

        .timeline-container {
            position: relative;
            width: 50%;
            padding: 10px 40px;
            z-index: 2;
        }

        .timeline-container.left {
            left: 0;
        }

        .timeline-container.right {
            left: 50%;
        }

        .timeline-content {
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: transform 0.3s ease;
        }

        .timeline-content:hover {
            transform: translateY(-5px);
        }

        .timeline-container.left .timeline-content::after {
            content: '';
            position: absolute;
            top: 20px;
            right: -15px;
            width: 30px;
            height: 30px;
            background-color: var(--primary);
            border-radius: 50%;
            z-index: 2;
        }

        .timeline-container.right .timeline-content::after {
            content: '';
            position: absolute;
            top: 20px;
            left: -15px;
            width: 30px;
            height: 30px;
            background-color: var(--primary);
            border-radius: 50%;
            z-index: 2;
        }

        .timeline-year {
            display: inline-block;
            padding: 5px 15px;
            background-color: var(--primary);
            color: white;
            border-radius: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Team member hover effect */
        .team-member {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
            padding: 20px;
            background-color: white;
        }

        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Value card hover effect */
        .value-card {
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .value-card i {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--primary);
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
                            <li><a class="dropdown-item" href="phones.php">Phones</a></li>
                            <li><a class="dropdown-item" href="laptops.php">Laptops</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="cart.php" class="nav-link me-3 position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge rounded-pill badge-cart">0</span>
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

    <!-- Hero Section - Fixed duplicate h1 -->
    <div class="about-hero">
        <div class="container">
            <h1 class="animate__animated animate__fadeIn">About Kushy Gadget Hub</h1>
            <p class="lead mb-4 animate__animated animate__fadeIn animate__delay-1s">The ultimate destination for
                premium tech products and accessories</p>
        </div>
    </div>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0 slide-in-left">
                    <h2>Our Story</h2>
                    <p>Founded in 2018, Kushy Gadget Hub started as a small online store with a mission to provide
                        high-quality tech products at affordable prices. What began as a passion project by a group of
                        tech enthusiasts has now grown into one of the most trusted electronics retailers in the
                        country.</p>
                    <p>Our journey hasn't always been smooth sailing, but our commitment to customer satisfaction and
                        product excellence has never wavered. We've built our reputation on transparency, reliability,
                        and a genuine love for technology.</p>
                    <p>Today, we serve thousands of customers nationwide and continue to expand our product offerings
                        while maintaining the personalized service that set us apart from the beginning.</p>
                    <a href="contact.php" class="btn btn-primary mt-3">Get in Touch</a>
                </div>
                <div class="col-lg-6 slide-in-right">
                    <img src="images/2.jpg" alt="Our Store" class="img-fluid about-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values Section -->
    <section class="values-section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5 slide-in-up">
                <h2 class="section-header mx-auto">Our Core Values</h2>
                <p class="lead">Principles that guide everything we do</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4 fade-in">
                    <div class="value-card bg-white">
                        <i class="fas fa-award"></i>
                        <h4>Quality Assurance</h4>
                        <p>We rigorously test all products to ensure they meet our high standards before they reach our
                            customers.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 fade-in">
                    <div class="value-card bg-white">
                        <i class="fas fa-handshake"></i>
                        <h4>Customer First</h4>
                        <p>Your satisfaction is our priority. We go above and beyond to ensure an exceptional shopping
                            experience.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 fade-in">
                    <div class="value-card bg-white">
                        <i class="fas fa-leaf"></i>
                        <h4>Sustainability</h4>
                        <p>We're committed to reducing our environmental impact through eco-friendly packaging and
                            responsible sourcing.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 fade-in">
                    <div class="stat-item">
                        <div class="stat-number animate__animated animate__fadeIn">5,000+</div>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 fade-in">
                    <div class="stat-item">
                        <div class="stat-number animate__animated animate__fadeIn animate__delay-1s">500+</div>
                        <div class="stat-label">Products</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 fade-in">
                    <div class="stat-item">
                        <div class="stat-number animate__animated animate__fadeIn animate__delay-2s">15+</div>
                        <div class="stat-label">Brand Partners</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 fade-in">
                    <div class="stat-item">
                        <div class="stat-number animate__animated animate__fadeIn animate__delay-3s">98%</div>
                        <div class="stat-label">Satisfaction Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Team Section -->
    <section class="team-section py-5">
        <div class="container">
            <div class="text-center mb-5 slide-in-up">
                <h2 class="section-header mx-auto">Meet Our Team</h2>
                <p class="lead">The passionate people behind Kushy Gadget Hub</p>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 fade-in">
                    <div class="team-member">
                        <img src="/api/placeholder/180/180" alt="Sarah Johnson">
                        <h5>Sarah Johnson</h5>
                        <div class="position">Founder & CEO</div>
                        <p>Tech visionary with 15+ years of experience in the electronics industry.</p>
                        <div class="team-social">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 fade-in">
                    <div class="team-member">
                        <img src="/api/placeholder/180/180" alt="Michael Chen">
                        <h5>Michael Chen</h5>
                        <div class="position">CTO</div>
                        <p>Former software engineer with a passion for exploring cutting-edge technology.</p>
                        <div class="team-social">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-github"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 fade-in">
                    <div class="team-member">
                        <img src="/api/placeholder/180/180" alt="Priya Patel">
                        <h5>Priya Patel</h5>
                        <div class="position">Marketing Director</div>
                        <p>Creative strategist with a knack for building meaningful customer relationships.</p>
                        <div class="team-social">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 fade-in">
                    <div class="team-member">
                        <img src="/api/placeholder/180/180" alt="David Rodriguez">
                        <h5>David Rodriguez</h5>
                        <div class="position">Customer Service Manager</div>
                        <p>Dedicated to ensuring every customer has an exceptional experience with our products.</p>
                        <div class="team-social">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Timeline - Enhanced styling -->
    <section class="timeline-section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5 slide-in-up">
                <h2 class="section-header mx-auto">Our Journey</h2>
                <p class="lead">How we evolved over the years</p>
            </div>
            <div class="timeline">
                <div class="timeline-container left fade-in">
                    <div class="timeline-content">
                        <div class="timeline-year">2018</div>
                        <h4>The Beginning</h4>
                        <p>Kushy Gadget Hub was founded as a small online store operating out of a garage.</p>
                    </div>
                </div>
                <div class="timeline-container right fade-in">
                    <div class="timeline-content">
                        <div class="timeline-year">2019</div>
                        <h4>First Physical Store</h4>
                        <p>We opened our first brick-and-mortar location in the downtown shopping district.</p>
                    </div>
                </div>
                <div class="timeline-container left fade-in">
                    <div class="timeline-content">
                        <div class="timeline-year">2020</div>
                        <h4>Expanding Product Lines</h4>
                        <p>Added premium laptops and smart home products to our inventory.</p>
                    </div>
                </div>
                <div class="timeline-container right fade-in">
                    <div class="timeline-content">
                        <div class="timeline-year">2022</div>
                        <h4>National Recognition</h4>
                        <p>Named "Best Tech Retailer" by Consumer Tech Magazine.</p>
                    </div>
                </div>
                <div class="timeline-container left fade-in">
                    <div class="timeline-content">
                        <div class="timeline-year">2024</div>
                        <h4>International Expansion</h4>
                        <p>Launched shipping to international customers and partnered with global brands.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials-section py-5">
        <div class="container">
            <div class="text-center mb-5 slide-in-up">
                <h2 class="section-header mx-auto">What Our Customers Say</h2>
                <p class="lead">Feedback from our valued customers</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4 fade-in">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text">"The customer service at Kushy Gadget Hub is unmatched. They went above
                                and beyond to help me find the perfect laptop for my needs, and even followed up after
                                my purchase to ensure I was satisfied."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="/api/placeholder/50/50" alt="Customer" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Jennifer K.</h6>
                                    <small class="text-muted">Loyal Customer since 2019</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 fade-in">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text">"I've been shopping at Kushy Gadget Hub for years now, and I've never
                                been disappointed. Their products are high-quality, competitively priced, and they
                                always have the latest tech available."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="/api/placeholder/50/50" alt="Customer" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Marcus T.</h6>
                                    <small class="text-muted">Tech Enthusiast</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 fade-in">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star-half-alt text-warning"></i>
                            </div>
                            <p class="card-text">"As a small business owner, I appreciate the personalized attention I
                                receive from Kushy Gadget Hub. They understand my technology needs and have helped me
                                set up efficient systems that have saved me time and money."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="/api/placeholder/50/50" alt="Customer" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Rebecca L.</h6>
                                    <small class="text-muted">Business Customer</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5 slide-in-up">
                <h2 class="section-header mx-auto">Frequently Asked Questions</h2>
                <p class="lead">Get answers to common questions about Kushy Gadget Hub</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 fade-in">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Do you offer international shipping?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, we ship to most countries worldwide. Shipping rates and delivery times vary
                                    based on your location. You can check the shipping options available to you during
                                    checkout.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    What is your warranty policy?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    All products come with a minimum 1-year warranty against manufacturing defects. Some
                                    premium products offer extended warranty options. Details about the warranty for
                                    each product can be found on the product page.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Do you have a physical store?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, we currently have three retail locations. Our flagship store is in downtown
                                    Metro City, with additional locations in Westside Mall and Eastview Shopping Center.
                                    Visit our Contact page for store hours and directions.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    What is your return policy?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We offer a 30-day return policy for most products. Items must be returned in their
                                    original packaging with all accessories included. Some products may have special
                                    return conditions, which will be noted on the product page.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section py-5" style="background-color: var(--bg-dark);">
        <div class="container text-center slide-in-up">
            <h2 class="text-light mb-4">Ready to Experience Kushy Gadget Hub?</h2>
            <p class="text-light mb-4">Explore our wide range of premium tech products and accessories.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="products.php" class="btn btn-primary animate__animated animate__pulse animate__infinite">Shop
                    Now</a>
                <a href="contact.php" class="btn btn-secondary">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="mb-3">About Kushy Gadget Hub</h5>
                    <p>Your trusted destination for premium tech products and accessories. Quality, innovation, and
                        exceptional service since 2018.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="products.php" class="text-white text-decoration-none">Products</a>
                        </li>
                        <li class="mb-2"><a href="about.php" class="text-white text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-white text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">Categories</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Smartphones</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Laptops</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Accessories</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Smart Home</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5 class="mb-3">Newsletter</h5>
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
                <div class="col-md-6 text-center<div class=" col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <a href="#" class="text-white text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-white text-decoration-none me-3">Terms of Service</a>
                    <a href="#" class="text-white text-decoration-none">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Animation Script -->
    <script>
        // Intersection Observer to trigger animations when elements scroll into view
        document.addEventListener('DOMContentLoaded', function () {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });

            // Observe all elements with animation classes
            const animatedElements = document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right, .slide-in-up');
            animatedElements.forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>

</html>