<?php include __DIR__ . '/../includes/head.php'; ?>

<div class="flex min-h-screen w-full flex-col bg-muted/20">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="flex flex-col sm:gap-4 sm:py-4 md:ml-64 transition-all duration-300">
        <?php include __DIR__ . '/../includes/dashboard_header.php'; ?>
        
        <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <div class="flex flex-col gap-8">
                <!-- Header -->
                <div class="flex flex-col gap-2 fade-up">
                    <h1 class="text-3xl font-headline font-bold tracking-tight">Shop</h1>
                    <p class="text-muted-foreground">Browse our fresh arrivals and everyday essentials.</p>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="products-grid">
                    <!-- Products will be injected here via JS -->
                    <div class="col-span-full flex justify-center py-12">
                        <i data-lucide="loader-2" class="h-8 w-8 animate-spin text-primary"></i>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>

<script src="/assets/js/auth-middleware.js"></script>
<script src="/assets/js/config.js"></script>
<script src="/assets/js/api.js"></script>
<script src="/assets/js/main.js"></script>
<script>
    lucide.createIcons();
    
    document.addEventListener('DOMContentLoaded', () => {
        gsap.to(".fade-up", {
            y: 0,
            opacity: 1,
            duration: 0.6,
            stagger: 0.1,
            ease: "power2.out"
        });
        
        fetchProducts();
    });

    async function fetchProducts() {
        const grid = document.getElementById('products-grid');
        try {
            const result = await PublicService.getAllProducts({ limit: 20 });
            
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
</script>
</body>
</html>
