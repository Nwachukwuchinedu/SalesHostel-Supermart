<?php include '../includes/head.php'; ?>

<div class="flex min-h-screen w-full flex-col bg-muted/40">
    <?php include '../includes/sidebar.php'; ?>
    
    <div class="flex flex-col sm:gap-4 sm:py-4 md:ml-64">
        <?php include '../includes/dashboard_header.php'; ?>
        
        <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <div class="flex flex-col gap-8">
                <h1 class="text-3xl font-headline font-bold tracking-tight">
                    Welcome, <span id="userNameDisplay">User</span>!
                </h1>

                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-xl border bg-card text-card-foreground shadow">
                        <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium">Total Revenue</h3>
                            <i data-lucide="dollar-sign" class="h-4 w-4 text-muted-foreground"></i>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold" id="totalRevenue">₦0.00</div>
                            <p class="text-xs text-muted-foreground">Total sales revenue</p>
                        </div>
                    </div>
                    <div class="rounded-xl border bg-card text-card-foreground shadow">
                        <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium">Sales Count</h3>
                            <i data-lucide="shopping-cart" class="h-4 w-4 text-muted-foreground"></i>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold" id="salesCount">0</div>
                            <p class="text-xs text-muted-foreground">Total completed sales</p>
                        </div>
                    </div>
                    <div class="rounded-xl border bg-card text-card-foreground shadow">
                        <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium">Total Products</h3>
                            <i data-lucide="box" class="h-4 w-4 text-muted-foreground"></i>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold" id="totalProducts">0</div>
                            <p class="text-xs text-muted-foreground">Items in inventory</p>
                        </div>
                    </div>
                    <div class="rounded-xl border bg-card text-card-foreground shadow">
                        <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium">Pending Orders</h3>
                            <i data-lucide="clock" class="h-4 w-4 text-muted-foreground"></i>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold" id="pendingOrders">0</div>
                            <p class="text-xs text-muted-foreground">Orders awaiting payment</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-7">
                    <div class="rounded-xl border bg-card text-card-foreground shadow lg:col-span-4">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight">Overview</h3>
                        </div>
                        <div class="p-6 pt-0 pl-2">
                            <canvas id="salesChart" width="100%" height="350"></canvas>
                        </div>
                    </div>
                    <div class="rounded-xl border bg-card text-card-foreground shadow lg:col-span-3">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight">Recent Purchases</h3>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="relative w-full overflow-auto">
                                <table class="w-full caption-bottom text-sm">
                                    <thead class="[&_tr]:border-b">
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">Customer</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">Status</th>
                                            <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0 text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recentPurchasesBody" class="[&_tr:last-child]:border-0">
                                        <tr>
                                            <td colspan="3" class="p-4 text-center text-muted-foreground">Loading...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>

<script src="/assets/js/config.js"></script>
<script src="/assets/js/api.js"></script>
<script src="/assets/js/main.js"></script>
<script>
    // Initialize Lucide Icons
    lucide.createIcons();

    // Sidebar Toggle Logic
    const openSidebarBtn = document.getElementById('open-sidebar');
    const closeSidebarBtn = document.getElementById('close-sidebar');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');

    if (openSidebarBtn && mobileSidebar && mobileSidebarOverlay) {
        openSidebarBtn.addEventListener('click', () => {
            mobileSidebar.classList.remove('-translate-x-full');
            mobileSidebarOverlay.classList.remove('hidden');
        });

        const closeSidebar = () => {
            mobileSidebar.classList.add('-translate-x-full');
            mobileSidebarOverlay.classList.add('hidden');
        };

        closeSidebarBtn.addEventListener('click', closeSidebar);
        mobileSidebarOverlay.addEventListener('click', closeSidebar);
    }

    // Dashboard Data Logic
    const userNameDisplay = document.getElementById('userNameDisplay');
    const totalRevenueEl = document.getElementById('totalRevenue');
    const salesCountEl = document.getElementById('salesCount');
    const totalProductsEl = document.getElementById('totalProducts');
    const pendingOrdersEl = document.getElementById('pendingOrders');
    const recentPurchasesBody = document.getElementById('recentPurchasesBody');
    const salesChartCanvas = document.getElementById('salesChart');

    async function loadDashboardData() {
        try {
            // 1. Get User Info
            const user = AuthService.getCurrentUser();
            if (user) {
                userNameDisplay.textContent = user.name;
            }

            // 2. Fetch Data in Parallel
            const [purchasesRes, productsRes] = await Promise.all([
                PurchaseService.getAllPurchases(),
                ProductService.getAllProducts()
            ]);

            const purchases = purchasesRes.data || [];
            const products = productsRes.data || [];

            // 3. Calculate Metrics
            const totalRevenue = purchases
                .filter(p => p.paymentStatus === 'Paid')
                .reduce((sum, p) => sum + parseFloat(p.totalAmount), 0);
            
            const salesCount = purchases.filter(p => p.paymentStatus === 'Paid').length;
            const pendingOrders = purchases.filter(p => p.paymentStatus === 'Pending').length;
            const totalProducts = products.length;

            // 4. Update UI
            totalRevenueEl.textContent = '₦' + totalRevenue.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            salesCountEl.textContent = salesCount;
            totalProductsEl.textContent = totalProducts;
            pendingOrdersEl.textContent = pendingOrders;

            // 5. Render Recent Purchases (Top 5)
            const recentPurchases = purchases.slice(0, 5);
            if (recentPurchases.length === 0) {
                recentPurchasesBody.innerHTML = `<tr><td colspan="3" class="p-4 text-center text-muted-foreground">No recent purchases.</td></tr>`;
            } else {
                recentPurchasesBody.innerHTML = recentPurchases.map(p => {
                    const statusColor = p.paymentStatus === 'Paid' 
                        ? 'bg-green-500/20 text-green-700' 
                        : p.paymentStatus === 'Pending' 
                        ? 'bg-yellow-500/20 text-yellow-700' 
                        : 'bg-red-500/20 text-red-700';
                    
                    return `
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                            <div class="font-medium">${p.customerName}</div>
                        </td>
                        <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent ${statusColor}">
                                ${p.paymentStatus}
                            </div>
                        </td>
                        <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0 text-right">₦${parseFloat(p.totalAmount).toFixed(2)}</td>
                    </tr>
                `}).join('');
            }

            // 6. Render Chart (Monthly Revenue)
            renderChart(purchases);

        } catch (error) {
            console.error('Failed to load dashboard data', error);
            showToast('Failed to load dashboard data', 'error');
        }
    }

    function renderChart(purchases) {
        if (!salesChartCanvas) return;

        // Group revenue by month
        const monthlyRevenue = Array(12).fill(0);
        purchases.forEach(p => {
            if (p.paymentStatus === 'Paid') {
                const date = new Date(p.createdAt);
                const month = date.getMonth(); // 0-11
                monthlyRevenue[month] += parseFloat(p.totalAmount);
            }
        });

        new Chart(salesChartCanvas, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Total Revenue',
                    data: monthlyRevenue,
                    backgroundColor: 'hsl(127, 30%, 45%)',
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'hsl(var(--background))',
                        titleColor: 'hsl(var(--foreground))',
                        bodyColor: 'hsl(var(--foreground))',
                        borderColor: 'hsl(var(--border))',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-NG', { style: 'currency', currency: 'NGN' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        grid: { display: false },
                        ticks: {
                            callback: function(value) { return '₦' + value; }
                        }
                    }
                }
            }
        });
    }

    loadDashboardData();
</script>
</body>
</html>
