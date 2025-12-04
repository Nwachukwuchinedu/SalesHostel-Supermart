<?php include __DIR__ . '/../includes/head.php'; ?>

<div class="flex min-h-screen w-full flex-col bg-muted/20">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="flex flex-col sm:gap-4 sm:py-4 md:ml-64 transition-all duration-300">
        <?php include __DIR__ . '/../includes/dashboard_header.php'; ?>
        
        <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <div class="flex flex-col gap-8">
                <!-- Header -->
                <div class="flex flex-col gap-2 fade-up">
                    <h1 class="text-3xl font-headline font-bold tracking-tight">My Cart</h1>
                    <p class="text-muted-foreground">Review your selected items before checking out.</p>
                </div>

                <div class="grid gap-8 lg:grid-cols-3 fade-up stagger-1">
                    <!-- Cart Items List -->
                    <div class="lg:col-span-2 space-y-4" id="cart-items-container">
                        <!-- Items will be injected here via JS -->
                        <div class="flex flex-col items-center justify-center py-12 text-center space-y-4 bg-card/50 backdrop-blur-sm border rounded-xl p-8">
                            <div class="h-16 w-16 rounded-full bg-muted flex items-center justify-center">
                                <i data-lucide="shopping-cart" class="h-8 w-8 text-muted-foreground"></i>
                            </div>
                            <h3 class="text-xl font-semibold">Your cart is empty</h3>
                            <p class="text-muted-foreground">Looks like you haven't added anything to your cart yet.</p>
                            <a href="/user/shop" class="inline-flex items-center justify-center rounded-lg bg-primary px-6 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90">
                                Start Shopping
                            </a>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-24 bg-card/80 backdrop-blur-md border rounded-xl p-6 shadow-sm space-y-6">
                            <h3 class="text-lg font-semibold">Order Summary</h3>
                            
                            <div class="space-y-4 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-muted-foreground">Subtotal</span>
                                    <span class="font-medium" id="cart-subtotal">₦0.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-muted-foreground">Delivery Fee</span>
                                    <span class="font-medium text-green-600">Free</span>
                                </div>
                                <div class="border-t pt-4 flex justify-between items-center">
                                    <span class="font-bold text-lg">Total</span>
                                    <span class="font-bold text-lg text-primary" id="cart-total">₦0.00</span>
                                </div>
                            </div>

                            <button id="checkout-btn" class="w-full inline-flex items-center justify-center rounded-lg bg-primary h-12 text-base font-medium text-primary-foreground shadow transition-transform hover:scale-[1.02] hover:bg-primary/90 disabled:opacity-50 disabled:pointer-events-none">
                                Proceed to Checkout
                            </button>
                            
                            <div class="flex items-center justify-center gap-2 text-xs text-muted-foreground">
                                <i data-lucide="shield-check" class="h-4 w-4"></i>
                                Secure Checkout
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>

