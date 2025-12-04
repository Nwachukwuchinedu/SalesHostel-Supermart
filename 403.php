<?php 
http_response_code(403);
$pageTitle = "403 Forbidden";
$pageDescription = "You do not have permission to access this page.";
include 'includes/head.php'; 
?>

<div class="min-h-screen w-full flex flex-col items-center justify-center relative overflow-hidden bg-background">
    <!-- Uneven Faded Grid Background -->
    <div class="bg-grid-uneven fixed inset-0 pointer-events-none"></div>
    
    <div class="container px-4 md:px-6 flex flex-col items-center text-center space-y-8 z-10 fade-up">
        <div class="relative">
            <div class="absolute inset-0 bg-red-500/20 blur-3xl rounded-full"></div>
            <div class="relative bg-card/50 backdrop-blur-xl border border-border/50 p-8 rounded-2xl shadow-2xl">
                <i data-lucide="shield-alert" class="h-24 w-24 text-red-500 mx-auto mb-4"></i>
                <h1 class="text-6xl font-bold tracking-tighter mb-2">403</h1>
                <h2 class="text-2xl font-semibold text-muted-foreground">Access Denied</h2>
            </div>
        </div>
        
        <div class="max-w-[600px] space-y-4">
            <p class="text-xl text-muted-foreground">
                Oops! You don't have permission to view this page.
            </p>
            <p class="text-sm text-muted-foreground">
                It looks like you're trying to access a restricted area. If you believe this is a mistake, please contact your administrator.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 min-w-[300px] justify-center">
            <button onclick="history.back()" class="inline-flex items-center justify-center rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-11 px-8">
                <i data-lucide="arrow-left" class="mr-2 h-4 w-4"></i>
                Go Back
            </button>
            <a href="/" class="inline-flex items-center justify-center rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-11 px-8 shadow-lg shadow-primary/20">
                <i data-lucide="home" class="mr-2 h-4 w-4"></i>
                Back to Home
            </a>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
    
    // GSAP Animation
    document.addEventListener('DOMContentLoaded', () => {
        gsap.to(".fade-up", {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: "power3.out"
        });
    });
</script>
</body>
</html>
