<?php include __DIR__ . '/../includes/head.php'; ?>

<div class="flex min-h-screen w-full flex-col bg-muted/20">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="flex flex-col sm:gap-4 sm:py-4 md:ml-64 transition-all duration-300">
        <?php include __DIR__ . '/../includes/dashboard_header.php'; ?>
        
        <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <div class="flex flex-col gap-8">
                <!-- Header -->
                <div class="flex flex-col gap-2 fade-up">
                    <h1 class="text-3xl font-headline font-bold tracking-tight">My Orders</h1>
                    <p class="text-muted-foreground">View and track your order history.</p>
                </div>

                <!-- Orders List -->
                <div class="glass-card rounded-xl border bg-card text-card-foreground shadow-sm fade-up stagger-1">
                    <div class="p-6">
                        <div class="relative w-full overflow-auto">
                            <table class="w-full caption-bottom text-sm">
                                <thead class="[&_tr]:border-b">
                                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Order ID</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Date</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Items</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                        <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Total Amount</th>
                                        <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="ordersTableBody">
                                    <tr>
                                        <td colspan="6" class="h-24 text-center text-muted-foreground">
                                            <div class="flex flex-col items-center justify-center gap-2">
                                                <i data-lucide="loader-2" class="h-6 w-6 animate-spin text-primary"></i>
                                                <span>Loading orders...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
        
        fetchOrders();
    });

    async function fetchOrders() {
        try {
            const user = AuthService.getCurrentUser();
            
            // Fetch all purchases and filter for current user
            // Ideally, backend should handle this filtering
            const res = await PurchaseService.getAllPurchases(); 
            
            // Filter for current user
            const myOrders = res.data.filter(order => order.customerId === (user.id || user._id) || order.customerName === user.name);
            
            renderOrders(myOrders);

        } catch (error) {
            console.error('Error fetching orders:', error);
            showToast('Failed to load orders', 'error');
            document.getElementById('ordersTableBody').innerHTML = `<tr><td colspan="6" class="h-24 text-center text-red-500">Failed to load orders.</td></tr>`;
        }
    }

    function renderOrders(orders) {
        const tbody = document.getElementById('ordersTableBody');
        
        if (orders.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="h-24 text-center text-muted-foreground">No orders found. <a href="/#products" class="text-primary hover:underline">Start shopping</a></td></tr>`;
            return;
        }

        // Sort by date desc
        const sortedOrders = orders.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));

        tbody.innerHTML = sortedOrders.map(order => {
            const statusColor = order.paymentStatus === 'Paid' 
                ? 'bg-green-500/10 text-green-700 border-green-200' 
                : order.paymentStatus === 'Pending' 
                ? 'bg-yellow-500/10 text-yellow-700 border-yellow-200' 
                : 'bg-gray-500/10 text-gray-700 border-gray-200';

            const itemCount = order.items ? order.items.length : 0;

            return `
            <tr class="hover:bg-muted/30 transition-colors">
                <td class="px-4 py-4 font-medium">${order.purchaseId || order._id.substring(0, 8)}</td>
                <td class="px-4 py-4 text-muted-foreground">${new Date(order.createdAt).toLocaleDateString()}</td>
                <td class="px-4 py-4 text-muted-foreground">${itemCount} item${itemCount !== 1 ? 's' : ''}</td>
                <td class="px-4 py-4">
                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors ${statusColor}">
                        ${order.paymentStatus || order.status}
                    </span>
                </td>
                <td class="px-4 py-4 text-right font-medium">₦${parseFloat(order.totalAmount || 0).toLocaleString('en-NG', { minimumFractionDigits: 2 })}</td>
                <td class="px-4 py-4 text-right">
                    <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 w-8">
                        <i data-lucide="eye" class="h-4 w-4"></i>
                    </button>
                </td>
            </tr>
        `}).join('');
        
        lucide.createIcons();
    }
</script>
</body>
</html>
