document.addEventListener('DOMContentLoaded', () => {
    // Initialize Lucide Icons
    lucide.createIcons();

    // Navbar Scroll Effect
    const navbar = document.getElementById('navbar');

    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                navbar.classList.remove('bg-transparent');
                navbar.classList.add('bg-card', 'shadow-md');
            } else {
                navbar.classList.add('bg-transparent');
                navbar.classList.remove('bg-card', 'shadow-md');
            }
        });
    }

    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    let isMenuOpen = false;

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            isMenuOpen = !isMenuOpen;
            if (isMenuOpen) {
                mobileMenu.classList.remove('hidden');
                menuIcon.setAttribute('data-lucide', 'x');
            } else {
                mobileMenu.classList.add('hidden');
                menuIcon.setAttribute('data-lucide', 'menu');
            }
            lucide.createIcons(); // Re-render icons for the X
        });

        // Close menu when clicking a link
        const mobileLinks = document.querySelectorAll('.mobile-link');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                isMenuOpen = false;
                mobileMenu.classList.add('hidden');
                menuIcon.setAttribute('data-lucide', 'menu');
                lucide.createIcons();
            });
        });
    }
});

// Toast Notification System
function showToast(message, type = 'default') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 transition-all duration-300 transform translate-y-2 opacity-0`;

    let icon = '';
    if (type === 'success') {
        icon = `<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
            <i data-lucide="check" class="w-5 h-5"></i>
        </div>`;
    } else if (type === 'error') {
        icon = `<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
        </div>`;
    } else {
        icon = `<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200">
            <i data-lucide="info" class="w-5 h-5"></i>
        </div>`;
    }

    toast.innerHTML = `
        ${icon}
        <div class="ml-3 text-sm font-normal">${message}</div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Close" onclick="this.parentElement.remove()">
            <span class="sr-only">Close</span>
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    `;

    container.appendChild(toast);
    lucide.createIcons();

    // Animate in
    requestAnimationFrame(() => {
        toast.classList.remove('translate-y-2', 'opacity-0');
    });

    // Auto remove
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

// Cart Logic
// Cart Logic
const CartManager = {
    getCart: async () => {
        if (AuthService.isAuthenticated()) {
            try {
                const res = await CartService.getCart();
                return res.data.items.map(item => ({
                    ...item.product,
                    id: item.product._id,
                    quantity: item.quantity,
                    cartItemId: item._id
                }));
            } catch (error) {
                console.error('Failed to fetch cart from server', error);
                return [];
            }
        } else {
            return JSON.parse(localStorage.getItem('cart') || '[]');
        }
    },

    saveCart: (cart) => {
        if (!AuthService.isAuthenticated()) {
            localStorage.setItem('cart', JSON.stringify(cart));
            CartManager.updateCartCount();
            window.dispatchEvent(new Event('cartUpdated'));
        }
    },

    addToCart: async (product) => {
        if (AuthService.isAuthenticated()) {
            try {
                await CartService.addToCart(product.id || product._id, 1);
                showToast('Item added to cart', 'success');
                CartManager.updateCartCount();
                window.dispatchEvent(new Event('cartUpdated'));
            } catch (error) {
                showToast(error.message, 'error');
            }
        } else {
            const cart = await CartManager.getCart();
            const existingItemIndex = cart.findIndex(item => item.id === product.id);

            if (existingItemIndex > -1) {
                cart[existingItemIndex].quantity += 1;
                showToast('Item quantity updated in cart', 'success');
            } else {
                cart.push({ ...product, quantity: 1 });
                showToast('Item added to cart', 'success');
            }
            CartManager.saveCart(cart);
        }
    },

    updateCartCount: async () => {
        let count = 0;
        if (AuthService.isAuthenticated()) {
            try {
                const res = await CartService.getCart();
                count = res.data.totalQuantity || 0;
            } catch (error) {
                console.error('Failed to fetch cart count', error);
            }
        } else {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            count = cart.reduce((sum, item) => sum + item.quantity, 0);
        }

        const badges = [document.getElementById('cart-count'), document.getElementById('mobile-cart-count'), document.getElementById('header-cart-count')];
        badges.forEach(badge => {
            if (badge) {
                badge.textContent = count;
                if (count > 0) {
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        });
    }
};

// Initialize Cart Count
document.addEventListener('DOMContentLoaded', () => {
    CartManager.updateCartCount();
});
