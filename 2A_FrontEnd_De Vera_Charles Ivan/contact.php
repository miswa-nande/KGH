<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Kushy Gadget Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="design.css">
    <style>
        /* Add smooth scrolling behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Animation for fade-in elements */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        /* Contact info card hover effect */
        .contact-info-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .contact-info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Icon pulse animation */
        .contact-info-card i {
            transition: transform 0.3s ease;
        }

        .contact-info-card:hover i {
            transform: scale(1.2);
            color: var(--primary);
        }

        /* Button hover animation */
        .btn {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* FAQ item transition */
        .faq-item h5 {
            transition: color 0.3s ease;
        }

        .faq-item h5:hover {
            color: var(--primary);
        }

        .faq-item .fas {
            transition: transform 0.3s ease;
        }

        .faq-item h5[aria-expanded="true"] .fas {
            transform: rotate(180deg);
        }

        /* Form input focus animation */
        .form-control,
        .form-select {
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.25);
        }

        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            text-align: center;
            line-height: 40px;
            z-index: 99;
            transition: background-color 0.3s, opacity 0.3s;
            opacity: 0;
        }

        .back-to-top.show {
            opacity: 1;
        }

        .back-to-top:hover {
            background-color: var(--primary-dark);
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="home.html">
                <i class="fas fa-mobile-alt me-2"></i>KGH HUB
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="phones.html">Smartphones</a></li>
                            <li><a class="dropdown-item" href="laptops.html">Laptops</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contact.html">Contact</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="cart.html" class="nav-link me-3 position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge rounded-pill badge-cart">3</span>
                    </a>
                    <a href="user account.html" class="nav-link me-3">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="login_page.html" class="btn btn-sm btn-primary">
                        Login / Register
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="container">
            <h1>Contact Us</h1>
            <p class="lead mb-0">We'd love to hear from you</p>
        </div>
    </div>

    <!-- Quick Contact Options -->
    <section class="py-4">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <p class="mb-3">Need immediate assistance? Choose the option that works best for you:</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="#contactForm" class="btn btn-primary">
                            <i class="fas fa-envelope me-2"></i> Send a Message
                        </a>
                        <a href="tel:5551234567" class="btn btn-outline-primary">
                            <i class="fas fa-phone-alt me-2"></i> Call Us
                        </a>
                        <a href="#storeLocations" class="btn btn-outline-primary">
                            <i class="fas fa-map-marker-alt me-2"></i> Visit a Store
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="contact-info-card text-center">
                        <i class="fas fa-map-marker-alt"></i>
                        <h4>Visit Us</h4>
                        <p class="mb-0">123 Tech Lane, Metro City<br>
                            Downtown District, 10101</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="contact-info-card text-center">
                        <i class="fas fa-phone-alt"></i>
                        <h4>Call Us</h4>
                        <p class="mb-0">Customer Support: (555) 123-4567<br>
                            Sales Inquiries: (555) 987-6543</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info-card text-center">
                        <i class="fas fa-envelope"></i>
                        <h4>Email Us</h4>
                        <p class="mb-0">support@kushygadgethub.com<br>
                            sales@kushygadgethub.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section id="contactForm" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h2 class="section-header fade-in">Send Us a Message</h2>
                    <p class="mb-4 fade-in">Have a question or feedback? Fill out the form below and we'll get back to
                        you as
                        soon as possible.</p>

                    <form id="contactFormElement" class="fade-in">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone">
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <select class="form-select" id="subject" required>
                                <option value="" selected disabled>Select a subject</option>
                                <option value="customer-support">Customer Support</option>
                                <option value="product-inquiry">Product Inquiry</option>
                                <option value="feedback">Feedback</option>
                                <option value="partnership">Partnership Opportunity</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5" required></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="newsletter">
                            <label class="form-check-label" for="newsletter">Subscribe to our newsletter for updates and
                                promotions</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>

                <div class="col-lg-5">
                    <div class="support-card mb-4 fade-in">
                        <h3>Customer Support Hours</h3>
                        <p>Our dedicated support team is available to assist you during the following hours:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Monday - Friday:</strong> 9:00 AM - 8:00 PM EST</li>
                            <li class="mb-2"><strong>Saturday:</strong> 10:00 AM - 6:00 PM EST</li>
                            <li class="mb-2"><strong>Sunday:</strong> Closed</li>
                        </ul>
                        <p class="mb-0">For urgent inquiries outside of business hours, please email us at
                            support@kushygadgethub.com, and we'll respond as soon as possible.</p>
                    </div>

                    <div class="support-card fade-in">
                        <h3>Connect With Us</h3>
                        <p>Follow us on social media for the latest product updates, tech tips, and exclusive
                            promotions.</p>
                        <div class="social-icons mt-3">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-header text-center mb-5 fade-in">Frequently Asked Contact Questions</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="faq-list fade-in">
                        <div class="faq-item">
                            <h5 data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true">
                                How quickly can I expect a response after submitting a contact form? <i
                                    class="fas fa-chevron-down"></i>
                            </h5>
                            <div id="faq1" class="collapse show faq-content">
                                <p>We strive to respond to all inquiries within 24 hours during business days. For
                                    urgent matters, we recommend calling our customer support line for immediate
                                    assistance.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <h5 class="collapsed" data-bs-toggle="collapse" data-bs-target="#faq2"
                                aria-expanded="false">
                                Can I schedule an in-store consultation with a tech specialist? <i
                                    class="fas fa-chevron-down"></i>
                            </h5>
                            <div id="faq2" class="collapse faq-content">
                                <p>Yes, you can schedule a one-on-one consultation with our tech specialists at any of
                                    our store locations. Simply fill out the contact form specifying your preferred
                                    date, time, and location, or call the store directly to book an appointment.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <h5 class="collapsed" data-bs-toggle="collapse" data-bs-target="#faq3"
                                aria-expanded="false">
                                How do I check the status of my repair or order? <i class="fas fa-chevron-down"></i>
                            </h5>
                            <div id="faq3" class="collapse faq-content">
                                <p>You can check the status of your repair or order by logging into your account on our
                                    website, or by contacting our customer support team with your order/repair reference
                                    number.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <h5 class="collapsed" data-bs-toggle="collapse" data-bs-target="#faq4"
                                aria-expanded="false">
                                Do you offer technical support over the phone? <i class="fas fa-chevron-down"></i>
                            </h5>
                            <div id="faq4" class="collapse faq-content">
                                <p>Yes, our technical support team is available over the phone during our business
                                    hours. For complex issues, we may schedule a follow-up or recommend bringing your
                                    device to one of our store locations for hands-on assistance.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <h5 class="collapsed" data-bs-toggle="collapse" data-bs-target="#faq5"
                                aria-expanded="false">
                                How can I apply for a job at Kushy Gadget Hub? <i class="fas fa-chevron-down"></i>
                            </h5>
                            <div id="faq5" class="collapse faq-content">
                                <p>You can view our current job openings and apply through the Careers section of our
                                    website. Alternatively, you can email your resume and cover letter to
                                    careers@kushygadgethub.com with the position you're interested in.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Store Locations -->
    <section id="storeLocations" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-header text-center mb-5 fade-in">Our Store Locations</h2>
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card h-100 fade-in">
                        <img src="/api/placeholder/400/200" class="card-img-top" alt="Downtown Store">
                        <div class="card-body">
                            <h5 class="card-title">Downtown Flagship Store</h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i> 123 Tech Lane, Metro City<br>
                                <i class="fas fa-phone-alt me-2 text-primary"></i> (555) 123-4567<br>
                                <i class="fas fa-clock me-2 text-primary"></i> Mon-Sat: 10AM-9PM, Sun: 11AM-6PM
                            </p>
                            <a href="#" class="btn btn-outline-primary">Get Directions</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100 fade-in">
                        <img src="/api/placeholder/400/200" class="card-img-top" alt="Westside Mall Store">
                        <div class="card-body">
                            <h5 class="card-title">Westside Mall Location</h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i> Westside Mall, 456 Shop Ave<br>
                                <i class="fas fa-phone-alt me-2 text-primary"></i> (555) 234-5678<br>
                                <i class="fas fa-clock me-2 text-primary"></i> Mon-Sat: 10AM-9PM, Sun: 12PM-6PM
                            </p>
                            <a href="#" class="btn btn-outline-primary">Get Directions</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100 fade-in">
                        <img src="/api/placeholder/400/200" class="card-img-top" alt="Eastview Store">
                        <div class="card-body">
                            <h5 class="card-title">Eastview Shopping Center</h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i> Eastview Mall, 789 Retail Dr<br>
                                <i class="fas fa-phone-alt me-2 text-primary"></i> (555) 345-6789<br>
                                <i class="fas fa-clock me-2 text-primary"></i> Mon-Sat: 10AM-8PM, Sun: 12PM-5PM
                            </p>
                            <a href="#" class="btn btn-outline-primary">Get Directions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-header text-center mb-5 fade-in">Find Us on the Map</h2>
            <div class="map-container fade-in">
                <!-- Placeholder for map - would be replaced with actual map implementation -->
                <img src="/api/placeholder/1200/450" alt="Map" class="img-fluid w-100 h-100 object-fit-cover">
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5" style="background-color: var(--bg-dark);">
        <div class="container text-center">
            <h2 class="text-light mb-4 fade-in">Need Immediate Assistance?</h2>
            <p class="text-light mb-4 fade-in">Our customer support team is just a phone call away.</p>
            <a href="tel:5551234567" class="btn btn-primary btn-lg fade-in">
                <i class="fas fa-phone-alt me-2"></i> Call Us Now
            </a>
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
                        <li class="mb-2"><a href="index.html" class="text-white text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="products.html" class="text-white text-decoration-none">Products</a>
                        </li>
                        <li class="mb-2"><a href="about.html" class="text-white text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="contact.html" class="text-white text-decoration-none">Contact</a></li>
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
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <a href="#" class="text-white text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-white text-decoration-none me-3">Terms of Service</a>
                    <a href="#" class="text-white text-decoration-none">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Contact Form Validation
        document.getElementById('contactFormElement').addEventListener('submit', function (event) {
            event.preventDefault();

            // Here you would typically handle form submission via AJAX
            // For demo purposes, we'll just show an alert

            alert('Thank you for your message! We will get back to you soon.');
            this.reset();
        });

        // Fade-in animation for elements
        document.addEventListener('DOMContentLoaded', function () {
            // Trigger fade-in animations with a small delay between elements
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 100 * index);
            });

            // Back to top button functionality
            const backToTopButton = document.querySelector('.back-to-top');

            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    if (!backToTopButton.classList.contains('show')) {
                        backToTopButton.classList.add('show');
                    }
                } else {
                    backToTopButton.classList.remove('show');
                }
            });

            backToTopButton.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>