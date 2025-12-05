<header class="flex h-16 items-center gap-4 border-b border-border/50 bg-background/60 backdrop-blur-xl px-6 sticky top-0 z-20 transition-all duration-300">
    <button id="open-sidebar" class="md:hidden text-muted-foreground hover:text-foreground">
        <i data-lucide="menu" class="h-5 w-5"></i>
        <span class="sr-only">Toggle navigation menu</span>
    </button>
    <div class="w-full flex-1">
        <form>
            <div class="relative">
                <i data-lucide="search" class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"></i>
                <input
                    type="search"
                    placeholder="Search products..."
                    class="w-full bg-background/50 appearance-none pl-8 shadow-none md:w-2/3 lg:w-1/3 flex h-9 rounded-lg border border-input px-3 py-1 text-sm transition-all duration-200 file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:border-primary disabled:cursor-not-allowed disabled:opacity-50"
                />
            </div>
        </form>
    </div>
    <div class="flex items-center gap-4">
        <!-- Cart Icon (Customers Only) -->
        <button id="header-cart-btn" onclick="window.location.href='/user/cart'" class="relative h-8 w-8 items-center justify-center rounded-full border border-border/50 bg-muted hover:bg-muted/80 transition-colors hidden">
            <i data-lucide="shopping-cart" class="h-4 w-4"></i>
            <span id="header-cart-count" class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-primary text-[10px] font-bold text-primary-foreground flex items-center justify-center hidden">0</span>
        </button>

        <!-- Notification Icon (All Roles) -->
        <button class="relative h-8 w-8 items-center justify-center rounded-full border border-border/50 bg-muted hover:bg-muted/80 transition-colors flex">
            <i data-lucide="bell" class="h-4 w-4"></i>
            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-destructive"></span>
        </button>

        <button class="relative h-8 w-8 rounded-full overflow-hidden border border-border/50 bg-muted hover:bg-muted/80 transition-colors">
            <img src="https://ui.shadcn.com/avatars/01.png" alt="User" class="h-full w-full object-cover" />
        </button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const user = JSON.parse(localStorage.getItem('user') || 'null');
            if (user && user.role === 'Customer') {
                const cartBtn = document.getElementById('header-cart-btn');
                if (cartBtn) {
                    cartBtn.classList.remove('hidden');
                    cartBtn.classList.add('flex');
                }
            }

            // Global Email Verification Check
            try {
                // Use the specific endpoint as requested
                const verificationStatus = await AuthService.checkEmailVerification();
                
                if (verificationStatus && verificationStatus.isEmailVerified === false) {
                    const banner = document.getElementById('globalEmailVerificationBanner');
                    if (banner) banner.classList.remove('hidden');
                }
            } catch (error) {
                console.error("Failed to check email verification status", error);
            }
        });
    </script>
</header>
<!-- Global Verification Banner -->
<div id="globalEmailVerificationBanner" class="hidden w-full border-b border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-800 transition-all duration-300">
    <div class="container mx-auto flex items-center justify-center gap-2">
        <i data-lucide="alert-triangle" class="h-4 w-4 text-yellow-600"></i>
        <span>
            <span class="font-medium">Action Required:</span>
            Your email is not verified. 
            <a href="/verify-email" class="font-bold underline underline-offset-2 hover:text-yellow-900">Click here</a> 
            to verify your account.
        </span>
    </div>
</div>
