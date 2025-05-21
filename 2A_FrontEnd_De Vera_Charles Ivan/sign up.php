<?php
require_once 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape inputs to prevent SQL injection
    $email = escapeString($_POST['email']);
    $passwordRaw = $_POST['password'];
    $passwordConfirm = $_POST['confirmPassword'];
    $firstName = escapeString($_POST['firstName']);
    $lastName = escapeString($_POST['lastName']);
    $phone = escapeString($_POST['phone']);
    $birthdate = escapeString($_POST['birthdate']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!');</script>";
    } else if ($passwordRaw !== $passwordConfirm) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Hash the password
        $password = password_hash($passwordRaw, PASSWORD_DEFAULT);

        // Check if email already exists
        $checkEmail = executeQuery("SELECT email FROM users WHERE email = '$email'");
        if ($checkEmail->num_rows > 0) {
            echo "<script>alert('Email already exists!');</script>";
        } else {
            // Insert new user with type 'customer'
            $sql = "INSERT INTO users (email, password, first_name, last_name, phone, birthdate, type) 
                    VALUES ('$email', '$password', '$firstName', '$lastName', '$phone', '$birthdate', 'customer')";
            
            if (executeNonQuery($sql)) {
                echo "<script>alert('Registration successful!'); window.location.href='login_page.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error during registration. Please try again.');</script>";
            }
        }
    }
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
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <i class="fas fa-mobile-alt me-2"></i> KGH HUB
            </a>
        </div>
    </nav>

    <!-- Signup Container -->
    <div class="signup-container">
        <div class="container">
            <div
              class="row justify-content-center align-items-center"
              style="min-height: 100vh"
            >
                <div class="col-md-8 col-lg-6">
                    <div class="signup-card">
                        <div class="signup-header">
                            <h3>Create Your Account</h3>
                            <p class="mb-0">Join the Kushy Gadget Hub community</p>
                        </div>
                        <div class="signup-body">
                            <!-- Alert Messages -->
                            <div id="auth-error" class="auth-error"></div>
                            <div id="auth-success" class="auth-success"></div>
                            <div id="loader" class="loader" style="display: none;">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Creating your account...</p>
                            </div>

                            <!-- Progress Steps -->
                            <div class="signup-progress mb-4">
                                <div class="progress-step">
                                    <div class="step-circle active">1</div>
                                    <div class="step-title">Account</div>
                                </div>
                                <div class="progress-step">
                                    <div class="step-circle">2</div>
                                    <div class="step-title">Personal</div>
                                </div>
                                <div class="progress-step">
                                    <div class="step-circle">3</div>
                                    <div class="step-title">Preferences</div>
                                </div>
                            </div>

                            <!-- Social Signup -->
                            <div class="social-signup mb-3">
                                <button id="googleSignIn" class="social-btn google">
                                    <i class="fab fa-google"></i>
                                </button>
                                <button id="facebookSignIn" class="social-btn fb">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                            </div>

                            <div class="divider mb-4">
                                <span>OR SIGN UP WITH EMAIL</span>
                            </div>

                            <!-- Signup Form -->
                            <form method="POST" id="signupForm" novalidate>
                                <!-- Step 1: Account Information -->
                                <div class="step-content active" id="step1">
                                    <div class="mb-3">
                                        <label for="email" class="form-label"
                                            >Email Address</label
                                        >
                                        <div class="input-group">
                                            <span class="input-group-text"
                                                ><i class="fas fa-envelope"></i
                                            ></span>
                                            <input
                                              type="email"
                                              class="form-control"
                                              id="email"
                                              name="email"
                                              placeholder="Enter your email"
                                              required
                                            />
                                        </div>
                                        <div class="form-text">
                                            We'll never share your email with anyone else.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"
                                                ><i class="fas fa-lock"></i
                                            ></span>
                                            <input
                                              type="password"
                                              class="form-control"
                                              id="password"
                                              name="password"
                                              placeholder="Create a password"
                                              required
                                            />
                                            <span
                                              class="input-group-text toggle-password"
                                              style="cursor: pointer;"
                                              title="Show/Hide Password"
                                            >
                                                <i class="fas fa-eye-slash"></i>
                                            </span>
                                        </div>

                                        <div class="password-criteria mt-2">
                                            <p class="mb-2 fw-bold">Password must contain:</p>
                                            <ul>
                                                <li id="length" class="invalid">
                                                    At least 8 characters
                                                </li>
                                                <li id="uppercase" class="invalid">
                                                    At least one uppercase letter
                                                </li>
                                                <li id="lowercase" class="invalid">
                                                    At least one lowercase letter
                                                </li>
                                                <li id="number" class="invalid">
                                                    At least one number
                                                </li>
                                                <li id="special" class="invalid">
                                                    At least one special character
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="confirmPassword" class="form-label"
                                            >Confirm Password</label
                                        >
                                        <div class="input-group">
                                            <span class="input-group-text"
                                                ><i class="fas fa-lock"></i
                                            ></span>
                                            <input
                                              type="password"
                                              class="form-control"
                                              id="confirmPassword"
                                              name="confirmPassword"
                                              placeholder="Confirm your password"
                                              required
                                            />
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <a
                                          href="login_page.php"
                                          class="btn btn-link text-decoration-none"
                                          >Already have an account?</a
                                        >
                                        <button
                                          type="button"
                                          class="btn btn-primary next-step"
                                          data-next="step2"
                                        >
                                          Next Step
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 2: Personal Information -->
                                <div class="step-content" id="step2">
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <label for="firstName" class="form-label"
                                                >First Name</label
                                            >
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    ><i class="fas fa-user"></i
                                                ></span>
                                                <input
                                                  type="text"
                                                  class="form-control"
                                                  id="firstName"
                                                  name="firstName"
                                                  placeholder="Enter first name"
                                                  required
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastName" class="form-label"
                                                >Last Name</label
                                            >
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    ><i class="fas fa-user"></i
                                                ></span>
                                                <input
                                                  type="text"
                                                  class="form-control"
                                                  id="lastName"
                                                  name="lastName"
                                                  placeholder="Enter last name"
                                                  required
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label"
                                            >Phone Number</label
                                        >
                                        <div class="input-group">
                                            <span class="input-group-text"
                                                ><i class="fas fa-phone"></i
                                            ></span>
                                            <input
                                              type="tel"
                                              class="form-control"
                                              id="phone"
                                              name="phone"
                                              placeholder="Enter phone number"
                                              required
                                            />
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="birthdate" class="form-label"
                                            >Date of Birth</label
                                        >
                                        <div class="input-group">
                                            <span class="input-group-text"
                                                ><i class="fas fa-calendar"></i
                                            ></span>
                                            <input
                                              type="date"
                                              class="form-control"
                                              id="birthdate"
                                              name="birthdate"
                                              required
                                            />
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button
                                          type="button"
                                          class="btn btn-outline-secondary prev-step"
                                          data-prev="step1"
                                        >
                                          Previous
                                        </button>
                                        <button
                                          type="button"
                                          class="btn btn-primary next-step"
                                          data-next="step3"
                                        >
                                          Next Step
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 3: Preferences -->
                                <div class="step-content" id="step3">
                                    <div class="mb-4">
                                        <label class="form-label"
                                            >Preferred Product Categories</label
                                        >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input
                                                      class="form-check-input"
                                                      type="checkbox"
                                                      id="smartphones"
                                                      name="categories[]"
                                                      value="Smartphones"
                                                    />
                                                    <label
                                                      class="form-check-label"
                                                      for="smartphones"
                                                    >
                                                      Smartphones
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input
                                                      class="form-check-input"
                                                      type="checkbox"
                                                      id="laptops"
                                                      name="categories[]"
                                                      value="Laptops & Computers"
                                                    />
                                                    <label
                                                      class="form-check-label"
                                                      for="laptops"
                                                    >
                                                      Laptops & Computers
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input
                                                      class="form-check-input"
                                                      type="checkbox"
                                                      id="audio"
                                                      name="categories[]"
                                                      value="Audio Devices"
                                                    />
                                                    <label
                                                      class="form-check-label"
                                                      for="audio"
                                                    >
                                                      Audio Devices
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input
                                                      class="form-check-input"
                                                      type="checkbox"
                                                      id="wearables"
                                                      name="categories[]"
                                                      value="Wearables"
                                                    />
                                                    <label
                                                      class="form-check-label"
                                                      for="wearables"
                                                    >
                                                      Wearables
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input
                                                      class="form-check-input"
                                                      type="checkbox"
                                                      id="accessories"
                                                      name="categories[]"
                                                      value="Accessories"
                                                    />
                                                    <label
                                                      class="form-check-label"
                                                      for="accessories"
                                                    >
                                                      Accessories
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary prev-step" data-prev="step2">
                                          Previous
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                          Create Account
                                        </button>
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
  // Form elements
  const signupForm = document.getElementById("signupForm");
  const email = document.getElementById("email");
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirmPassword");
  const firstName = document.getElementById("firstName");
  const lastName = document.getElementById("lastName");
  const phone = document.getElementById("phone");
  const birthdate = document.getElementById("birthdate");
  const termsAgree = document.getElementById("termsAgree");

  // Toggle password visibility buttons
  const toggleButtons = document.querySelectorAll(".toggle-password");

  toggleButtons.forEach((button) => {
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

  // Password criteria regex and UI elements
  const criteria = {
    length: { regex: /.{8,}/, element: document.getElementById("length") },
    uppercase: {
      regex: /[A-Z]/,
      element: document.getElementById("uppercase"),
    },
    lowercase: {
      regex: /[a-z]/,
      element: document.getElementById("lowercase"),
    },
    number: { regex: /[0-9]/, element: document.getElementById("number") },
    special: {
      regex: /[!@#$%^&*]/,
      element: document.getElementById("special"),
    },
  };

  // Validate password live
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

  // Confirm password live validation
  if (confirmPassword) {
    confirmPassword.addEventListener("input", function () {
      const match = this.value === password.value && this.value.length > 0;
      this.classList.toggle("is-valid", match);
      this.classList.toggle("is-invalid", !match);
    });
  }

  // Steps setup
  const steps = ["step1", "step2", "step3"];
  let currentStep = 0;

  function showStep(index) {
    document
      .querySelectorAll(".step-content")
      .forEach((step) => step.classList.remove("active"));
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
    switch (index) {
      case 0: // Account info
        if (
          !email.value.trim() ||
          !password.value.trim() ||
          !confirmPassword.value.trim()
        ) {
          alert("Please fill all required fields in Account Information.");
          return false;
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
          alert("Please enter a valid email address.");
          return false;
        }
        // Check password criteria
        for (const key in criteria) {
          if (!criteria[key].regex.test(password.value)) {
            alert("Password does not meet all required criteria.");
            return false;
          }
        }
        if (password.value !== confirmPassword.value) {
          alert("Passwords do not match.");
          return false;
        }
        break;

      case 1: // Personal info
        if (
          !firstName.value.trim() ||
          !lastName.value.trim() ||
          !phone.value.trim() ||
          !birthdate.value.trim()
        ) {
          alert("Please fill all required fields in Personal Information.");
          return false;
        }
        // Simple phone number validation (digits only, length 7-15)
        if (!/^\d{7,15}$/.test(phone.value.trim())) {
          alert("Please enter a valid phone number (7-15 digits).");
          return false;
        }
        break;

      case 2: // Preferences
        if (!termsAgree.checked) {
          alert("Please agree to the Terms of Service and Privacy Policy.");
          return false;
        }
        break;

      default:
        return false;
    }
    return true;
  }

  // Next button handler
  document.querySelectorAll(".next-step").forEach((button) => {
    button.addEventListener("click", () => {
      if (validateStep(currentStep)) {
        if (currentStep < steps.length - 1) {
          currentStep++;
          showStep(currentStep);
        }
      }
    });
  });

  // Previous button handler
  document.querySelectorAll(".prev-step").forEach((button) => {
    button.addEventListener("click", () => {
      if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
      }
    });
  });

  // Final form submission
  signupForm.addEventListener("submit", function (e) {
    e.preventDefault();

    if (!validateStep(currentStep)) return;

    alert("Sign-up successful! You can now submit to the server.");
  });

  // Initialize form step
  showStep(currentStep);
});

    </script>
</body>
</html>
