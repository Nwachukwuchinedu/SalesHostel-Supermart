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

    function renderCart() {
        const cart = CartService.getCart();
        const container = document.getElementById('cart-items-container');
        const subtotalEl = document.getElementById('cart-subtotal');
        const totalEl = document.getElementById('cart-total');
        const checkoutBtn = document.getElementById('checkout-btn');

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
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            
            return `
                <div class="flex gap-4 p-4 bg-card/80 backdrop-blur-sm border rounded-xl shadow-sm transition-all hover:shadow-md">
                    <div class="h-24 w-24 rounded-lg bg-muted overflow-hidden flex-shrink-0 border border-border/50">
                        ${item.image 
                            ? `<img src="${item.image}" alt="${item.name}" class="h-full w-full object-cover">`
                            : `<div class="h-full w-full flex items-center justify-center text-muted-foreground"><i data-lucide="image" class="h-8 w-8"></i></div>`
                        }
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div class="flex justify-between items-start gap-2">
                            <div>
                                <h3 class="font-semibold text-lg line-clamp-1">${item.name}</h3>
                                <p class="text-sm text-muted-foreground">Unit Price: ₦${item.price.toLocaleString()}</p>
                            </div>
                            <button onclick="removeFromCart('${item.id}')" class="text-muted-foreground hover:text-destructive transition-colors p-1">
                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                            </button>
                        </div>
                        
                        <div class="flex justify-between items-end mt-2">
                            <div class="flex items-center border rounded-lg bg-background">
                                <button onclick="updateQuantity('${item.id}', ${item.quantity - 1})" class="p-2 hover:bg-accent hover:text-accent-foreground transition-colors rounded-l-lg disabled:opacity-50" ${item.quantity <= 1 ? 'disabled' : ''}>
                                    <i data-lucide="minus" class="h-3 w-3"></i>
                                </button>
                                <span class="w-8 text-center text-sm font-medium">${item.quantity}</span>
                                <button onclick="updateQuantity('${item.id}', ${item.quantity + 1})" class="p-2 hover:bg-accent hover:text-accent-foreground transition-colors rounded-r-lg">
                                    <i data-lucide="plus" class="h-3 w-3"></i>
                                </button>
                            </div>
                            <div class="font-bold text-lg text-primary">
                                ₦${itemTotal.toLocaleString()}
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

    window.updateQuantity = (id, newQty) => {
        if (newQty < 1) return;
        const cart = CartService.getCart();
        const itemIndex = cart.findIndex(item => item.id === id);
        
        if (itemIndex > -1) {
            cart[itemIndex].quantity = newQty;
            CartService.saveCart(cart);
        }
    };

    window.removeFromCart = (id) => {
        const cart = CartService.getCart();
        const newCart = cart.filter(item => item.id !== id);
        CartService.saveCart(newCart);
    };
</script>
</body>
</html>
