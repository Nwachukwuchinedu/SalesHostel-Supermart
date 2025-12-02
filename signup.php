<?php include 'includes/head.php'; ?>

<div class="flex min-h-screen items-center justify-center p-4">
    <div class="w-full max-w-sm rounded-xl border bg-card text-card-foreground shadow">
        <div class="flex flex-col space-y-1.5 p-6 text-center">
            <div class="flex justify-center items-center gap-2">
                <i data-lucide="building" class="h-8 w-8 text-primary"></i>
                <h3 class="font-semibold tracking-tight text-3xl font-headline">SalesHostel Digital</h3>
            </div>
            <p class="text-sm text-muted-foreground">Create an account to get started</p>
        </div>
        <div class="p-6 pt-0">
            <form id="signupForm" class="grid gap-4">
                <div class="grid gap-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="name">Full Name</label>
                    <input class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" id="name" placeholder="John Doe" name="name" type="text" required>
                </div>
                <div class="grid gap-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">Email</label>
                    <input class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" id="email" placeholder="m@example.com" name="email" type="email" required>
                </div>
                <div class="grid gap-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="password">Password</label>
                    <input class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" id="password" name="password" type="password" required>
                </div>
                <div class="grid gap-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="phone">Phone (Optional)</label>
                    <input class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" id="phone" placeholder="+234..." name="phone" type="tel">
                </div>
                <button id="submitBtn" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground shadow hover:bg-primary/90 h-9 px-4 py-2 w-full" type="submit">
                    Create an account
                </button>
            </form>
            <div class="mt-4 text-center text-sm">
                Already have an account? 
                <a href="login.php" class="underline">
                    Login
                </a>
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
            submitBtn.disabled = true;
            submitBtn.textContent = 'Creating account...';

            try {
                await AuthService.signup({ name, email, password, phone });
                showToast('Account created successfully! Redirecting to login...', 'success');
                setTimeout(() => {
                    window.location.href = '/login.php';
                }, 1500);
            } catch (error) {
                showToast(error.message, 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Create an account';
            }
        });
    }
</script>
</body>
</html>
