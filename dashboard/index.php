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
                        Good Morning, <span id="userNameDisplay" class="text-primary">User</span>!
                    </h1>
                    <p class="text-muted-foreground">Here's what's happening with your store today.</p>
                </div>

                <!-- KPI Cards -->
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 fade-up stagger-1">
                    <div class="glass-card rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium text-muted-foreground">Total Revenue</h3>
                            <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                <i data-lucide="dollar-sign" class="h-4 w-4"></i>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="text-2xl font-bold text-foreground" id="totalRevenue">₦0.00</div>
                            <p class="text-xs text-muted-foreground mt-1">+20.1% from last month</p>
                        </div>
                    </div>
                    <div class="glass-card rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium text-muted-foreground">Sales Count</h3>
                            <div class="h-8 w-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-600">
                                <i data-lucide="shopping-cart" class="h-4 w-4"></i>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="text-2xl font-bold text-foreground" id="salesCount">0</div>
                            <p class="text-xs text-muted-foreground mt-1">+180.1% from last month</p>
                        </div>
                    </div>
                    <div class="glass-card rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium text-muted-foreground">Total Products</h3>
                            <div class="h-8 w-8 rounded-full bg-orange-500/10 flex items-center justify-center text-orange-600">
                                <i data-lucide="box" class="h-4 w-4"></i>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="text-2xl font-bold text-foreground" id="totalProducts">0</div>
                            <p class="text-xs text-muted-foreground mt-1">+19% from last month</p>
                        </div>
                    </div>
                    <div class="glass-card rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium text-muted-foreground">Pending Orders</h3>
                            <div class="h-8 w-8 rounded-full bg-yellow-500/10 flex items-center justify-center text-yellow-600">
                                <i data-lucide="clock" class="h-4 w-4"></i>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="text-2xl font-bold text-foreground" id="pendingOrders">0</div>
                            <p class="text-xs text-muted-foreground mt-1">+201 since last hour</p>
                        </div>
                    </div>
                </div>

                <!-- Charts & Recent Activity -->
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-7 fade-up stagger-2">
                    <!-- Chart -->
                    <div class="glass-card rounded-xl lg:col-span-4 flex flex-col">
                        <div class="p-6 border-b border-border/50">
                            <h3 class="font-semibold text-lg">Revenue Overview</h3>
                            <p class="text-sm text-muted-foreground">Monthly revenue performance for the current year.</p>
                        </div>
                        <div class="p-6 flex-1 min-h-[350px]">
                            <canvas id="salesChart" width="100%" height="350"></canvas>
                        </div>
                    </div>

                    <!-- Recent Purchases -->
                    <div class="glass-card rounded-xl lg:col-span-3 flex flex-col">
                        <div class="p-6 border-b border-border/50 flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-lg">Recent Purchases</h3>
                                <p class="text-sm text-muted-foreground">You made 265 sales this month.</p>
                            </div>
                            <a href="purchases" class="text-sm font-medium text-primary hover:underline">View All</a>
                        </div>
                        <div class="p-0 flex-1 overflow-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-muted-foreground uppercase bg-muted/30">
                                    <tr>
                                        <th class="px-6 py-3 font-medium">Customer</th>
                                        <th class="px-6 py-3 font-medium">Status</th>
                                        <th class="px-6 py-3 font-medium text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="recentPurchasesBody" class="divide-y divide-border/50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-muted-foreground">
                                            <div class="flex flex-col items-center gap-2">
                                                <i data-lucide="loader-2" class="h-6 w-6 animate-spin text-primary"></i>
                                                <span>Loading data...</span>
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

<script src="/assets/js/config.js"></script>
<script src="/assets/js/api.js"></script>
<script src="/assets/js/main.js"></script>
<script>
    // Initialize Lucide Icons
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
    });

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

            // 4. Update UI with animation
            animateValue(totalRevenueEl, 0, totalRevenue, 1500, true);
            animateValue(salesCountEl, 0, salesCount, 1000);
            animateValue(totalProductsEl, 0, totalProducts, 1000);
            animateValue(pendingOrdersEl, 0, pendingOrders, 1000);

            // 5. Render Recent Purchases (Top 5)
            const recentPurchases = purchases.slice(0, 5);
            if (recentPurchases.length === 0) {
                recentPurchasesBody.innerHTML = `<tr><td colspan="3" class="px-6 py-8 text-center text-muted-foreground">No recent purchases found.</td></tr>`;
            } else {
                recentPurchasesBody.innerHTML = recentPurchases.map(p => {
                    const statusColor = p.paymentStatus === 'Paid' 
                        ? 'bg-green-500/10 text-green-700 border-green-200' 
                        : p.paymentStatus === 'Pending' 
                        ? 'bg-yellow-500/10 text-yellow-700 border-yellow-200' 
                        : 'bg-red-500/10 text-red-700 border-red-200';
                    
                    return `
                    <tr class="hover:bg-muted/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-foreground">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold">
                                    ${p.customerName.charAt(0).toUpperCase()}
                                </div>
                                ${p.customerName}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors ${statusColor}">
                                ${p.paymentStatus}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-medium">₦${parseFloat(p.totalAmount).toLocaleString('en-NG', { minimumFractionDigits: 2 })}</td>
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

    function animateValue(obj, start, end, duration, isCurrency = false) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            
            if (isCurrency) {
                obj.innerHTML = '₦' + value.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            } else {
                obj.innerHTML = value.toLocaleString();
            }
            
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
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

        // Get CSS variable values
        const style = getComputedStyle(document.body);
        const primaryColor = `hsl(${style.getPropertyValue('--primary').trim().split(' ').join(', ')})`;
        const gridColor = `rgba(0,0,0,0.05)`;

        new Chart(salesChartCanvas, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Total Revenue',
                    data: monthlyRevenue,
                    backgroundColor: primaryColor,
                    borderRadius: 6,
                    barThickness: 24,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#000',
                        bodyColor: '#000',
                        borderColor: 'rgba(0,0,0,0.1)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        displayColors: false,
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
                    x: { 
                        grid: { display: false },
                        ticks: { font: { size: 12 } }
                    },
                    y: {
                        grid: { color: gridColor, borderDash: [4, 4] },
                        border: { display: false },
                        ticks: {
                            callback: function(value) { return '₦' + value; },
                            font: { size: 11 },
                            padding: 10
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