<script src="/assets/js/auth-middleware.js"></script>
<script src="/assets/js/config.js"></script>
<script src="/assets/js/api.js"></script>
<script src="/assets/js/main.js"></script>
<script>
    lucide.createIcons();
    
    document.addEventListener('DOMContentLoaded', () => {
        gsap.to(".fade-up", {
            y: 0,
            opacity: 1,
            duration: 0.6,
            stagger: 0.1,
            ease: "power2.out"
        });
        
        renderCart();
        
        // Listen for cart updates
        window.addEventListener('cartUpdated', renderCart);
    });

    async function renderCart() {
        const container = document.getElementById('cart-items-container');
        const subtotalEl = document.getElementById('cart-subtotal');
        const totalEl = document.getElementById('cart-total');
        const checkoutBtn = document.getElementById('checkout-btn');
        
        // Only show full loading state if container is empty
        if (!container.hasChildNodes() || container.innerHTML.trim() === '') {
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12">
                    <i data-lucide="loader-2" class="h-8 w-8 animate-spin text-primary"></i>
                    <p class="text-muted-foreground mt-2">Loading cart...</p>
                </div>
            `;
            lucide.createIcons();
        }

        const cart = await CartManager.getCart();

        if (cart.length === 0) {
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12 text-center space-y-4 bg-card/50 backdrop-blur-sm border rounded-xl p-8">
                    <div class="h-16 w-16 rounded-full bg-muted flex items-center justify-center">
                        <i data-lucide="shopping-cart" class="h-8 w-8 text-muted-foreground"></i>
                    </div>
                    <h3 class="text-xl font-semibold">Your cart is empty</h3>
                    <p class="text-muted-foreground">Looks like you haven't added anything to your cart yet.</p>
                    <a href="/user/shop" class="inline-flex items-center justify-center rounded-lg bg-primary px-6 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90">
                        Start Shopping
                    </a>
                </div>
            `;
            subtotalEl.textContent = '₦0.00';
            totalEl.textContent = '₦0.00';
            checkoutBtn.disabled = true;
            lucide.createIcons();
            return;
        }

        checkoutBtn.disabled = false;
        let total = 0;

        container.innerHTML = cart.map(item => {
            // Handle different price field names from backend vs local
            const price = parseFloat(item.sellingPrice || item.price || 0);
            const itemTotal = price * item.quantity;
            total += itemTotal;
            
            // Handle different image structures
            let imageUrl = null;
            if (item.images && item.images.length > 0) imageUrl = item.images[0];
            else if (item.image) imageUrl = item.image;

            // ID for operations
            const itemId = item.id || item._id;

            return `
                <div id="row-${itemId}" class="flex gap-4 p-4 bg-card/80 backdrop-blur-sm border rounded-xl shadow-sm transition-all hover:shadow-md">
                    <div class="h-24 w-24 rounded-lg bg-muted overflow-hidden flex-shrink-0 border border-border/50">
                        ${imageUrl 
                            ? `<img src="${imageUrl}" alt="${item.name}" class="h-full w-full object-cover">`
                            : `<div class="h-full w-full flex items-center justify-center text-muted-foreground"><i data-lucide="image" class="h-8 w-8"></i></div>`
                        }
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div class="flex justify-between items-start gap-2">
                            <div>
                                <h3 class="font-semibold text-lg line-clamp-1">${item.name}</h3>
                                <p class="text-sm text-muted-foreground">Unit Price: ₦${price.toLocaleString()}</p>
                            </div>
                            <button onclick="removeFromCart('${itemId}')" class="text-muted-foreground hover:text-destructive transition-colors p-1">
                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                            </button>
                        </div>
                        
                        <div class="flex justify-between items-end mt-2">
                            <div class="flex items-center border rounded-lg bg-background">
                                <button onclick="updateQuantity('${itemId}', -1)" class="p-2 hover:bg-accent hover:text-accent-foreground transition-colors rounded-l-lg disabled:opacity-50">
                                    <i data-lucide="minus" class="h-3 w-3"></i>
                                </button>
                                <span id="qty-${itemId}" class="w-8 text-center text-sm font-medium">${item.quantity}</span>
                                <button onclick="updateQuantity('${itemId}', 1)" class="p-2 hover:bg-accent hover:text-accent-foreground transition-colors rounded-r-lg">
                                    <i data-lucide="plus" class="h-3 w-3"></i>
                                </button>
                            </div>
                            <div id="subtotal-${itemId}" class="font-bold text-lg text-primary" data-unit-price="${price}">
                                ₦${itemTotal.toLocaleString('en-NG', { minimumFractionDigits: 2 })}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        subtotalEl.textContent = '₦' + total.toLocaleString('en-NG', { minimumFractionDigits: 2 });
        totalEl.textContent = '₦' + total.toLocaleString('en-NG', { minimumFractionDigits: 2 });
        
        lucide.createIcons();
    }

    window.updateQuantity = async (id, change) => {
        const qtyEl = document.getElementById(`qty-${id}`);
        const subtotalEl = document.getElementById(`subtotal-${id}`);
        const cartSubtotalEl = document.getElementById('cart-subtotal');
        const cartTotalEl = document.getElementById('cart-total');
        
        if (!qtyEl || !subtotalEl) return;

        let currentQty = parseInt(qtyEl.textContent);
        let newQty = currentQty + change;

        if (newQty < 1) return;

        // Optimistic UI Update
        qtyEl.textContent = newQty;
        
        const unitPrice = parseFloat(subtotalEl.getAttribute('data-unit-price'));
        const newSubtotal = unitPrice * newQty;
        subtotalEl.textContent = '₦' + newSubtotal.toLocaleString('en-NG', { minimumFractionDigits: 2 });

        // Update Global Totals
        const parseCurrency = (str) => parseFloat(str.replace(/[^0-9.-]+/g,""));
        let currentTotal = parseCurrency(cartTotalEl.textContent);
        let totalChange = (newQty - currentQty) * unitPrice;
        let newTotal = currentTotal + totalChange;
        
        const formattedTotal = '₦' + newTotal.toLocaleString('en-NG', { minimumFractionDigits: 2 });
        cartSubtotalEl.textContent = formattedTotal;
        cartTotalEl.textContent = formattedTotal;

        // Update Badges
        const badges = document.querySelectorAll('#cart-count, #mobile-cart-count, #header-cart-count');
        badges.forEach(b => {
            let count = parseInt(b.textContent || '0');
            b.textContent = Math.max(0, count + change);
        });

        if (AuthService.isAuthenticated()) {
            try {
                if (change > 0) {
                    await CartService.increaseQuantity(id);
                } else {
                    await CartService.decreaseQuantity(id);
                }
            } catch (error) {
                // Revert UI on error
                qtyEl.textContent = currentQty;
                subtotalEl.textContent = '₦' + (unitPrice * currentQty).toLocaleString('en-NG', { minimumFractionDigits: 2 });
                cartSubtotalEl.textContent = '₦' + currentTotal.toLocaleString('en-NG', { minimumFractionDigits: 2 });
                cartTotalEl.textContent = '₦' + currentTotal.toLocaleString('en-NG', { minimumFractionDigits: 2 });
                badges.forEach(b => {
                    let count = parseInt(b.textContent || '0');
                    b.textContent = Math.max(0, count - change);
                });
                showToast(error.message, 'error');
            }
        } else {
            const cart = await CartManager.getCart();
            const itemIndex = cart.findIndex(item => (item.id || item._id) === id);
            if (itemIndex > -1) {
                cart[itemIndex].quantity = newQty;
                CartManager.saveCart(cart);
            }
        }
    };

    window.removeFromCart = async (id) => {
        const rowEl = document.getElementById(`row-${id}`);
        const qtyEl = document.getElementById(`qty-${id}`);
        const subtotalEl = document.getElementById(`subtotal-${id}`);
        const cartSubtotalEl = document.getElementById('cart-subtotal');
        const cartTotalEl = document.getElementById('cart-total');

        if (!rowEl) return;

        // Store current state for revert
        const originalDisplay = rowEl.style.display;
        const currentQty = parseInt(qtyEl.textContent);
        const unitPrice = parseFloat(subtotalEl.getAttribute('data-unit-price'));
        const itemTotal = unitPrice * currentQty;

        // Optimistic UI Update
        rowEl.style.display = 'none'; // Hide row immediately
        
        const parseCurrency = (str) => parseFloat(str.replace(/[^0-9.-]+/g,""));
        let currentTotal = parseCurrency(cartTotalEl.textContent);
        let newTotal = currentTotal - itemTotal;
        
        const formattedTotal = '₦' + newTotal.toLocaleString('en-NG', { minimumFractionDigits: 2 });
        cartSubtotalEl.textContent = formattedTotal;
        cartTotalEl.textContent = formattedTotal;

        // Update Badges
        const badges = document.querySelectorAll('#cart-count, #mobile-cart-count, #header-cart-count');
        badges.forEach(b => {
            let count = parseInt(b.textContent || '0');
            b.textContent = Math.max(0, count - currentQty);
        });

        if (AuthService.isAuthenticated()) {
            try {
                await CartService.removeFromCart(id);
                showToast('Item removed from cart', 'success');
                rowEl.remove(); // Completely remove from DOM on success
                
                // Check if cart is empty
                const container = document.getElementById('cart-items-container');
                const visibleRows = container.querySelectorAll('div[id^="row-"]:not([style*="display: none"])');
                if (visibleRows.length === 0) {
                    renderCart(); // Re-render empty state
                }

            } catch (error) {
                // Revert UI on error
                rowEl.style.display = originalDisplay;
                cartSubtotalEl.textContent = '₦' + currentTotal.toLocaleString('en-NG', { minimumFractionDigits: 2 });
                cartTotalEl.textContent = '₦' + currentTotal.toLocaleString('en-NG', { minimumFractionDigits: 2 });
                badges.forEach(b => {
                    let count = parseInt(b.textContent || '0');
                    b.textContent = count + currentQty;
                });
                showToast(error.message, 'error');
            }
        } else {
            const cart = await CartManager.getCart();
            const newCart = cart.filter(item => (item.id || item._id) !== id);
            CartManager.saveCart(newCart);
            rowEl.remove();
             // Check if cart is empty
             const container = document.getElementById('cart-items-container');
             if (container.children.length === 0) {
                 renderCart();
             }
        }
    };
</script>
</body>
</html>
