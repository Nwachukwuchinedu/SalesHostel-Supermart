<?php include 'includes/head.php'; ?>

<div class="min-h-screen w-full flex relative overflow-hidden">
    <!-- Uneven Faded Grid Background -->
    <div class="bg-grid-uneven fixed inset-0 pointer-events-none"></div>

    <!-- Left Side: Visual & Branding -->
    <div class="hidden lg:flex w-1/2 relative items-center justify-center bg-muted/20 backdrop-blur-sm border-r border-border/50">
        <div class="relative z-10 p-12 max-w-lg">
            <div class="mb-8 fade-up">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-12 w-12 rounded-xl bg-primary flex items-center justify-center text-primary-foreground shadow-lg shadow-primary/25">
                        <i data-lucide="building" class="h-6 w-6"></i>
                    </div>
                    <span class="font-headline text-3xl font-bold tracking-tight">SalesHostel Digital</span>
                </div>
                <h1 class="text-4xl font-bold tracking-tight mb-4">Join Us Today</h1>
                <p class="text-lg text-muted-foreground">
                    Create an account to start managing your inventory, tracking sales, and growing your business.
                </p>
            </div>
            
            <!-- Abstract Visual -->
            <div class="relative aspect-square w-full max-w-md mx-auto fade-up stagger-1">
                <div class="absolute inset-0 bg-gradient-to-tr from-primary/20 to-secondary/20 rounded-full blur-3xl animate-pulse"></div>
                <div class="glass-card absolute inset-4 rounded-2xl p-6 transform -rotate-3 hover:rotate-0 transition-all duration-500 shadow-2xl">
                    <div class="h-full w-full bg-background/50 rounded-xl border border-border/50 flex items-center justify-center">
                        <i data-lucide="user-plus" class="h-24 w-24 text-primary/20"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Signup Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 relative">
        <div class="w-full max-w-md space-y-8 fade-up stagger-2">
            <div class="text-center lg:text-left">
                <div class="flex lg:hidden justify-center mb-6">
                    <div class="h-12 w-12 rounded-xl bg-primary flex items-center justify-center text-primary-foreground shadow-lg shadow-primary/25">
                        <i data-lucide="building" class="h-6 w-6"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-bold tracking-tight">Create an account</h2>
                <p class="text-muted-foreground mt-2">Enter your details below to get started</p>
            </div>

            <form id="signupForm" class="space-y-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="name">Full Name</label>
                    <input class="flex h-11 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary" id="name" placeholder="John Doe" name="name" type="text" required>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">Email</label>
                    <input class="flex h-11 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary" id="email" placeholder="name@example.com" name="email" type="email" required>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="password">Password</label>
                    <input class="flex h-11 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary" id="password" name="password" type="password" required>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="phone">Phone (Optional)</label>
                    <input class="flex h-11 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary" id="phone" placeholder="+234..." name="phone" type="tel">
                </div>

                <button id="submitBtn" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-11 px-8 w-full shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-0.5 transition-all duration-200 mt-4" type="submit">
                    Create Account
                </button>
            </form>

            <div class="text-center text-sm">
                <span class="text-muted-foreground">Already have an account?</span>
                <a href="login.php" class="font-medium text-primary hover:underline ml-1">Login</a>
            </div>
        </div>
    </div>
</div>

<div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>

<script src="/assets/js/config.js"></script>
<script src="/assets/js/api.js"></script>
<script src="/assets/js/main.js"></script>
<script>
    lucide.createIcons();

    // GSAP Animations
    document.addEventListener('DOMContentLoaded', () => {
        gsap.to(".fade-up", {
            y: 0,
            opacity: 1,
            duration: 0.8,
            stagger: 0.2,
            ease: "power3.out"
        });
    });

    const signupForm = document.getElementById('signupForm');
    const submitBtn = document.getElementById('submitBtn');

    if (signupForm) {
        signupForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const phone = document.getElementById('phone').value;

            // Disable button and show loading state
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i data-lucide="loader-2" class="animate-spin h-4 w-4 mr-2"></i> Creating account...';
            lucide.createIcons();

            try {
                await AuthService.signup({ name, email, password, phone });
                showToast('Account created successfully! Redirecting to login...', 'success');
                setTimeout(() => {
                    window.location.href = '/login.php';
                }, 1500);
            } catch (error) {
                showToast(error.message, 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }
</script>
</body>
</html>
