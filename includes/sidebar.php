<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$nav_links = [
    ['href' => '/dashboard/', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'roles' => ['Admin', 'Staff', 'Supplier']],
    ['href' => '/user/', 'label' => 'My Dashboard', 'icon' => 'user', 'roles' => ['Customer']],
    ['href' => '/user/shop', 'label' => 'Shop', 'icon' => 'shopping-bag', 'roles' => ['Customer']],
    ['href' => '/user/cart', 'label' => 'My Cart', 'icon' => 'shopping-cart', 'roles' => ['Customer']],
    ['href' => '/user/orders', 'label' => 'My Orders', 'icon' => 'package', 'roles' => ['Customer']],
    ['href' => '/dashboard/products', 'label' => 'Products', 'icon' => 'box', 'roles' => ['Admin', 'Staff']],
    ['href' => '/dashboard/supplies', 'label' => 'Supplies', 'icon' => 'truck', 'roles' => ['Admin', 'Supplier']],
    ['href' => '/dashboard/purchases', 'label' => 'Purchases', 'icon' => 'shopping-cart', 'roles' => ['Admin', 'Staff']],
    ['href' => '/dashboard/reports', 'label' => 'Reports', 'icon' => 'bar-chart', 'roles' => ['Admin', 'Staff']],
    ['href' => '/dashboard/users', 'label' => 'Users', 'icon' => 'users', 'roles' => ['Admin']],
];

// Helper function to check if link is active
function isActive($href, $current_page) {
    // Check if the href (without /dashboard/) matches the current page name
    $page_name = str_replace('/dashboard/', '', $href);
    if ($page_name === $current_page || ($current_page === 'index' && $page_name === 'index')) {
        return true;
    }
    return false; 
}
?>

<aside class="hidden md:flex w-64 flex-col border-r border-border/50 bg-card/80 backdrop-blur-xl h-screen fixed left-0 top-0 z-30 transition-all duration-300">
    <div class="flex h-16 items-center border-b border-border/50 px-6">
        <a href="/" class="flex items-center gap-2 font-semibold">
            <div class="h-8 w-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                <i data-lucide="shopping-basket" class="h-5 w-5"></i>
            </div>
            <span class="font-headline text-lg tracking-tight">Shop12mart</span>
        </a>
    </div>
    <div class="flex-1 overflow-auto py-4">
        <nav class="grid items-start px-4 text-sm font-medium gap-1">
            <?php foreach ($nav_links as $link): ?>
                <a href="<?php echo $link['href']; ?>" 
                   data-roles='<?php echo json_encode($link['roles']); ?>'
                   class="sidebar-link flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-200 hover:text-primary hover:bg-primary/5 <?php echo isActive($link['href'], $current_page) ? 'bg-primary/10 text-primary font-semibold shadow-sm' : 'text-muted-foreground'; ?>">
                    <i data-lucide="<?php echo $link['icon']; ?>" class="h-4 w-4"></i>
                    <?php echo $link['label']; ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
    <div class="mt-auto border-t border-border/50 p-4">
        <nav class="grid gap-1">
            <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all duration-200 hover:text-primary hover:bg-primary/5">
                <i data-lucide="settings" class="h-4 w-4"></i>
                Settings
            </a>
            <a href="#" onclick="event.preventDefault(); AuthService.logout();" class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all duration-200 hover:text-primary hover:bg-primary/5">
                <i data-lucide="log-out" class="h-4 w-4"></i>
                Logout
            </a>
        </nav>
    </div>
</aside>

<!-- Mobile Sidebar Overlay (Hidden by default) -->
<div id="mobile-sidebar-overlay" class="fixed inset-0 z-40 bg-background/80 backdrop-blur-sm hidden md:hidden animate-in fade-in duration-200"></div>
<aside id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-card/95 backdrop-blur-xl border-r border-border/50 shadow-2xl transform -translate-x-full transition-transform duration-300 md:hidden">
    <div class="flex h-16 items-center border-b border-border/50 px-6 justify-between">
        <a href="/" class="flex items-center gap-2 font-semibold">
            <div class="h-8 w-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                <i data-lucide="shopping-basket" class="h-5 w-5"></i>
            </div>
            <span class="font-headline text-lg tracking-tight">Shop12mart</span>
        </a>
        <button id="close-sidebar" class="md:hidden text-muted-foreground hover:text-foreground">
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>
    </div>
    <div class="flex-1 overflow-auto py-4">
        <nav class="grid items-start px-4 text-sm font-medium gap-1">
            <?php foreach ($nav_links as $link): ?>
                <a href="<?php echo $link['href']; ?>" 
                   data-roles='<?php echo json_encode($link['roles']); ?>'
                   class="sidebar-link flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-200 hover:text-primary hover:bg-primary/5 <?php echo isActive($link['href'], $current_page) ? 'bg-primary/10 text-primary font-semibold shadow-sm' : 'text-muted-foreground'; ?>">
                    <i data-lucide="<?php echo $link['icon']; ?>" class="h-4 w-4"></i>
                    <?php echo $link['label']; ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
    <div class="mt-auto border-t border-border/50 p-4">
        <nav class="grid gap-1">
            <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all duration-200 hover:text-primary hover:bg-primary/5">
                <i data-lucide="settings" class="h-4 w-4"></i>
                Settings
            </a>
            <a href="#" onclick="event.preventDefault(); AuthService.logout();" class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all duration-200 hover:text-primary hover:bg-primary/5">
                <i data-lucide="log-out" class="h-4 w-4"></i>
                Logout
            </a>
        </nav>
    </div>
</aside>
