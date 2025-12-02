<?php
$current_page = basename($_SERVER['PHP_SELF']);
$nav_links = [
    ['href' => '/dashboard/index.php', 'label' => 'Dashboard', 'icon' => 'layout-dashboard'],
    ['href' => '/dashboard/products.php', 'label' => 'Products', 'icon' => 'box'],
    ['href' => '/dashboard/supplies.php', 'label' => 'Supplies', 'icon' => 'truck'],
    ['href' => '/dashboard/purchases.php', 'label' => 'Purchases', 'icon' => 'shopping-cart'],
    ['href' => '/dashboard/reports.php', 'label' => 'Reports', 'icon' => 'bar-chart'],
];

// Helper function to check if link is active
function isActive($href, $current_page) {
    // Simple check: if current page is index.php and href contains index.php
    if (strpos($href, $current_page) !== false) {
        return true;
    }
    // Or if we are in a subdirectory, check if href matches
    return false; 
}
?>

<aside class="hidden md:flex w-64 flex-col border-r bg-card h-screen fixed left-0 top-0 z-30">
    <div class="flex h-16 items-center border-b px-6">
        <a href="/index.php" class="flex items-center gap-2 font-semibold">
            <i data-lucide="building" class="h-6 w-6 text-primary"></i>
            <span class="font-headline text-lg">SalesHostel</span>
        </a>
    </div>
    <div class="flex-1 overflow-auto py-4">
        <nav class="grid items-start px-4 text-sm font-medium">
            <?php foreach ($nav_links as $link): ?>
                <a href="<?php echo $link['href']; ?>" 
                   class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all hover:text-primary <?php echo isActive($link['href'], $current_page) ? 'bg-muted text-primary' : 'text-muted-foreground'; ?>">
                    <i data-lucide="<?php echo $link['icon']; ?>" class="h-4 w-4"></i>
                    <?php echo $link['label']; ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
    <div class="mt-auto border-t p-4">
        <nav class="grid gap-1">
            <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary">
                <i data-lucide="settings" class="h-4 w-4"></i>
                Settings
            </a>
            <a href="/login.php" class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary">
                <i data-lucide="log-out" class="h-4 w-4"></i>
                Logout
            </a>
        </nav>
    </div>
</aside>

<!-- Mobile Sidebar Overlay (Hidden by default) -->
<div id="mobile-sidebar-overlay" class="fixed inset-0 z-40 bg-background/80 backdrop-blur-sm hidden md:hidden"></div>
<aside id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-card border-r shadow-lg transform -translate-x-full transition-transform duration-300 md:hidden">
    <div class="flex h-16 items-center border-b px-6 justify-between">
        <a href="index.php" class="flex items-center gap-2 font-semibold">
            <i data-lucide="building" class="h-6 w-6 text-primary"></i>
            <span class="font-headline text-lg">SalesHostel</span>
        </a>
        <button id="close-sidebar" class="md:hidden">
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>
    </div>
    <div class="flex-1 overflow-auto py-4">
        <nav class="grid items-start px-4 text-sm font-medium">
            <?php foreach ($nav_links as $link): ?>
                <a href="<?php echo $link['href']; ?>" 
                   class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all hover:text-primary <?php echo isActive($link['href'], $current_page) ? 'bg-muted text-primary' : 'text-muted-foreground'; ?>">
                    <i data-lucide="<?php echo $link['icon']; ?>" class="h-4 w-4"></i>
                    <?php echo $link['label']; ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
    <div class="mt-auto border-t p-4">
        <nav class="grid gap-1">
            <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary">
                <i data-lucide="settings" class="h-4 w-4"></i>
                Settings
            </a>
            <a href="login.php" class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary">
                <i data-lucide="log-out" class="h-4 w-4"></i>
                Logout
            </a>
        </nav>
    </div>
</aside>
