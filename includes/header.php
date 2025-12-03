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
                <a href="login" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">Login</a>
                <a href="signup" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">Sign Up</a>
            </div>
            <div class="md:hidden">
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
