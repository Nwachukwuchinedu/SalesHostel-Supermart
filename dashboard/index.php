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
                            <p class="text-xs text-muted-foreground mt-1" id="revenueGrowth">Loading...</p>
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
                            <p class="text-xs text-muted-foreground mt-1" id="salesGrowth">Loading...</p>
                        </div>
                    </div>
                    <div class="glass-card rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium text-muted-foreground">Total Customers</h3>
                            <div class="h-8 w-8 rounded-full bg-purple-500/10 flex items-center justify-center text-purple-600">
                                <i data-lucide="users" class="h-4 w-4"></i>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="text-2xl font-bold text-foreground" id="totalCustomers">0</div>
                            <p class="text-xs text-muted-foreground mt-1" id="usersGrowth">Loading...</p>
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
                            <p class="text-xs text-muted-foreground mt-1">Orders awaiting processing</p>
                        </div>
                    </div>
                </div>

                <!-- Charts & Recent Activity -->
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-7 fade-up stagger-2">
                    <!-- Chart -->
                    <div class="glass-card rounded-xl lg:col-span-4 flex flex-col">
                        <div class="p-6 border-b border-border/50">
                            <h3 class="font-semibold text-lg">Revenue & Sales Overview</h3>
                            <p class="text-sm text-muted-foreground">Monthly revenue and sales performance for the current year.</p>
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
                                <p class="text-sm text-muted-foreground">Latest transactions.</p>
                            </div>
                            <a href="purchases.php" class="text-sm font-medium text-primary hover:underline">View All</a>
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

                <!-- Top Products & Stock Status -->
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-7 fade-up stagger-3">
                    <!-- Top Products -->
                    <div class="glass-card rounded-xl lg:col-span-4 flex flex-col">
                        <div class="p-6 border-b border-border/50">
                            <h3 class="font-semibold text-lg">Top Selling Products</h3>
                            <p class="text-sm text-muted-foreground">Your best performing items.</p>
                        </div>
                        <div class="p-0 flex-1 overflow-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-muted-foreground uppercase bg-muted/30">
                                    <tr>
                                        <th class="px-6 py-3 font-medium">Product</th>
                                        <th class="px-6 py-3 font-medium text-right">Sold</th>
                                        <th class="px-6 py-3 font-medium text-right">Revenue</th>
                                    </tr>
                                </thead>
                                <tbody id="topProductsBody" class="divide-y divide-border/50">
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

                    <!-- Stock Status -->
                    <div class="glass-card rounded-xl lg:col-span-3 flex flex-col">
                        <div class="p-6 border-b border-border/50">
                            <h3 class="font-semibold text-lg">Stock Status</h3>
                            <p class="text-sm text-muted-foreground">Inventory health overview.</p>
                        </div>
                        <div class="p-6 flex items-center justify-center min-h-[220px]">
                            <canvas id="stockChart" width="100%" height="220" style="max-height: 220px;"></canvas>
                        </div>
                        <div class="grid grid-cols-3 gap-2 p-4 border-t border-border/50 bg-muted/20">
                            <div class="text-center rounded-lg bg-background p-2 shadow-sm">
                                <div class="text-[10px] uppercase tracking-wider text-muted-foreground">In Stock</div>
                                <div class="text-lg font-bold text-green-600" id="inStockCount">0</div>
                            </div>
                            <div class="text-center rounded-lg bg-background p-2 shadow-sm">
                                <div class="text-[10px] uppercase tracking-wider text-muted-foreground">Low</div>
                                <div class="text-lg font-bold text-yellow-600" id="lowStockCount">0</div>
                            </div>
                            <div class="text-center rounded-lg bg-background p-2 shadow-sm">
                                <div class="text-[10px] uppercase tracking-wider text-muted-foreground">Out</div>
                                <div class="text-lg font-bold text-red-600" id="outOfStockCount">0</div>
                            </div>
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

    // KPI Elements
    const totalRevenueEl = document.getElementById('totalRevenue');
    const revenueGrowthEl = document.getElementById('revenueGrowth');
    const salesCountEl = document.getElementById('salesCount');
    const salesGrowthEl = document.getElementById('salesGrowth');
    const totalCustomersEl = document.getElementById('totalCustomers');
    const usersGrowthEl = document.getElementById('usersGrowth');
    const pendingOrdersEl = document.getElementById('pendingOrders');

    // Tables
    const recentPurchasesBody = document.getElementById('recentPurchasesBody');
    const topProductsBody = document.getElementById('topProductsBody');

    // Charts
    const salesChartCanvas = document.getElementById('salesChart');
    const stockChartCanvas = document.getElementById('stockChart');

    // Stock Counts
    const inStockCountEl = document.getElementById('inStockCount');
    const lowStockCountEl = document.getElementById('lowStockCount');
    const outOfStockCountEl = document.getElementById('outOfStockCount');

    async function loadDashboardData() {
        try {
            // 1. Get User Info
            const user = AuthService.getCurrentUser();
            if (user) {
                userNameDisplay.textContent = user.name;
            }

            // 2. Fetch Data
            // We use AnalyticsService to get all dashboard data at once
            const res = await AnalyticsService.getDashboardAnalytics();
            if (!res.success) throw new Error(res.message || 'Failed to fetch analytics');
            const data = res.data;

            // 3. Update Summary Cards
            // Handle number conversions safely
            const totalRev = typeof data.summary.totalRevenue === 'string' ? parseFloat(data.summary.totalRevenue.replace(/[^0-9.-]+/g,"")) : data.summary.totalRevenue;
            animateValue(totalRevenueEl, 0, totalRev || 0, 1500, true);
            animateValue(salesCountEl, 0, parseInt(data.summary.salesCount) || 0, 1000);
            animateValue(totalCustomersEl, 0, parseInt(data.summary.totalCustomers) || 0, 1000);
            animateValue(pendingOrdersEl, 0, parseInt(data.summary.pendingOrders) || 0, 1000);

            // Update Growth Text
            updateGrowthText(revenueGrowthEl, data.summary.revenueGrowth);
            updateGrowthText(salesGrowthEl, data.summary.salesGrowth);
            updateGrowthText(usersGrowthEl, data.summary.usersGrowth);

            // 4. Update Recent Purchases
            renderRecentPurchases(data.recentPurchases);

            // 5. Update Top Products
            renderTopProducts(data.topProducts);

            // 6. Render Charts
            renderSalesChart(data.chartData);
            renderStockChart(data.stockStatus);

            // 7. Update Stock Counts Text
            if (data.stockStatus) {
                animateValue(inStockCountEl, 0, data.stockStatus['In Stock'] || 0, 1000);
                animateValue(lowStockCountEl, 0, data.stockStatus['Low Stock'] || 0, 1000);
                animateValue(outOfStockCountEl, 0, data.stockStatus['Out of Stock'] || 0, 1000);
            }

        } catch (error) {
            console.error('Failed to load dashboard data', error);
            // showToast('Failed to load dashboard data', 'error');
        }
    }

    function updateGrowthText(element, value) {
        if (!element) return;
        const val = parseFloat(value);
        if (isNaN(val)) {
            element.textContent = 'No data';
            return;
        }
        const isPositive = val >= 0;
        element.innerHTML = `<span class="${isPositive ? 'text-green-600' : 'text-red-600'}">${isPositive ? '+' : ''}${val}%</span> from last month`;
    }

    function renderRecentPurchases(purchases) {
        if (!recentPurchasesBody) return;
        if (!purchases || purchases.length === 0) {
            recentPurchasesBody.innerHTML = `<tr><td colspan="3" class="px-6 py-8 text-center text-muted-foreground">No recent purchases found.</td></tr>`;
            return;
        }
        
        recentPurchasesBody.innerHTML = purchases.map(p => {
            const statusColor = p.paymentStatus === 'Paid' 
                ? 'bg-green-500/10 text-green-700 border-green-200' 
                : p.paymentStatus === 'Pending' 
                ? 'bg-yellow-500/10 text-yellow-700 border-yellow-200' 
                : 'bg-red-500/10 text-red-700 border-red-200';
                
            // Handle customer name safely
            const customerName = p.customer && p.customer.name ? p.customer.name : 'Unknown';
            
            return `
            <tr class="hover:bg-muted/30 transition-colors">
                <td class="px-6 py-4 font-medium text-foreground">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold">
                            ${customerName.charAt(0).toUpperCase()}
                        </div>
                        ${customerName}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors ${statusColor}">
                        ${p.paymentStatus}
                    </span>
                </td>
                <td class="px-6 py-4 text-right font-medium">₦${parseFloat(p.total).toLocaleString('en-NG', { minimumFractionDigits: 2 })}</td>
            </tr>
        `}).join('');
    }

    function renderTopProducts(products) {
        if (!topProductsBody) return;
        if (!products || products.length === 0) {
            topProductsBody.innerHTML = `<tr><td colspan="3" class="px-6 py-8 text-center text-muted-foreground">No top products data.</td></tr>`;
            return;
        }

        topProductsBody.innerHTML = products.map(p => {
            return `
            <tr class="hover:bg-muted/30 transition-colors">
                <td class="px-6 py-4 font-medium text-foreground">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-md bg-muted flex-shrink-0 overflow-hidden">
                            ${p.image ? `<img src="${p.image}" alt="${p.name}" class="h-full w-full object-cover">` : `<div class="h-full w-full flex items-center justify-center bg-gray-200 text-gray-500"><i data-lucide="image" class="h-4 w-4"></i></div>`}
                        </div>
                        <div>
                            <div class="font-medium">${p.name}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-right">${p.totalSold}</td>
                <td class="px-6 py-4 text-right font-medium">₦${parseFloat(p.revenue).toLocaleString('en-NG', { minimumFractionDigits: 2 })}</td>
            </tr>
        `}).join('');
        lucide.createIcons();
    }

    function renderSalesChart(chartData) {
        if (!salesChartCanvas || !chartData) return;

        // Destroy existing chart if any stored on the canvas element (Chart.js specific)
        const existingChart = Chart.getChart(salesChartCanvas);
        if (existingChart) existingChart.destroy();

        const labels = chartData.map(d => d.name);
        const revenueData = chartData.map(d => d.revenue);
        const salesData = chartData.map(d => d.sales);
        
        const style = getComputedStyle(document.body);
        const primaryColor = `hsl(${style.getPropertyValue('--primary').trim().split(' ').join(', ')})`;
        const gridColor = `rgba(0,0,0,0.05)`;

        new Chart(salesChartCanvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Revenue',
                        data: revenueData,
                        borderColor: primaryColor,
                        backgroundColor: 'rgba(59, 130, 246, 0.1)', // Light blue background
                        borderWidth: 2,
                        tension: 0.4,
                        fill: false, // Don't fill area
                        yAxisID: 'y'
                    },
                    {
                        label: 'Sales Count',
                        data: salesData,
                        borderColor: '#f97316', // Orange for sales
                        backgroundColor: 'rgba(249, 115, 22, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: false,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                         display: true,
                         position: 'top',
                         labels: {
                             usePointStyle: true,
                             boxWidth: 8
                         }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#000',
                        bodyColor: '#000',
                        borderColor: 'rgba(0,0,0,0.1)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    if (context.dataset.yAxisID === 'y') {
                                        label += new Intl.NumberFormat('en-NG', { style: 'currency', currency: 'NGN' }).format(context.parsed.y);
                                    } else {
                                        label += context.parsed.y;
                                    }
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
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: { color: gridColor, borderDash: [4, 4] },
                        border: { display: false },
                        ticks: {
                            callback: function(value) { return '₦' + value; },
                            font: { size: 11 },
                            padding: 10
                        },
                        title: { display: false, text: 'Revenue' }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { drawOnChartArea: false }, // only want the grid lines for one axis to show up
                        border: { display: false },
                        ticks: {
                            font: { size: 11 },
                            padding: 10
                        },
                        title: { display: false, text: 'Sales' }
                    }
                }
            }
        });
    }

    function renderStockChart(stockStatus) {
        if (!stockChartCanvas || !stockStatus) return;

        const existingChart = Chart.getChart(stockChartCanvas);
        if (existingChart) existingChart.destroy();

        const data = [
            stockStatus['In Stock'] || 0,
            stockStatus['Low Stock'] || 0,
            stockStatus['Out of Stock'] || 0
        ];

        new Chart(stockChartCanvas, {
            type: 'doughnut',
            data: {
                labels: ['In Stock', 'Low Stock', 'Out of Stock'],
                datasets: [{
                    data: data,
                    backgroundColor: ['#16a34a', '#ca8a04', '#dc2626'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    function animateValue(obj, start, end, duration, isCurrency = false) {
        if (!obj) return;
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

    loadDashboardData();
</script>
</body>
</html>
