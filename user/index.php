<?php include __DIR__ . '/../includes/head.php'; ?>

<div class="flex min-h-screen w-full flex-col bg-muted/20">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="flex flex-col sm:gap-4 sm:py-4 md:ml-64 transition-all duration-300">
        <?php include __DIR__ . '/../includes/dashboard_header.php'; ?>
        
        <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <div class="flex flex-col gap-8">
                <!-- Welcome Banner -->
                <div class="flex flex-col gap-2 fade-up">
                    <h1 class="text-3xl font-headline font-bold tracking-tight">
                        Welcome Back, <span id="userNameDisplay" class="text-primary">Customer</span>!
                    </h1>
                    <p class="text-muted-foreground">Track your purchases and manage your account.</p>
                </div>

                <!-- KPI Cards -->
                <div class="grid gap-4 md:grid-cols-3 fade-up stagger-1">
                    <div class="glass-card rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium text-muted-foreground">Total Purchases</h3>
                            <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                <i data-lucide="shopping-bag" class="h-4 w-4"></i>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="text-2xl font-bold text-foreground" id="totalPurchases">0</div>
                        </div>
                    </div>
                    <div class="glass-card rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium text-muted-foreground">Pending Purchases</h3>
                            <div class="h-8 w-8 rounded-full bg-yellow-500/10 flex items-center justify-center text-yellow-600">
                                <i data-lucide="clock" class="h-4 w-4"></i>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="text-2xl font-bold text-foreground" id="pendingPurchases">0</div>
                        </div>
                    </div>
                    <div class="glass-card rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium text-muted-foreground">Total Spent</h3>
                            <div class="h-8 w-8 rounded-full bg-green-500/10 flex items-center justify-center text-green-600">
                                <i data-lucide="wallet" class="h-4 w-4"></i>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="text-2xl font-bold text-foreground" id="totalSpent">₦0.00</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Purchases -->
                <div class="glass-card rounded-xl border bg-card text-card-foreground shadow-sm fade-up stagger-2 w-full max-w-[calc(100vw-2rem)] md:max-w-[calc(100vw-20rem)] overflow-hidden">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="font-semibold leading-none tracking-tight">Recent Purchases</h3>
                        <p class="text-sm text-muted-foreground">View your latest purchases.</p>
                    </div>
                    <div class="p-6 pt-0">
                        <div class="relative w-full overflow-x-auto">
                            <table class="w-full caption-bottom text-sm">
                                <thead class="[&_tr]:border-b">
                                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground whitespace-nowrap">Purchase ID</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground whitespace-nowrap">Date</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground whitespace-nowrap">Status</th>
                                        <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground whitespace-nowrap">Amount</th>
                                        <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground whitespace-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="recentPurchasesTableBody">
                                    <tr>
                                        <td colspan="5" class="h-24 text-center text-muted-foreground">
                                            <div class="flex flex-col items-center justify-center gap-2">
                                                <i data-lucide="loader-2" class="h-6 w-6 animate-spin text-primary"></i>
                                                <span>Loading purchases...</span>
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
    
    // GSAP Animations
    document.addEventListener('DOMContentLoaded', () => {
        gsap.to(".fade-up", {
            y: 0,
            opacity: 1,
            duration: 0.6,
            stagger: 0.1,
            ease: "power2.out"
        });
        
        fetchCustomerData();
    });

    async function fetchCustomerData() {
        try {
            const user = AuthService.getCurrentUser();
            if (user) {
                document.getElementById('userNameDisplay').textContent = user.name;
            }

            // Fetch data from new endpoints
            const [statsRes, recentRes] = await Promise.all([
                PurchaseService.getMyStats(),
                PurchaseService.getMyRecentPurchases()
            ]);

            if (statsRes.success) {
                updateDashboardStats(statsRes.data);
            }

            if (recentRes.success) {
                renderRecentPurchases(recentRes.data);
            }

        } catch (error) {
            console.error('Error fetching customer data:', error);
            showToast('Failed to load dashboard data', 'error');
        }
    }

    function updateDashboardStats(stats) {
        document.getElementById('totalPurchases').textContent = stats.totalPurchases || 0;
        document.getElementById('pendingPurchases').textContent = stats.pendingPurchases || 0;
        document.getElementById('totalSpent').textContent = '₦' + (stats.totalSpent || 0).toLocaleString('en-NG', { minimumFractionDigits: 2 });
    }

    function renderRecentPurchases(orders) {
        const tbody = document.getElementById('recentPurchasesTableBody');
        
        if (!orders || orders.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="h-24 text-center text-muted-foreground">No recent purchases found.</td></tr>`;
            return;
        }

        tbody.innerHTML = orders.map(order => {
            const statusColor = order.paymentStatus === 'Paid' 
                ? 'bg-green-500/10 text-green-700 border-green-200' 
                : order.paymentStatus === 'Pending' 
                ? 'bg-yellow-500/10 text-yellow-700 border-yellow-200' 
                : 'bg-gray-500/10 text-gray-700 border-gray-200';

            // Handle date field variations (date or createdAt)
            const orderDate = order.date || order.createdAt;

            // Handle amount field variations (total or totalAmount) and ensure it's a number
            const orderTotal = parseFloat(order.total || order.totalAmount || 0);

            return `
            <tr class="hover:bg-muted/30 transition-colors">
                <td class="px-4 py-4 font-medium whitespace-nowrap">${order.purchaseId || order._id.substring(0, 8)}</td>
                <td class="px-4 py-4 text-muted-foreground whitespace-nowrap">${new Date(orderDate).toLocaleDateString()}</td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors ${statusColor}">
                        ${order.paymentStatus || order.status}
                    </span>
                </td>
                <td class="px-4 py-4 text-right font-medium whitespace-nowrap">₦${orderTotal.toLocaleString('en-NG', { minimumFractionDigits: 2 })}</td>
                <td class="px-4 py-4 text-right whitespace-nowrap">
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
