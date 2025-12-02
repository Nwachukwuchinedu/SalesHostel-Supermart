<?php include 'includes/head.php'; ?>

<div class="flex min-h-screen items-center justify-center p-4">
    <div class="w-full max-w-sm rounded-xl border bg-card text-card-foreground shadow">
        <div class="flex flex-col space-y-1.5 p-6 text-center">
            <div class="flex justify-center items-center gap-2">
                <i data-lucide="building" class="h-8 w-8 text-primary"></i>
                <h3 class="font-semibold tracking-tight text-3xl font-headline">SalesHostel Digital</h3>
            </div>
            <p class="text-sm text-muted-foreground">Login to your account</p>
        </div>
        <div class="p-6 pt-0">
            <form id="loginForm" class="grid gap-4">
                <div class="grid gap-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">Email</label>
                    <input class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" id="email" placeholder="m@example.com" name="email" type="email" required>
                </div>
                <div class="grid gap-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="password">Password</label>
                    <input class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" id="password" name="password" type="password" required>
                </div>
                <button id="submitBtn" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground shadow hover:bg-primary/90 h-9 px-4 py-2 w-full" type="submit">
                    Login
                </button>
            </form>
            <div class="mt-4 text-center text-sm">
                Don&apos;t have an account? 
                <a href="signup.php" class="underline">
                    Sign up
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

    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');

    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.textContent = 'Logging in...';

            try {
                await AuthService.login(email, password);
                showToast('Login successful! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = '/dashboard/index.php';
                }, 1000);
            } catch (error) {
                showToast(error.message, 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Login';
            }
        });
    }
</script>
</body>
</html>
