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

    // All steps validated, now submit
    // Here you can add AJAX call or normal submission:
    // e.g., signupForm.submit();

    alert("Sign-up successful! You can now submit to the server.");
  });

  // Initialize form step
  showStep(currentStep);
});
