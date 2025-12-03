<?php include __DIR__ . '/includes/head.php'; ?>
<div class="flex min-h-screen flex-col items-center justify-center bg-muted/20 p-4 text-center">
    <div class="glass-card max-w-md space-y-6 p-8 rounded-xl fade-up">
        <div class="flex justify-center">
            <div class="p-4 bg-primary/10 rounded-full text-primary">
                <i data-lucide="file-question" class="h-12 w-12"></i>
            </div>
        </div>
        <h1 class="text-4xl font-headline font-bold tracking-tight">404</h1>
        <h2 class="text-xl font-semibold">Page Not Found</h2>
        <p class="text-muted-foreground">
            The page you are looking for doesn't exist or has been moved.
        </p>
        <div class="pt-4">
            <a href="/" class="inline-flex items-center justify-center rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20">
                <i data-lucide="home" class="mr-2 h-4 w-4"></i>
                Back to Home
            </a>
        </div>
    </div>
</div>
<script>
    lucide.createIcons();
    document.addEventListener('DOMContentLoaded', () => {
        gsap.to(".fade-up", {
            y: 0,
            opacity: 1,
            duration: 0.6,
            ease: "power2.out"
        });
    });
</script>
</body>
</html>
