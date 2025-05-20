document.addEventListener('DOMContentLoaded', function () {
    // Cart functionality
    let cart = [
        { id: "1", name: "iPhone 16 Pro", price: 1199.99, quantity: 1, image: "https://placehold.co/150x150", description: "256GB, Midnight Black" },
        { id: "2", name: "MacBook Air M2", price: 1199.99, quantity: 1, image: "https://placehold.co/150x150", description: "8GB RAM, 256GB SSD, Space Gray" }
    ];
    
    // Example cart data for demonstration
    localStorage.setItem('kghCart', JSON.stringify(cart));
    
    // For production use:
    // let cart = JSON.parse(localStorage.getItem('kghCart')) || [];
    
    updateCartDisplay();

    // Function to update cart display with animations
    function updateCartDisplay() {
        const cartItems = document.getElementById('cartItems');
        const emptyCartMessage = document.getElementById('emptyCartMessage');
        const cartControls = document.getElementById('cartControls');
        const subtotalElement = document.getElementById('subtotal');
        const taxElement = document.getElementById('tax');
        const totalElement = document.getElementById('total');
        const checkoutBtn = document.getElementById('checkoutBtn');

        if (cart.length === 0) {
            // Show empty cart message with animation
            if (cartItems) {
                cartItems.innerHTML = '';
            }
            
            if (emptyCartMessage) {
                emptyCartMessage.style.display = 'block';
                emptyCartMessage.classList.remove('fade-out');
                emptyCartMessage.classList.add('fade-in');
            }
            
            if (cartControls) {
                cartControls.classList.add('fade-out');
                setTimeout(() => {
                    cartControls.style.display = 'none';
                }, 300);
            }

            // Reset totals with animation
            if (subtotalElement) {
                subtotalElement.classList.add('fade-in');
                subtotalElement.textContent = '₱0.00';
            }
            
            if (taxElement) {
                taxElement.classList.add('fade-in');
                taxElement.textContent = '₱0.00';
            }
            
            if (totalElement) {
                totalElement.classList.add('fade-in');
                totalElement.textContent = '₱0.00';
            }
            
            if (checkoutBtn) {
                checkoutBtn.classList.add('fade-out');
                checkoutBtn.disabled = true;
            }
        } else {
            // Hide empty cart message
            if (emptyCartMessage) {
                emptyCartMessage.classList.remove('fade-in');
                emptyCartMessage.classList.add('fade-out');
                setTimeout(() => {
                    emptyCartMessage.style.display = 'none';
                }, 300);
            }
            
            if (cartControls) {
                cartControls.style.display = 'flex';
                cartControls.classList.remove('fade-out');
                cartControls.classList.add('fade-in');
            }

            // Calculate totals
            const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            const tax = subtotal * 0.08; // 8% tax
            const total = subtotal + tax;

            // Update total displays with animation
            if (subtotalElement) {
                subtotalElement.classList.add('price-update');
                subtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
                setTimeout(() => {
                    subtotalElement.classList.remove('price-update');
                }, 1000);
            }
            
            if (taxElement) {
                taxElement.classList.add('price-update');
                taxElement.textContent = `₱${tax.toFixed(2)}`;
                setTimeout(() => {
                    taxElement.classList.remove('price-update');
                }, 1000);
            }
            
            if (totalElement) {
                totalElement.classList.add('price-update');
                totalElement.textContent = `₱${total.toFixed(2)}`;
                setTimeout(() => {
                    totalElement.classList.remove('price-update');
                }, 1000);
            }
            
            if (checkoutBtn) {
                checkoutBtn.classList.remove('fade-out');
                checkoutBtn.classList.add('fade-in');
                checkoutBtn.disabled = false;
            }
        }

        // Update cart count with animation
        updateCartCount(true);
    }

    // Function to update cart count with optional animation
    function updateCartCount(animate = false) {
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            const itemCount = cart.reduce((total, item) => total + item.quantity, 0);
            cartCountElement.textContent = itemCount;
            
            if (animate) {
                cartCountElement.classList.add('pulse');
                setTimeout(() => {
                    cartCountElement.classList.remove('pulse');
                }, 500);
            }
        }
    }

    // Quantity buttons with improved feedback
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    quantityBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            const itemId = this.getAttribute('data-id');
            const quantityInput = document.querySelector(`.quantity-input[data-id="${itemId}"]`);
            const priceElement = document.getElementById(`price-${itemId}`);

            let currentValue = parseInt(quantityInput.value);

            if (action === 'increase') {
                if (currentValue < 10) {
                    // Add animation to button
                    this.classList.add('btn-success');
                    setTimeout(() => {
                        this.classList.remove('btn-success');
                    }, 300);
                    
                    quantityInput.value = currentValue + 1;
                    updateItemQuantity(itemId, currentValue + 1);
                    
                    // Animate price update
                    if (priceElement) {
                        priceElement.classList.add('price-update');
                        setTimeout(() => {
                            priceElement.classList.remove('price-update');
                        }, 1000);
                    }
                } else {
                    // Shake if at max quantity
                    quantityInput.classList.add('shake');
                    setTimeout(() => {
                        quantityInput.classList.remove('shake');
                    }, 500);
                }
            } else if (action === 'decrease') {
                if (currentValue > 1) {
                    // Add animation to button
                    this.classList.add('btn-secondary');
                    setTimeout(() => {
                        this.classList.remove('btn-secondary');
                    }, 300);
                    
                    quantityInput.value = currentValue - 1;
                    updateItemQuantity(itemId, currentValue - 1);
                    
                    // Animate price update
                    if (priceElement) {
                        priceElement.classList.add('price-update');
                        setTimeout(() => {
                            priceElement.classList.remove('price-update');
                        }, 1000);
                    }
                } else {
                    // Shake if at min quantity
                    quantityInput.classList.add('shake');
                    setTimeout(() => {
                        quantityInput.classList.remove('shake');
                    }, 500);
                }
            }
        });
    });

    // Manual quantity input with validation animation
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.getAttribute('data-id');
            let value = parseInt(this.value);
            const priceElement = document.getElementById(`price-${itemId}`);

            // Validate value with visual feedback
            if (isNaN(value) || value < 1) {
                value = 1;
                this.value = 1;
                this.classList.add('shake');
                setTimeout(() => {
                    this.classList.remove('shake');
                }, 500);
            } else if (value > 10) {
                value = 10;
                this.value = 10;
                this.classList.add('shake');
                setTimeout(() => {
                    this.classList.remove('shake');
                }, 500);
            }

            updateItemQuantity(itemId, value);
            
            // Animate price update
            if (priceElement) {
                priceElement.classList.add('price-update');
                setTimeout(() => {
                    priceElement.classList.remove('price-update');
                }, 1000);
            }
        });
    });

    // Update item quantity in cart
    function updateItemQuantity(itemId, quantity) {
        const itemIndex = cart.findIndex(item => item.id === itemId);
        if (itemIndex > -1) {
            cart[itemIndex].quantity = quantity;
            localStorage.setItem('kghCart', JSON.stringify(cart));
            updateCartDisplay();
        }
    }

    // Remove item buttons with animation
    const removeButtons = document.querySelectorAll('.remove-item');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            removeFromCart(itemId);
        });
    });

    // Remove item from cart with animation
    function removeFromCart(itemId) {
        // Find item element and animate removal
        const itemElement = document.getElementById(`cart-item-${itemId}`);
        
        if (itemElement) {
            // Add removal animation
            itemElement.classList.add('removing');
            
            // Wait for animation to complete before removing from DOM
            setTimeout(() => {
                // Remove from cart array
                cart = cart.filter(item => item.id !== itemId);
                localStorage.setItem('kghCart', JSON.stringify(cart));
                
                // Remove from DOM after animation completes
                itemElement.remove();
                
                // Update display after element is removed
                updateCartDisplay();
            }, 300);
        } else {
            // If element not found, still update cart
            cart = cart.filter(item => item.id !== itemId);
            localStorage.setItem('kghCart', JSON.stringify(cart));
            updateCartDisplay();
        }
    }

    // Clear cart button with confirmation and animation
    const clearCartBtn = document.getElementById('clearCartBtn');
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to clear your cart?')) {
                // Animate all cart items removing
                const cartItems = document.querySelectorAll('.cart-item');
                cartItems.forEach((item, index) => {
                    // Stagger removal for visual effect
                    setTimeout(() => {
                        item.classList.add('removing');
                    }, index * 100);
                });
                
                // Wait for animations to complete
                setTimeout(() => {
                    cart = [];
                    localStorage.setItem('kghCart', JSON.stringify(cart));
                    updateCartDisplay();
                }, cartItems.length * 100 + 300);
            }
        });
    }

    // Apply promo code with visual feedback
    const applyPromoBtn = document.getElementById('applyPromo');
    if (applyPromoBtn) {
        applyPromoBtn.addEventListener('click', function() {
            const promoCode = document.getElementById('promoCode').value.trim();
            const promoMessage = document.getElementById('promoMessage');
            const promoInput = document.getElementById('promoCode');
            
            if (promoCode === 'KGH25') {
                // Success animation
                applyPromoBtn.classList.add('btn-success');
                promoInput.classList.add('is-valid');
                
                setTimeout(() => {
                    applyPromoBtn.classList.remove('btn-success');
                }, 1500);
                
                // Show success message with animation
                promoMessage.textContent = 'Promo code applied! 25% discount';
                promoMessage.className = 'text-success slide-down';
                promoMessage.style.display = 'block';

                // Apply discount with animation
                const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
                const discount = subtotal * 0.25;
                const discountedSubtotal = subtotal - discount;
                const tax = discountedSubtotal * 0.08;
                const total = discountedSubtotal + tax;

                // Animate price updates
                const subtotalElement = document.getElementById('subtotal');
                const taxElement = document.getElementById('tax');
                const totalElement = document.getElementById('total');
                
                if (subtotalElement) {
                    subtotalElement.classList.add('price-update');
                    setTimeout(() => {
                        subtotalElement.textContent = `₱${discountedSubtotal.toFixed(2)} (25% off)`;
                        subtotalElement.classList.remove('price-update');
                    }, 300);
                }
                
                if (taxElement) {
                    taxElement.classList.add('price-update');
                    setTimeout(() => {
                        taxElement.textContent = `₱${tax.toFixed(2)}`;
                        taxElement.classList.remove('price-update');
                    }, 500);
                }
                
                if (totalElement) {
                    totalElement.classList.add('price-update');
                    setTimeout(() => {
                        totalElement.textContent = `₱${total.toFixed(2)}`;
                        totalElement.classList.remove('price-update');
                    }, 700);
                }
            } else if (promoCode === '') {
                // Empty promo code error
                promoInput.classList.add('is-invalid');
                promoInput.classList.add('shake');
                
                setTimeout(() => {
                    promoInput.classList.remove('shake');
                }, 500);
                
                promoMessage.textContent = 'Please enter a promo code';
                promoMessage.className = 'text-danger slide-down';
                promoMessage.style.display = 'block';
            } else {
                // Invalid promo code error
                promoInput.classList.add('is-invalid');
                applyPromoBtn.classList.add('btn-danger');
                
                setTimeout(() => {
                    applyPromoBtn.classList.remove('btn-danger');
                }, 1000);
                
                promoInput.classList.add('shake');
                setTimeout(() => {
                    promoInput.classList.remove('shake');
                }, 500);
                
                promoMessage.textContent = 'Invalid promo code';
                promoMessage.className = 'text-danger slide-down';
                promoMessage.style.display = 'block';
            }

            // Reset message after delay
            setTimeout(() => {
                promoMessage.classList.remove('slide-down');
                promoMessage.classList.add('fade-out');
                
                setTimeout(() => {
                    promoMessage.style.display = 'none';
                    promoMessage.className = 'text-success';
                    promoInput.classList.remove('is-valid');
                    promoInput.classList.remove('is-invalid');
                }, 500);
            }, 3000);
        });
    }
    
    // Add animation to checkout button
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('mouseover', function() {
            this.classList.add('btn-lg');
            setTimeout(() => {
                this.classList.remove('btn-lg');
            }, 200);
        });
        
        checkoutBtn.addEventListener('click', function(e) {
            // Optional: Add a loading spinner when checkout is clicked
            if (cart.length === 0) {
                e.preventDefault();
                this.classList.add('shake');
                setTimeout(() => {
                    this.classList.remove('shake');
                }, 500);
                
                alert('Your cart is empty. Add some products before checkout.');
            } else {
                this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                this.disabled = true;
                // The actual navigation happens after this
            }
        });
    }
    
    // Make recently viewed items interactive
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
            this.style.transition = 'all 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.05)';
        });
    });
});