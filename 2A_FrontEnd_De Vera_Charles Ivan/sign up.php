<?php
require_once 'conn.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Log the received POST data
    error_log("Received POST data: " . print_r($_POST, true));
    
    header('Content-Type: application/json');
    
    try {
        // Escape inputs to prevent SQL injection
        $email = escapeString($_POST['email']);
        $passwordRaw = $_POST['password'];
        $passwordConfirm = $_POST['confirmPassword'];
        $firstName = escapeString($_POST['firstName']);
        $lastName = escapeString($_POST['lastName']);
        $phone = escapeString($_POST['phone']);
        $birthdate = escapeString($_POST['birthdate']);
        $categories = isset($_POST['categories']) ? $_POST['categories'] : [];

        // Initialize response
        $response = ['status' => '', 'message' => ''];

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response = ['status' => 'error', 'message' => 'Invalid email format!'];
        } else if ($passwordRaw !== $passwordConfirm) {
            $response = ['status' => 'error', 'message' => 'Passwords do not match!'];
        } else {
            // Hash the password
            $password = password_hash($passwordRaw, PASSWORD_DEFAULT);

            // Check if email already exists
            $checkEmail = executeQuery("SELECT email FROM users WHERE email = '$email'");
            if ($checkEmail->num_rows > 0) {
                $response = ['status' => 'error', 'message' => 'Email already exists!'];
            } else {
                // Insert new user with type 'customer'
                $sql = "INSERT INTO users (email, password, first_name, last_name, phone, birthdate, type) 
                        VALUES ('$email', '$password', '$firstName', '$lastName', '$phone', '$birthdate', 'customer')";
                
                if (executeNonQuery($sql)) {
                    $user_id = $conn->insert_id;
                    
                    // Save preferences if any
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            $category = escapeString($category);
                            $pref_sql = "INSERT INTO user_preferences (user_id, category) VALUES ('$user_id', '$category')";
                            executeNonQuery($pref_sql);
                        }
                    }
                    
                    $response = ['status' => 'success', 'message' => 'Registration successful! You can now login.'];
                } else {
                    error_log("Database error: " . $conn->error);
                    $response = ['status' => 'error', 'message' => 'Error during registration. Please try again.'];
                }
            }
        }
    } catch (Exception $e) {
        error_log("Exception occurred: " . $e->getMessage());
        $response = ['status' => 'error', 'message' => 'An unexpected error occurred. Please try again.'];
    }
    
    // Return JSON response and exit
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sign Up - Kushy Gadget Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <link rel="stylesheet" href="css/sign_up.css" />
    <style>
        .confirmation-message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: none;
        }
        
        .confirmation-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: block;
        }
        
        .confirmation-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: block;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <i class="fas fa-mobile-alt me-2"></i> KGH HUB
            </a>
        </div>
    </nav>

    <!-- Signup Container -->
    <div class="signup-container">
        <div class="container">
            <div class="row justify-content-center align-items-center" style="min-height: 100vh">
                <div class="col-md-8 col-lg-6">
                    <div class="signup-card">
                        <div class="signup-header">
                            <h3>Create Your Account</h3>
                            <p class="mb-0">Join the Kushy Gadget Hub community</p>
                        </div>
                        <div class="signup-body">
                            <!-- Confirmation Message -->
                            <?php if (isset($response) && $response['status']): ?>
                                <div class="confirmation-message <?php echo $response['status']; ?>">
                                    <?php echo $response['message']; ?>
                                    <?php if ($response['status'] === 'success'): ?>
                                        <a href="login_page.php" class="btn btn-sm btn-success ms-3">Go to Login</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Loader -->
                            <div id="loader" class="loader" style="display: none;"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Creating your account...</p></div>
                            
                            <!-- Progress Steps -->
                            <div class="signup-progress mb-4">
                                <div class="progress-step"><div class="step-circle active">1</div><div class="step-title">Account</div></div>
                                <div class="progress-step"><div class="step-circle">2</div><div class="step-title">Personal</div></div>
                                <div class="progress-step"><div class="step-circle">3</div><div class="step-title">Preferences</div></div>
                            </div>
                            
                            <!-- Social Signup -->
                            <div class="social-signup mb-3">
                                <button id="googleSignIn" class="social-btn google"><i class="fab fa-google"></i></button>
                                <button id="facebookSignIn" class="social-btn fb"><i class="fab fa-facebook-f"></i></button>
                            </div>
                            <div class="divider mb-4"><span>OR SIGN UP WITH EMAIL</span></div>

                            <!-- Signup Form -->
                            <form method="POST" id="signupForm" novalidate>
                                <!-- Step 1: Account Information -->
                                <div class="step-content active" id="step1">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-group"><span class="input-group-text"><i class="fas fa-envelope"></i></span><input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required/></div>
                                        <div class="form-text">We'll never share your email with anyone else.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group"><span class="input-group-text"><i class="fas fa-lock"></i></span><input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required/><span class="input-group-text toggle-password" style="cursor: pointer;" title="Show/Hide Password"><i class="fas fa-eye-slash"></i></span></div>
                                        <div class="password-criteria mt-2">
                                            <p class="mb-2 fw-bold">Password must contain:</p>
                                            <ul>
                                                <li id="length" class="invalid">At least 8 characters</li>
                                                <li id="uppercase" class="invalid">At least one uppercase letter</li>
                                                <li id="lowercase" class="invalid">At least one lowercase letter</li>
                                                <li id="number" class="invalid">At least one number</li>
                                                <li id="special" class="invalid">At least one special character</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                                        <div class="input-group"><span class="input-group-text"><i class="fas fa-lock"></i></span><input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required/></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-4">
                                        <a href="login_page.php" class="btn btn-link text-decoration-none">Already have an account?</a>
                                        <button type="button" class="btn btn-primary next-step" data-next="step2">Next Step</button>
                                    </div>
                                </div>

                                <!-- Step 2: Personal Information -->
                                <div class="step-content" id="step2">
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <div class="input-group"><span class="input-group-text"><i class="fas fa-user"></i></span><input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name" required /></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastName" class="form-label">Last Name</label>
                                            <div class="input-group"><span class="input-group-text"><i class="fas fa-user"></i></span><input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name" required /></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <div class="input-group"><span class="input-group-text"><i class="fas fa-phone"></i></span><input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required /></div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="birthdate" class="form-label">Date of Birth</label>
                                        <div class="input-group"><span class="input-group-text"><i class="fas fa-calendar"></i></span><input type="date" class="form-control" id="birthdate" name="birthdate" required /></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary prev-step" data-prev="step1">Previous</button>
                                        <button type="button" class="btn btn-primary next-step" data-next="step3">Next Step</button>
                                    </div>
                                </div>

                                <!-- Step 3: Preferences -->
                                <div class="step-content" id="step3">
                                    <div class="mb-4">
                                        <label class="form-label">Preferred Product Categories</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="smartphones" name="categories[]" value="Smartphones"/><label class="form-check-label" for="smartphones">Smartphones</label></div>
                                                <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="laptops" name="categories[]" value="Laptops & Computers"/><label class="form-check-label" for="laptops">Laptops & Computers</label></div>
                                                <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="audio" name="categories[]" value="Audio Devices"/><label class="form-check-label" for="audio">Audio Devices</label></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="wearables" name="categories[]" value="Wearables"/><label class="form-check-label" for="wearables">Wearables</label></div>
                                                <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="accessories" name="categories[]" value="Accessories"/><label class="form-check-label" for="accessories">Accessories</label></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary prev-step" data-prev="step2">Previous</button>
                                        <button type="submit" class="btn btn-success">Create Account</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const signupForm = document.getElementById("signupForm");
            const email = document.getElementById("email");
            const password = document.getElementById("password");
            const confirmPassword = document.getElementById("confirmPassword");
            const firstName = document.getElementById("firstName");
            const lastName = document.getElementById("lastName");
            const phone = document.getElementById("phone");
            const birthdate = document.getElementById("birthdate");
            const toggleButtons = document.querySelectorAll(".toggle-password");

            toggleButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const input = this.previousElementSibling;
                    const icon = this.querySelector("i");
                    if (input.type === "password") {
                        input.type = "text";
                        icon.classList.remove("fa-eye-slash");
                        icon.classList.add("fa-eye");
                    } else {
                        input.type = "password";
                        icon.classList.remove("fa-eye");
                        icon.classList.add("fa-eye-slash");
                    }
                });
            });

            const criteria = {
                length: { regex: /.{8,}/, element: document.getElementById("length") },
                uppercase: { regex: /[A-Z]/, element: document.getElementById("uppercase") },
                lowercase: { regex: /[a-z]/, element: document.getElementById("lowercase") },
                number: { regex: /[0-9]/, element: document.getElementById("number") },
                special: { regex: /[!@#$%^&*]/, element: document.getElementById("special") }
            };

            if (password) {
                password.addEventListener("input", function () {
                    const val = this.value;
                    let allValid = true;
                    for (const key in criteria) {
                        const { regex, element } = criteria[key];
                        const valid = regex.test(val);
                        element.classList.toggle("valid", valid);
                        element.classList.toggle("invalid", !valid);
                        if (!valid) allValid = false;
                    }
                    this.classList.toggle("is-valid", allValid);
                    this.classList.toggle("is-invalid", !allValid);
                });
            }

            if (confirmPassword) {
                confirmPassword.addEventListener("input", function () {
                    const match = this.value === password.value && this.value.length > 0;
                    this.classList.toggle("is-valid", match);
                    this.classList.toggle("is-invalid", !match);
                });
            }

            const steps = ["step1", "step2", "step3"];
            let currentStep = 0;

            function showStep(index) {
                document.querySelectorAll(".step-content").forEach(step => step.classList.remove("active"));
                const activeStep = document.getElementById(steps[index]);
                if (activeStep) activeStep.classList.add("active");
                document.querySelectorAll(".progress-step").forEach((stepEl, i) => {
                    const circle = stepEl.querySelector(".step-circle");
                    if (!circle) return;
                    circle.classList.remove("active", "completed");
                    if (i < index) circle.classList.add("completed");
                    else if (i === index) circle.classList.add("active");
                });
            }

            function validateStep(index) {
                console.log("Validating step:", index);
                switch (index) {
                    case 0:
                        const email = document.getElementById("email").value.trim();
                        const password = document.getElementById("password").value;
                        const confirmPassword = document.getElementById("confirmPassword").value;
                        
                        console.log("Validating email:", email);
                        console.log("Validating password:", password);
                        console.log("Validating confirm password:", confirmPassword);

                        if (!email || !password || !confirmPassword) {
                            showMessage("Please fill all required fields in Account Information.", "error");
                            return false;
                        }
                        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                            showMessage("Please enter a valid email address.", "error");
                            return false;
                        }
                        for (const key in criteria) {
                            if (!criteria[key].regex.test(password)) {
                                showMessage("Password does not meet all required criteria.", "error");
                                return false;
                            }
                        }
                        if (password !== confirmPassword) {
                            showMessage("Passwords do not match.", "error");
                            return false;
                        }
                        return true;
                        break;
                    case 1:
                        const firstName = document.getElementById("firstName").value.trim();
                        const lastName = document.getElementById("lastName").value.trim();
                        const phone = document.getElementById("phone").value.trim();
                        const birthdate = document.getElementById("birthdate").value.trim();
                        
                        console.log("Validating firstName:", firstName);
                        console.log("Validating lastName:", lastName);
                        console.log("Validating phone:", phone);
                        console.log("Validating birthdate:", birthdate);

                        if (!firstName || !lastName || !phone || !birthdate) {
                            showMessage("Please fill all required fields in Personal Information.", "error");
                            return false;
                        }
                        if (!/^\d{7,15}$/.test(phone)) {
                            showMessage("Please enter a valid phone number (7-15 digits).", "error");
                            return false;
                        }
                        return true;
                        break;
                    case 2:
                        // No validation needed for preferences as they are optional
                        return true;
                        break;
                    default:
                        return false;
                }
            }

            function showMessage(message, type) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `confirmation-message ${type}`;
                messageDiv.textContent = message;
                
                // Insert at the top of the signup-body
                const signupBody = document.querySelector('.signup-body');
                const existingMessage = signupBody.querySelector('.confirmation-message');
                
                if (existingMessage) {
                    signupBody.replaceChild(messageDiv, existingMessage);
                } else {
                    signupBody.insertBefore(messageDiv, signupBody.firstChild);
                }
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    messageDiv.remove();
                }, 5000);
            }

            document.querySelectorAll(".next-step").forEach(button => {
                button.addEventListener("click", () => {
                    if (validateStep(currentStep)) {
                        if (currentStep < steps.length - 1) {
                            currentStep++;
                            showStep(currentStep);
                        }
                    }
                });
            });

            document.querySelectorAll(".prev-step").forEach(button => {
                button.addEventListener("click", () => {
                    if (currentStep > 0) {
                        currentStep--;
                        showStep(currentStep);
                    }
                });
            });

            signupForm.addEventListener("submit", function (e) {
                e.preventDefault();
                console.log("Form submission started");
                
                if (!validateStep(currentStep)) {
                    console.log("Step validation failed");
                    return;
                }
                
                const formData = new FormData(this);
                const loader = document.getElementById("loader");
                const createAccountBtn = document.querySelector('button[type="submit"]');
                
                // Debug log form data
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }
                
                // Show loader and disable submit button
                if (loader) loader.style.display = "block";
                if (createAccountBtn) createAccountBtn.disabled = true;

                // Add validation for all required fields
                const requiredFields = ['email', 'password', 'confirmPassword', 'firstName', 'lastName', 'phone', 'birthdate'];
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!formData.get(field)) {
                        console.log(`Missing required field: ${field}`);
                        showMessage(`Please fill in the ${field} field.`, "error");
                        isValid = false;
                    }
                });

                if (!isValid) {
                    console.log("Form validation failed");
                    if (loader) loader.style.display = "none";
                    if (createAccountBtn) createAccountBtn.disabled = false;
                    return;
                }

                console.log("Sending form data to server...");
                fetch(window.location.href, {
                    method: "POST",
                    body: formData
                })
                .then(response => {
                    console.log("Server response received:", response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Server data:", data);
                    // Hide loader
                    if (loader) loader.style.display = "none";

                    // Show message
                    showMessage(data.message, data.status);

                    if (data.status === "success") {
                        // Disable form inputs
                        Array.from(signupForm.elements).forEach(element => element.disabled = true);
                        
                        // Redirect to login page after 2 seconds
                        setTimeout(() => {
                            window.location.href = "login_page.php";
                        }, 2000);
                    } else {
                        // Re-enable submit button for retry
                        if (createAccountBtn) createAccountBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Hide loader
                    if (loader) loader.style.display = "none";
                    
                    // Show error message
                    showMessage("An error occurred while creating your account. Please try again.", "error");
                    
                    // Re-enable submit button
                    if (createAccountBtn) createAccountBtn.disabled = false;
                });
            });

            // Add this at the end of your DOMContentLoaded event listener
            console.log("Signup form initialized");

            showStep(currentStep);
        });
    </script>
</body>
</html>