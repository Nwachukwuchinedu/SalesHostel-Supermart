<?php include 'includes/header.php'; ?>

<div class="flex flex-col min-h-screen relative overflow-hidden">
    <!-- Uneven Faded Grid Background -->
    <div class="bg-grid-uneven fixed inset-0 pointer-events-none"></div>

    <main class="flex-1 relative z-10">
        <!-- Hero Section -->
        <section class="w-full py-24 md:py-32 lg:py-40 relative">
            <div class="container mx-auto px-4 md:px-6 relative z-10">
                <div class="grid gap-12 lg:grid-cols-2 items-center">
                    <div class="flex flex-col justify-center space-y-8">
                        <div class="space-y-4">
                            <h1 class="text-5xl font-headline font-bold tracking-tight sm:text-6xl md:text-7xl text-foreground fade-up">
                                Manage Your <span class="text-primary">Inventory</span> with Confidence
                            </h1>
                            <p class="max-w-[600px] text-muted-foreground text-lg md:text-xl fade-up stagger-1">
                                The all-in-one platform for modern retail. Track sales, manage suppliers, and grow your business with real-time insights.
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4 fade-up stagger-2">
                            <a href="signup" class="inline-flex h-12 items-center justify-center rounded-lg bg-primary px-8 text-base font-medium text-primary-foreground shadow-lg transition-transform hover:scale-105 hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                                Start Free Trial
                            </a>
                            <a href="#features" class="inline-flex h-12 items-center justify-center rounded-lg border border-input bg-background/50 backdrop-blur-sm px-8 text-base font-medium shadow-sm transition-transform hover:scale-105 hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                                View Demo
                            </a>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-muted-foreground fade-up stagger-3">
                            <div class="flex -space-x-2">
                                <div class="h-8 w-8 rounded-full border-2 border-background bg-gray-200"></div>
                                <div class="h-8 w-8 rounded-full border-2 border-background bg-gray-300"></div>
                                <div class="h-8 w-8 rounded-full border-2 border-background bg-gray-400"></div>
                            </div>
                            <p>Trusted by 500+ businesses</p>
                        </div>
                    </div>
                    
                    <!-- 3D Abstract / Dashboard Mockup Area -->
                    <div class="relative lg:h-[600px] flex items-center justify-center fade-up stagger-2">
                        <div class="relative w-full max-w-[600px] aspect-square">
                            <!-- Abstract Shapes -->
                            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full blur-3xl animate-pulse"></div>
                            <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
                            
                            <!-- Glassmorphic Card Mockup -->
                            <div class="absolute inset-4 glass-card rounded-2xl p-6 transform rotate-2 hover:rotate-0 transition-transform duration-500">
                                <div class="flex items-center justify-between mb-8">
                                    <div class="space-y-1">
                                        <div class="h-2 w-24 bg-muted rounded"></div>
                                        <div class="h-4 w-32 bg-foreground/10 rounded"></div>
                                    </div>
                                    <div class="h-10 w-10 rounded-full bg-primary/10"></div>
                                </div>
                                <div class="space-y-4">
                                    <div class="h-32 w-full bg-muted/50 rounded-lg"></div>
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="h-20 bg-muted/50 rounded-lg"></div>
                                        <div class="h-20 bg-muted/50 rounded-lg"></div>
                                        <div class="h-20 bg-muted/50 rounded-lg"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bento Grid Features Section -->
        <section id="features" class="w-full py-24 bg-muted/30 relative">
            <div class="container mx-auto px-4 md:px-6">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                    <h2 class="text-3xl font-headline font-bold tracking-tight sm:text-4xl md:text-5xl">
                        Everything You Need to Run Your Store
                    </h2>
                    <p class="text-muted-foreground text-lg">
                        Powerful features packaged in a simple, intuitive interface.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-[300px]">
                    <!-- Large Card 1 -->
                    <div class="md:col-span-2 glass-card rounded-2xl p-8 flex flex-col justify-between hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                        <div class="space-y-2">
                            <div class="h-12 w-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                                <i data-lucide="bar-chart-3" class="h-6 w-6"></i>
                            </div>
                            <h3 class="text-2xl font-bold">Real-time Analytics</h3>
                            <p class="text-muted-foreground">Monitor your sales, revenue, and profit margins instantly. Make data-driven decisions with our comprehensive reporting tools.</p>
                        </div>
                        <div class="w-full h-32 bg-gradient-to-t from-primary/5 to-transparent rounded-lg mt-4 border border-primary/10"></div>
                    </div>

                    <!-- Tall Card 1 -->
                    <div class="md:row-span-2 glass-card rounded-2xl p-8 flex flex-col hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                        <div class="h-12 w-12 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary mb-4 group-hover:scale-110 transition-transform">
                            <i data-lucide="smartphone" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Mobile First</h3>
                        <p class="text-muted-foreground mb-8">Manage your store from anywhere. Our responsive design works perfectly on all devices.</p>
                        <div class="flex-1 bg-muted/50 rounded-xl border border-border/50 relative overflow-hidden">
                            <div class="absolute inset-x-4 top-4 bottom-0 bg-background rounded-t-xl shadow-lg border border-border"></div>
                        </div>
                    </div>

                    <!-- Small Card 1 -->
                    <div class="glass-card rounded-2xl p-8 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                        <div class="h-12 w-12 rounded-lg bg-orange-500/10 flex items-center justify-center text-orange-600 mb-4 group-hover:scale-110 transition-transform">
                            <i data-lucide="box" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Inventory Tracking</h3>
                        <p class="text-muted-foreground text-sm">Automated low stock alerts and easy restocking workflows.</p>
                    </div>

                    <!-- Small Card 2 -->
                    <div class="glass-card rounded-2xl p-8 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                        <div class="h-12 w-12 rounded-lg bg-green-500/10 flex items-center justify-center text-green-600 mb-4 group-hover:scale-110 transition-transform">
                            <i data-lucide="users" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Supplier Management</h3>
                        <p class="text-muted-foreground text-sm">Keep track of all your vendors and purchase history in one place.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="w-full py-20 border-y bg-background/50 backdrop-blur-sm">
            <div class="container mx-auto px-4 md:px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div class="space-y-2">
                        <h3 class="text-4xl font-bold text-primary">10k+</h3>
                        <p class="text-sm text-muted-foreground font-medium uppercase tracking-wider">Transactions</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-4xl font-bold text-primary">500+</h3>
                        <p class="text-sm text-muted-foreground font-medium uppercase tracking-wider">Active Stores</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-4xl font-bold text-primary">99.9%</h3>
                        <p class="text-sm text-muted-foreground font-medium uppercase tracking-wider">Uptime</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-4xl font-bold text-primary">24/7</h3>
                        <p class="text-sm text-muted-foreground font-medium uppercase tracking-wider">Support</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="w-full py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-primary/5 -z-10"></div>
            <div class="container mx-auto px-4 md:px-6 text-center">
                <div class="max-w-2xl mx-auto space-y-8">
                    <h2 class="text-3xl font-headline font-bold tracking-tight sm:text-4xl">
                        Ready to Transform Your Business?
                    </h2>
                    <p class="text-muted-foreground text-lg">
                        Join hundreds of other retailers who are saving time and increasing profits with SalesHostel Digital.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="signup" class="inline-flex h-12 items-center justify-center rounded-lg bg-primary px-8 text-base font-medium text-primary-foreground shadow-lg transition-transform hover:scale-105 hover:bg-primary/90">
                            Get Started Now
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
    // Initialize GSAP Animations
    document.addEventListener('DOMContentLoaded', () => {
        gsap.registerPlugin(ScrollTrigger);

        // Hero Animations
        gsap.to(".fade-up", {
            y: 0,
            opacity: 1,
            duration: 0.8,
            stagger: 0.2,
            ease: "power3.out"
        });

        // Bento Grid Hover Effect (Tilt)
        const cards = document.querySelectorAll('.glass-card');
        cards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                // Calculate tilt
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = ((y - centerY) / centerY) * -2; // Max 2deg rotation
                const rotateY = ((x - centerX) / centerX) * 2;

                gsap.to(card, {
                    transform: `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`,
                    duration: 0.4,
                    ease: "power2.out"
                });
            });

            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    transform: "perspective(1000px) rotateX(0) rotateY(0) scale(1)",
                    duration: 0.4,
                    ease: "power2.out"
                });
            });
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
