<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Kushy Gadget Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="design.css">
    <style>
        /* Additional styling for forgot password page */
        .forgot-password-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .forgot-password-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('images/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            color: white;
            text-align: center;
            margin-bottom: 40px;
        }

        .form-section {
            padding: 60px 0;
            background-color: #f8f9fa;
            min-height: 60vh;
        }

        .form-floating {
            margin-bottom: 20px;
        }

        .btn-primary {
            padding: 12px 25px;
            font-weight: 600;
        }

        .icon-container {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .instructions-text {
            color: #6c757d;
            margin-bottom: 25px;
            text-align: center;
        }

        .success-message {
            display: none;
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            background-color: #d4edda;
            color: #155724;
            margin-bottom: 20px;
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
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="cart.html" class="nav-link me-3 position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge rounded-pill badge-cart">0</span>
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
    <div class="forgot-password-hero">
        <div class="container">
            <h1>Reset Your Password</h1>
            <p class="lead mb-0">We'll send you instructions to reset your password</p>
        </div>
    </div>

    <!-- Form Section -->
    <section class="form-section">
        <div class="container">
            <div class="forgot-password-container">
                <div class="text-center">
                    <div class="icon-container">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h2 class="mb-4">Forgot Your Password?</h2>
                    <p class="instructions-text">Enter your email address below and we'll send you a link to reset your
                        password.</p>
                </div>

                <div class="success-message" id="successMessage">
                    <i class="fas fa-check-circle me-2"></i>
                    Password reset instructions have been sent to your email address.
                </div>

                <form id="forgotPasswordForm">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="emailInput" placeholder="name@example.com"
                            required>
                        <label for="emailInput">Email address</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Send Reset Link</button>
                    </div>
                    <div class="text-center mt-4">
                        <p>Remembered your password? <a href="login_page.html">Sign in</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Form handling script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const forgotPasswordForm = document.getElementById('forgotPasswordForm');
            const successMessage = document.getElementById('successMessage');

            forgotPasswordForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Simulate form submission
                const emailInput = document.getElementById('emailInput');

                if (emailInput.value) {
                    // Show success message
                    successMessage.style.display = 'block';
                    forgotPasswordForm.style.display = 'none';

                    // In a real application, you would send a request to your server here
                    console.log('Password reset requested for:', emailInput.value);
                }
            });
        });
    </script>
</body>

</html>