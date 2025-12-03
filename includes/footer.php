    <footer class="bg-card/50 border-t">
        <div class="container mx-auto py-12 px-4 md:px-6">
            <div class="grid gap-8 md:grid-cols-4">
                <div class="space-y-4 md:col-span-2">
                    <a href="/" class="flex items-center gap-2">
                        <i data-lucide="building" class="h-6 w-6 text-primary"></i>
                        <span class="font-headline text-lg font-semibold">
                            Shop12mart
                        </span>
                    </a>
                    <p class="text-sm text-muted-foreground max-w-sm">
                        Your one-stop shop for quality products, delivered fast and fresh to your doorstep.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-sm text-muted-foreground hover:text-foreground">Why Us</a></li>
                        <li><a href="#products" class="text-sm text-muted-foreground hover:text-foreground">Products</a></li>
                        <li><a href="/signup" class="text-sm text-muted-foreground hover:text-foreground">Sign Up</a></li>
                        <li><a href="/login" class="text-sm text-muted-foreground hover:text-foreground">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Follow Us</h4>
                    <div class="flex items-center gap-4">
                        <a href="#" class="text-muted-foreground hover:text-foreground"><i data-lucide="twitter" class="h-5 w-5"></i></a>
                        <a href="#" class="text-muted-foreground hover:text-foreground"><i data-lucide="facebook" class="h-5 w-5"></i></a>
                        <a href="#" class="text-muted-foreground hover:text-foreground"><i data-lucide="linkedin" class="h-5 w-5"></i></a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t text-center text-sm text-muted-foreground">
                <p>&copy; <?php echo date("Y"); ?> Shop12mart. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>
    <script src="/assets/js/auth-middleware.js"></script>
    <script src="/assets/js/config.js"></script>
    <script src="/assets/js/api.js"></script>
    <script src="/assets/js/main.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
