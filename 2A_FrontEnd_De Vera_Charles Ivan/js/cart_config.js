// Cart Configuration
document.addEventListener("DOMContentLoaded", function () {
  // Initialize cart count
  updateCartCount();

  // Add event listeners to all "Add to Cart" buttons
  const addToCartButtons = document.querySelectorAll(".add-to-cart");
  addToCartButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.dataset.id;
      const productName = this.dataset.name;
      const productPrice = this.dataset.price;
      showQuantityModal(productId, productName, productPrice);
    });
  });
});

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
            <p>Product: ${productName}</p>
            <p>Price: ₱${parseFloat(productPrice).toFixed(2)}</p>
            <div class="mb-3">
              <label for="quantity" class="form-label">Quantity</label>
              <input type="number" class="form-control" id="quantity" value="1" min="1">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="addToCart(${productId}, '${productName}', ${productPrice})">Add to Cart</button>
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

function addToCart(productId, productName, productPrice) {
  const quantity = document.getElementById("quantity").value;

  // Create form data
  const formData = new FormData();
  formData.append("product_id", productId);
  formData.append("quantity", quantity);
  formData.append("add_to_cart", "1"); // Add this flag to indicate add to cart action

  // Send AJAX request
  fetch("cart.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text()) // Change to text() since cart.php returns HTML
    .then((html) => {
      // Close modal
      const modal = bootstrap.Modal.getInstance(
        document.getElementById("quantityModal")
      );
      modal.hide();

      // Update cart count
      updateCartCount();

      // Show success message
      showToast("Item added to cart successfully!", "success");

      // Add animation to cart icon
      const cartIcon =
        document.querySelector(".fa-shopping-cart").parentElement;
      cartIcon.classList.add("animate__animated", "animate__rubberBand");
      setTimeout(() => {
        cartIcon.classList.remove("animate__animated", "animate__rubberBand");
      }, 1000);
    })
    .catch((error) => {
      console.error("Error:", error);
      showToast("Failed to add item to cart. Please try again.", "error");
    });
}

function updateCartCount() {
  fetch("get_cart_count.php")
    .then((response) => response.json())
    .then((data) => {
      const cartCount = document.getElementById("cart-count");
      if (cartCount) {
        cartCount.textContent = data.count;
      }
    })
    .catch((error) => {
      console.error("Error updating cart count:", error);
    });
}

function showToast(message, type = "success") {
  // Create toast container if it doesn't exist
  let toastContainer = document.querySelector(".toast-container");
  if (!toastContainer) {
    toastContainer = document.createElement("div");
    toastContainer.className =
      "toast-container position-fixed bottom-0 end-0 p-3";
    document.body.appendChild(toastContainer);
  }

  // Create toast element
  const toastHtml = `
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
  `;

  // Add toast to container
  toastContainer.insertAdjacentHTML("beforeend", toastHtml);

  // Show toast
  const toastElement = toastContainer.lastElementChild;
  const toast = new bootstrap.Toast(toastElement);
  toast.show();

  // Remove toast from DOM after it's hidden
  toastElement.addEventListener("hidden.bs.toast", function () {
    this.remove();
  });
}
