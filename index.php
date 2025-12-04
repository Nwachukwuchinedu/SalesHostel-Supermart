<?php 
$pageTitle = "Home";
$pageDescription = "Your one-stop shop for daily essentials, groceries, and household items. Fast delivery and secure payments.";
include 'includes/header.php'; 
?>

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
                                Your Daily Essentials, <span class="text-primary">Delivered</span> with Care
                            </h1>
                            <p class="max-w-[600px] text-muted-foreground text-lg md:text-xl fade-up stagger-1">
                                Experience the most seamless way to shop for groceries, household items, and more. Quality products, competitive prices, and fast delivery.
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4 fade-up stagger-2">
                            <a href="signup" class="inline-flex h-12 items-center justify-center rounded-lg bg-primary px-8 text-base font-medium text-primary-foreground shadow-lg transition-transform hover:scale-105 hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                                Start Shopping
                            </a>
                            <a href="#products" class="inline-flex h-12 items-center justify-center rounded-lg border border-input bg-background/50 backdrop-blur-sm px-8 text-base font-medium shadow-sm transition-transform hover:scale-105 hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                                Browse Catalog
                            </a>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-muted-foreground fade-up stagger-3">
                            <div class="flex -space-x-2">
                                <div class="h-8 w-8 rounded-full border-2 border-background bg-gray-200"></div>
                                <div class="h-8 w-8 rounded-full border-2 border-background bg-gray-300"></div>
                                <div class="h-8 w-8 rounded-full border-2 border-background bg-gray-400"></div>
                            </div>
                            <p>Loved by 1,000+ happy customers</p>
                        </div>
                    </div>
                    
                    <!-- 3D Abstract / Product Mockup Area -->
                    <div class="relative lg:h-[600px] flex items-center justify-center fade-up stagger-2">
                        <div class="relative w-full max-w-[600px] aspect-square">
                            <!-- Abstract Shapes -->
                            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full blur-3xl animate-pulse"></div>
                            <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
                            
                            <!-- Glassmorphic Card Mockup -->
                            <div class="absolute inset-4 glass-card rounded-2xl p-6 transform rotate-2 hover:rotate-0 transition-transform duration-500 flex items-center justify-center">
                                <div class="text-center space-y-4">
                                    <div class="h-32 w-32 bg-primary/10 rounded-full mx-auto flex items-center justify-center">
                                        <i data-lucide="shopping-bag" class="h-16 w-16 text-primary"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold">Premium Quality</h3>
                                    <p class="text-muted-foreground">Hand-picked items just for you.</p>
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
                        Why Shop With Us?
                    </h2>
                    <p class="text-muted-foreground text-lg">
                        We prioritize your convenience and satisfaction above all else.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-[300px]">
                    <!-- Large Card 1 -->
                    <div class="md:col-span-2 glass-card rounded-2xl p-8 flex flex-col justify-between hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                        <div class="space-y-2">
                            <div class="h-12 w-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                                <i data-lucide="truck" class="h-6 w-6"></i>
                            </div>
                            <h3 class="text-2xl font-bold">Fast & Reliable Delivery</h3>
                            <p class="text-muted-foreground">Get your orders delivered to your doorstep in record time. We ensure your items arrive fresh and in perfect condition.</p>
                        </div>
                        <div class="w-full h-32 bg-gradient-to-t from-primary/5 to-transparent rounded-lg mt-4 border border-primary/10"></div>
                    </div>

                    <!-- Tall Card 1 -->
                    <div class="md:row-span-2 glass-card rounded-2xl p-8 flex flex-col hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                        <div class="h-12 w-12 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary mb-4 group-hover:scale-110 transition-transform">
                            <i data-lucide="smartphone" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Shop on the Go</h3>
                        <p class="text-muted-foreground mb-8">Our platform is optimized for mobile, making it easy to browse and buy wherever you are.</p>
                        <div class="flex-1 bg-muted/50 rounded-xl border border-border/50 relative overflow-hidden">
                            <div class="absolute inset-x-4 top-4 bottom-0 bg-background rounded-t-xl shadow-lg border border-border"></div>
                        </div>
                    </div>

                    <!-- Small Card 1 -->
                    <div class="glass-card rounded-2xl p-8 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                        <div class="h-12 w-12 rounded-lg bg-orange-500/10 flex items-center justify-center text-orange-600 mb-4 group-hover:scale-110 transition-transform">
                            <i data-lucide="star" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Top Quality</h3>
                        <p class="text-muted-foreground text-sm">We source only the best products for our customers.</p>
                    </div>

                    <!-- Small Card 2 -->
                    <div class="glass-card rounded-2xl p-8 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                        <div class="h-12 w-12 rounded-lg bg-green-500/10 flex items-center justify-center text-green-600 mb-4 group-hover:scale-110 transition-transform">
                            <i data-lucide="shield-check" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Secure Payments</h3>
                        <p class="text-muted-foreground text-sm">Your transactions are safe and encrypted.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products Section -->
        <section id="products" class="w-full py-24 relative">
            <div class="container mx-auto px-4 md:px-6">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                    <h2 class="text-3xl font-headline font-bold tracking-tight sm:text-4xl md:text-5xl">
                        Fresh Arrivals
                    </h2>
                    <p class="text-muted-foreground text-lg">
                        Check out some of our most popular items this week.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="products-grid">
                    <!-- Products will be injected here via JS -->
                    <div class="col-span-full flex justify-center py-12">
                        <i data-lucide="loader-2" class="h-8 w-8 animate-spin text-primary"></i>
                    </div>
                </div>
                
                <div class="mt-12 text-center">
                    <a href="signup" class="inline-flex items-center justify-center rounded-lg border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-8 py-2 transition-colors">
                        View All Products
                    </a>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="w-full py-24 bg-muted/30">
            <div class="container mx-auto px-4 md:px-6">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                    <h2 class="text-3xl font-headline font-bold tracking-tight sm:text-4xl">
                        What Our Customers Say
                    </h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="glass-card p-8 rounded-xl space-y-4">
                        <div class="flex gap-1 text-yellow-500">
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                        </div>
                        <p class="text-muted-foreground italic">"I love shopping here! The delivery is always on time, and the produce is fresher than what I get at the open market."</p>
                        <div class="flex items-center gap-3 pt-4 border-t border-border/50">
                            <div class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center font-bold text-primary">CJ</div>
                            <div>
                                <div class="font-semibold">Chinedu J.</div>
                                <div class="text-xs text-muted-foreground">Verified Customer</div>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card p-8 rounded-xl space-y-4">
                        <div class="flex gap-1 text-yellow-500">
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                        </div>
                        <p class="text-muted-foreground italic">"The mobile site is so easy to use. I can order my weekly groceries while on the bus home from work. Highly recommended!"</p>
                        <div class="flex items-center gap-3 pt-4 border-t border-border/50">
                            <div class="h-10 w-10 rounded-full bg-secondary/20 flex items-center justify-center font-bold text-secondary">AM</div>
                            <div>
                                <div class="font-semibold">Amina M.</div>
                                <div class="text-xs text-muted-foreground">Verified Customer</div>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card p-8 rounded-xl space-y-4">
                        <div class="flex gap-1 text-yellow-500">
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <i data-lucide="star-half" class="h-4 w-4 fill-current"></i>
                        </div>
                        <p class="text-muted-foreground italic">"Great customer service. I had an issue with one item, and they resolved it immediately. Will definitely buy again."</p>
                        <div class="flex items-center gap-3 pt-4 border-t border-border/50">
                            <div class="h-10 w-10 rounded-full bg-orange-500/20 flex items-center justify-center font-bold text-orange-600">DA</div>
                            <div>
                                <div class="font-semibold">David A.</div>
                                <div class="text-xs text-muted-foreground">Verified Customer</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="w-full py-20 border-y bg-background/50 backdrop-blur-sm">
            <div class="container mx-auto px-4 md:px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div class="space-y-2">
                        <h3 class="text-4xl font-bold text-primary">5k+</h3>
                        <p class="text-sm text-muted-foreground font-medium uppercase tracking-wider">Happy Customers</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-4xl font-bold text-primary">1000+</h3>
                        <p class="text-sm text-muted-foreground font-medium uppercase tracking-wider">Products</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-4xl font-bold text-primary">24h</h3>
                        <p class="text-sm text-muted-foreground font-medium uppercase tracking-wider">Delivery Avg.</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-4xl font-bold text-primary">4.9</h3>
                        <p class="text-sm text-muted-foreground font-medium uppercase tracking-wider">Customer Rating</p>
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
                        Ready to Start Shopping?
                    </h2>
                    <p class="text-muted-foreground text-lg">
                        Join our community of satisfied customers and experience the best in retail.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="signup" class="inline-flex h-12 items-center justify-center rounded-lg bg-primary px-8 text-base font-medium text-primary-foreground shadow-lg transition-transform hover:scale-105 hover:bg-primary/90">
                            Create Free Account
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

        // Fetch and Render Products
        fetchProducts();

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

    async function fetchProducts() {
        const grid = document.getElementById('products-grid');
        try {
            // Check for group filter in URL hash
            const hashParams = new URLSearchParams(window.location.hash.split('?')[1]);
            const groupFilter = hashParams.get('group');
            
            const params = { limit: 8 }; // Fetch top 8 products
            if (groupFilter) params.group = groupFilter;

            const result = await PublicService.getAllProducts(params);
            
            if (result.success && result.data.length > 0) {
                const products = result.data;
                
                grid.innerHTML = products.map(product => {
                    const price = parseFloat(product.sellingPrice || 0).toLocaleString('en-NG', { minimumFractionDigits: 2 });
                    // Use first image if available, otherwise placeholder
                    const imageHtml = (product.images && product.images.length > 0) 
                        ? `<img src="${product.images[0]}" alt="${product.name}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">`
                        : `<div class="absolute inset-0 flex items-center justify-center text-muted-foreground/20"><i data-lucide="image" class="h-12 w-12"></i></div>`;

                    return `
                    <div class="glass-card rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group fade-up">
                        <div class="aspect-square bg-muted/50 relative overflow-hidden">
                            ${imageHtml}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <button onclick='addToCart(${JSON.stringify({id: product.id, name: product.name, price: product.sellingPrice, image: product.images[0] || null}).replace(/'/g, "&#39;")})' class="w-full bg-primary text-primary-foreground py-2 rounded-lg font-medium text-sm shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">Add to Cart</button>
                            </div>
                            ${product.quantityAvailable < 10 ? `<span class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full">Low Stock</span>` : ''}
                        </div>
                        <div class="p-4 space-y-2">
                            <div class="flex justify-between items-start">
                                <h3 class="font-semibold truncate pr-2" title="${product.name}">${product.name}</h3>
                                <span class="text-sm font-bold text-primary whitespace-nowrap">₦${price}</span>
                            </div>
                            <p class="text-xs text-muted-foreground line-clamp-2 h-8">${product.description || 'No description available.'}</p>
                            <div class="flex items-center justify-between pt-1">
                                <span class="text-[10px] uppercase tracking-wider text-muted-foreground bg-muted px-2 py-1 rounded-md">${product.group || 'General'}</span>
                                <div class="flex items-center gap-0.5 text-yellow-500 text-xs">
                                    <i data-lucide="star" class="h-3 w-3 fill-current"></i>
                                    <span class="text-muted-foreground ml-1">(5.0)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                }).join('');
                
                // Re-initialize icons
                lucide.createIcons();
                
                // Animate new elements
                gsap.fromTo(".fade-up", 
                    { y: 20, opacity: 0 },
                    { y: 0, opacity: 1, duration: 0.6, stagger: 0.1, ease: "power2.out" }
                );

            } else {
                grid.innerHTML = '<div class="col-span-full text-center py-12 text-muted-foreground">No products found.</div>';
            }
        } catch (error) {
            console.error('Failed to fetch products:', error);
            grid.innerHTML = '<div class="col-span-full text-center py-12 text-red-500">Failed to load products. Please try again later.</div>';
        }
    }

    // Wrapper for CartService.addToCart to be used in inline onclick
    window.addToCart = (product) => {
        CartService.addToCart(product);
    };

    // Listen for hash changes to re-fetch if filtering is implemented
    window.addEventListener('hashchange', () => {
        if(window.location.hash.includes('products')) {
            fetchProducts();
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
