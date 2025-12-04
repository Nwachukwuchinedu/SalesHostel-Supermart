<?php include 'head.php'; ?>

    <!-- Navbar -->
    <header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-transparent">
        <div class="container mx-auto flex h-16 items-center justify-between px-4 md:px-6">
            <a href="/" class="flex items-center gap-2">
                <i data-lucide="shopping-basket" class="h-6 w-6 text-primary"></i>
                <span class="font-headline text-lg font-semibold bg-gradient-to-r from-primary to-blue-600 bg-clip-text text-transparent">
                    Shop12mart
                </span>
            </a>
            <nav class="hidden items-center gap-6 md:flex" itemscope itemtype="http://schema.org/SiteNavigationElement">
                <a href="#features" itemprop="url" class="text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
                    <span itemprop="name">Why Us</span>
                </a>
                <a href="#products" itemprop="url" class="text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
                    <span itemprop="name">Products</span>
                </a>
                <a href="/about" itemprop="url" class="text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
                    <span itemprop="name">About Us</span>
                </a>
                <a href="/contact" itemprop="url" class="text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
                    <span itemprop="name">Contact</span>
                </a>
            </nav>
            <div class="hidden items-center gap-2 md:flex">
                <button id="search-trigger" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10 mr-2">
                    <i data-lucide="search" class="h-5 w-5"></i>
                </button>
                <a href="/cart" class="relative inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10 mr-2">
                    <i data-lucide="shopping-cart" class="h-5 w-5"></i>
                    <span id="cart-count" class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-primary text-[10px] font-bold text-primary-foreground hidden">0</span>
                </a>
                <a href="login" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">Login</a>
                <a href="signup" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">Sign Up</a>
            </div>
            <div class="md:hidden flex items-center gap-2">
                <button id="mobile-search-trigger" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10">
                    <i data-lucide="search" class="h-5 w-5"></i>
                </button>
                <a href="/cart" class="relative inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10">
                    <i data-lucide="shopping-cart" class="h-5 w-5"></i>
                    <span id="mobile-cart-count" class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-primary text-[10px] font-bold text-primary-foreground hidden">0</span>
                </a>
                <button id="mobile-menu-btn" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10">
                    <i data-lucide="menu" class="h-6 w-6" id="menu-icon"></i>
                    <span class="sr-only">Toggle menu</span>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-card border-t">
            <nav class="flex flex-col gap-4 p-4">
                <a href="#features" class="text-sm font-medium text-muted-foreground transition-colors hover:text-foreground mobile-link">Why Us</a>
                <a href="#products" class="text-sm font-medium text-muted-foreground transition-colors hover:text-foreground mobile-link">Products</a>
                <a href="/about" class="text-sm font-medium text-muted-foreground transition-colors hover:text-foreground mobile-link">About Us</a>
                <a href="/contact" class="text-sm font-medium text-muted-foreground transition-colors hover:text-foreground mobile-link">Contact</a>
                <div class="flex items-center gap-2 mt-2">
                    <a href="login" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 w-full">Login</a>
                    <a href="signup" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full">Sign Up</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Search Overlay -->
    <div id="search-overlay" class="fixed inset-0 z-[60] bg-background/80 backdrop-blur-md hidden transition-all duration-300">
        <div class="container mx-auto px-4 py-6 h-full flex flex-col">
            <div class="flex items-center justify-end mb-8">
                <button id="close-search" class="inline-flex items-center justify-center rounded-full bg-muted/50 p-2 hover:bg-muted transition-colors">
                    <i data-lucide="x" class="h-6 w-6"></i>
                </button>
            </div>
            
            <div class="w-full max-w-3xl mx-auto space-y-8 flex-1 flex flex-col">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 h-6 w-6 text-muted-foreground"></i>
                    <input type="text" id="search-input" placeholder="Search for products..." class="w-full h-16 pl-14 pr-4 rounded-2xl border-2 border-border bg-background text-xl shadow-lg focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all">
                </div>
                
                <div id="search-results" class="flex-1 overflow-y-auto space-y-4 pr-2 custom-scrollbar">
                    <!-- Results will appear here -->
                    <div class="text-center text-muted-foreground py-12">
                        Start typing to search...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchOverlay = document.getElementById('search-overlay');
            const searchInput = document.getElementById('search-input');
            const searchResults = document.getElementById('search-results');
            const closeSearchBtn = document.getElementById('close-search');
            const searchTriggers = [
                document.getElementById('search-trigger'),
                document.getElementById('mobile-search-trigger')
            ];

            // Open Search
            searchTriggers.forEach(trigger => {
                if(trigger) {
                    trigger.addEventListener('click', () => {
                        searchOverlay.classList.remove('hidden');
                        // Prevent body scroll if desired, but user asked to keep it scrollable.
                        // However, usually overlays lock scroll. User said "Make sure the page is still able to scroll after adding this".
                        // This likely means "don't break scrolling permanently".
                        // I will NOT lock scroll to strictly follow "page is still able to scroll".
                        // But for better UX, usually we lock. I'll stick to user request.
                        setTimeout(() => searchInput.focus(), 100);
                    });
                }
            });

            // Close Search
            const closeSearch = () => {
                searchOverlay.classList.add('hidden');
                searchInput.value = '';
                searchResults.innerHTML = '<div class="text-center text-muted-foreground py-12">Start typing to search...</div>';
            };

            closeSearchBtn.addEventListener('click', closeSearch);
            
            // Close on Escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !searchOverlay.classList.contains('hidden')) {
                    closeSearch();
                }
            });

            // Live Search
            let debounceTimer;
            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.trim();
                
                clearTimeout(debounceTimer);
                
                if (query.length === 0) {
                    searchResults.innerHTML = '<div class="text-center text-muted-foreground py-12">Start typing to search...</div>';
                    return;
                }

                debounceTimer = setTimeout(async () => {
                    searchResults.innerHTML = '<div class="flex justify-center py-12"><i data-lucide="loader-2" class="h-8 w-8 animate-spin text-primary"></i></div>';
                    
                    try {
                        // Use PublicService if available, otherwise fallback or check if it's loaded
                        if (typeof PublicService === 'undefined') {
                            console.error('PublicService not loaded');
                            return;
                        }

                        const result = await PublicService.getAllProducts({ search: query, limit: 10 });
                        
                        if (result.success && result.data.length > 0) {
                            searchResults.innerHTML = result.data.map(product => `
                                <div class="flex items-center gap-4 p-4 rounded-xl bg-card border hover:border-primary/50 transition-colors cursor-pointer group" onclick="window.location.href='/#products'">
                                    <div class="h-16 w-16 rounded-lg bg-muted overflow-hidden flex-shrink-0">
                                        ${product.images && product.images.length > 0 
                                            ? `<img src="${product.images[0]}" class="h-full w-full object-cover" alt="${product.name}">`
                                            : `<div class="h-full w-full flex items-center justify-center text-muted-foreground"><i data-lucide="image" class="h-6 w-6"></i></div>`
                                        }
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold truncate group-hover:text-primary transition-colors">${product.name}</h4>
                                        <p class="text-sm text-muted-foreground truncate">${product.description || ''}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs font-medium bg-muted px-2 py-0.5 rounded">${product.group || 'General'}</span>
                                            <span class="text-sm font-bold text-primary">₦${parseFloat(product.sellingPrice).toLocaleString()}</span>
                                        </div>
                                    </div>
                                    <i data-lucide="chevron-right" class="h-5 w-5 text-muted-foreground group-hover:text-primary"></i>
                                </div>
                            `).join('');
                            lucide.createIcons();
                        } else {
                            searchResults.innerHTML = '<div class="text-center text-muted-foreground py-12">No products found matching your search.</div>';
                        }
                    } catch (error) {
                        console.error('Search error:', error);
                        searchResults.innerHTML = '<div class="text-center text-red-500 py-12">Failed to search products.</div>';
                    }
                }, 300); // 300ms debounce
            });
        });
    </script>
