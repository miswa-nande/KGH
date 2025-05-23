document.addEventListener("DOMContentLoaded", function () {
  // Cart functionality
  let cart = [];

  // Initialize cart count
  updateCartCount();

  // Add event listeners to all "Add to Cart" buttons
  const addToCartButtons = document.querySelectorAll(".add-to-cart");
  addToCartButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.dataset.id;
      const productName = this.dataset.name;
      const productPrice = this.dataset.price;

      // Show quantity modal
      showQuantityModal(productId, productName, productPrice);
    });
  });

  // Function to show quantity selection modal
  function showQuantityModal(productId, productName, productPrice) {
    const modalHtml = `
      <div class="modal fade" id="quantityModal" tabindex="-1" aria-labelledby="quantityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="quantityModalLabel">Add to Cart</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>${productName}</p>
              <p class="text-muted">Price: ₱${parseFloat(
                productPrice
              ).toLocaleString()}</p>
              <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" class="form-control" id="quantity" value="1" min="1" max="10">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" onclick="addToCart('${productId}', '${productName}', ${productPrice})">Add to Cart</button>
            </div>
          </div>
        </div>
      </div>
    `;

    // Add modal to body
    document.body.insertAdjacentHTML("beforeend", modalHtml);

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById("quantityModal"));
    modal.show();

    // Remove modal from DOM after it's hidden
    document
      .getElementById("quantityModal")
      .addEventListener("hidden.bs.modal", function () {
        this.remove();
      });
  }

  // Function to add item to cart
  function addToCart(productId, productName, productPrice) {
    const quantity = document.getElementById("quantity").value;

    // Create form data
    const formData = new FormData();
    formData.append("product_id", productId);
    formData.append("quantity", quantity);
    formData.append("add_to_cart", "1");

    // Send AJAX request
    fetch("cart.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        // Close modal
        const modal = bootstrap.Modal.getInstance(
          document.getElementById("quantityModal")
        );
        modal.hide();

        if (data.success) {
          // Update cart count
          updateCartCount(true);

          // Show success message
          showToast("Item added to cart successfully!", "success");

          // Add animation to cart icon
          const cartIcon =
            document.querySelector(".fa-shopping-cart").parentElement;
          cartIcon.classList.add("animate__animated", "animate__rubberBand");
          setTimeout(() => {
            cartIcon.classList.remove(
              "animate__animated",
              "animate__rubberBand"
            );
          }, 1000);
        } else {
          showToast(data.message || "Failed to add item to cart", "error");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        showToast("Failed to add item to cart. Please try again.", "error");
      });
  }

  // Function to update cart count with animation
  function updateCartCount(animate = false) {
    fetch("get_cart_count.php")
      .then((response) => response.json())
      .then((data) => {
        const cartCountElement = document.getElementById("cart-count");
        if (cartCountElement) {
          cartCountElement.textContent = data.count;
          if (animate && data.count > 0) {
            cartCountElement.classList.add("pulse");
            setTimeout(() => {
              cartCountElement.classList.remove("pulse");
            }, 500);
          }
        }
      })
      .catch((error) => console.error("Error:", error));
  }

  // Function to show toast message
  function showToast(message, type = "success") {
    const toastHtml = `
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center text-white bg-${
          type === "success" ? "success" : "danger"
        } border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body">
              ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
    `;

    // Add toast to body
    document.body.insertAdjacentHTML("beforeend", toastHtml);

    // Show toast
    const toastElement = document.querySelector(".toast");
    const toast = new bootstrap.Toast(toastElement);
    toast.show();

    // Remove toast from DOM after it's hidden
    toastElement.addEventListener("hidden.bs.toast", function () {
      this.closest(".toast-container").remove();
    });
  }

  // Make product cards interactive
  const productCards = document.querySelectorAll(".product-card");
  productCards.forEach((card) => {
    card.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-5px)";
      this.style.boxShadow = "0 10px 20px rgba(0,0,0,0.1)";
      this.style.transition = "all 0.3s ease";
    });

    card.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0)";
      this.style.boxShadow = "0 5px 15px rgba(0,0,0,0.05)";
    });
  });

  // Function to update cart display with animations
  function updateCartDisplay() {
    fetch("cart.php")
      .then((response) => response.text())
      .then((html) => {
        const cartItems = document.getElementById("cartItems");
        if (cartItems) {
          cartItems.innerHTML = html;
        }
        updateCartCount(true);
      })
      .catch((error) => console.error("Error:", error));
  }

  // Update item quantity in cart
  function updateItemQuantity(itemId, quantity) {
    const formData = new FormData();
    formData.append("product_id", itemId);
    formData.append("quantity", quantity);
    formData.append("update_quantity", "1");

    fetch("cart.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((html) => {
        updateCartDisplay();
        showToast("Quantity updated successfully!", "success");
      })
      .catch((error) => {
        console.error("Error:", error);
        showToast("Failed to update quantity. Please try again.", "error");
      });
  }

  // Remove item from cart with animation
  function removeFromCart(itemId) {
    const formData = new FormData();
    formData.append("product_id", itemId);
    formData.append("remove_item", "1");

    fetch("cart.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((html) => {
        updateCartDisplay();
        showToast("Item removed from cart!", "success");
      })
      .catch((error) => {
        console.error("Error:", error);
        showToast("Failed to remove item. Please try again.", "error");
      });
  }

  // Clear cart button with confirmation and animation
  const clearCartBtn = document.getElementById("clearCartBtn");
  if (clearCartBtn) {
    clearCartBtn.addEventListener("click", function () {
      if (confirm("Are you sure you want to clear your cart?")) {
        fetch("cart.php", {
          method: "POST",
          body: new FormData().append("clear_cart", "1"),
        })
          .then((response) => response.text())
          .then((html) => {
            updateCartDisplay();
            showToast("Cart cleared successfully!", "success");
          })
          .catch((error) => {
            console.error("Error:", error);
            showToast("Failed to clear cart. Please try again.", "error");
          });
      }
    });
  }
});
