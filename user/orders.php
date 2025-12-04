<?php include __DIR__ . '/../includes/head.php'; ?>

<div class="flex min-h-screen w-full flex-col bg-muted/20">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="flex flex-col sm:gap-4 sm:py-4 md:ml-64 transition-all duration-300">
        <?php include __DIR__ . '/../includes/dashboard_header.php'; ?>
        
        <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <div class="flex flex-col gap-8">
                <!-- Header -->
                <div class="flex flex-col gap-2 fade-up">
                    <h1 class="text-3xl font-headline font-bold tracking-tight">My Purchases</h1>
                    <p class="text-muted-foreground">View and track your purchase history.</p>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap lg:flex-nowrap gap-4 fade-up stagger-1">
                    <div class="relative w-full lg:w-auto lg:flex-1">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground"></i>
                        <input type="text" id="searchInput" placeholder="Search by Purchase ID..." class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 pl-10 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                    <div class="w-full sm:w-[calc(50%-0.5rem)] lg:w-[200px]">
                        <select id="statusFilter" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            <option value="">All Statuses</option>
                            <option value="Paid">Paid</option>
                            <option value="Pending">Pending</option>
                            <option value="Failed">Failed</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-[calc(50%-0.5rem)] lg:w-[200px]">
                        <input type="date" id="dateFilter" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                </div>

                <!-- Purchases List -->
                <div class="glass-card rounded-xl border bg-card text-card-foreground shadow-sm fade-up stagger-2">
                    <div class="p-6">
                        <div class="relative w-full overflow-x-auto">
                            <table class="w-full caption-bottom text-sm">
                                <thead class="[&_tr]:border-b">
                                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground whitespace-nowrap">Purchase ID</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground whitespace-nowrap">Date</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground whitespace-nowrap">Status</th>
                                        <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground whitespace-nowrap">Total Amount</th>
                                        <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground whitespace-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="purchasesTableBody">
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
                        
                        <!-- Pagination -->
                        <div class="flex items-center justify-between border-t px-2 py-4 mt-4" id="paginationContainer">
                            <div class="text-sm text-muted-foreground" id="paginationInfo">
                                Showing 0 to 0 of 0 entries
                            </div>
                            <div class="flex items-center space-x-2">
                                <button id="prevPageBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-8 w-8" disabled>
                                    <i data-lucide="chevron-left" class="h-4 w-4"></i>
                                </button>
                                <button id="nextPageBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-8 w-8" disabled>
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </button>
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
    lucide.createIcons();
    
    let currentParams = {
        page: 1,
        limit: 10,
        search: '',
        paymentStatus: '',
        date: ''
    };

    document.addEventListener('DOMContentLoaded', () => {
        gsap.to(".fade-up", {
            y: 0,
            opacity: 1,
            duration: 0.6,
            stagger: 0.1,
            ease: "power2.out"
        });
        
        // Initialize filters
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const dateFilter = document.getElementById('dateFilter');
        const prevPageBtn = document.getElementById('prevPageBtn');
        const nextPageBtn = document.getElementById('nextPageBtn');

        // Debounce search
        let searchTimeout;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentParams.search = e.target.value;
                currentParams.page = 1;
                fetchPurchases();
            }, 500);
        });

        statusFilter.addEventListener('change', (e) => {
            currentParams.paymentStatus = e.target.value;
            currentParams.page = 1;
            fetchPurchases();
        });

        dateFilter.addEventListener('change', (e) => {
            currentParams.date = e.target.value;
            currentParams.page = 1;
            fetchPurchases();
        });

        prevPageBtn.addEventListener('click', () => {
            if (currentParams.page > 1) {
                currentParams.page--;
                fetchPurchases();
            }
        });

        nextPageBtn.addEventListener('click', () => {
            currentParams.page++;
            fetchPurchases();
        });
        
        fetchPurchases();
    });

    async function fetchPurchases() {
        const tbody = document.getElementById('purchasesTableBody');
        tbody.innerHTML = `<tr><td colspan="5" class="h-24 text-center text-muted-foreground"><div class="flex flex-col items-center justify-center gap-2"><i data-lucide="loader-2" class="h-6 w-6 animate-spin text-primary"></i><span>Loading purchases...</span></div></td></tr>`;
        lucide.createIcons();

        try {
            // Clean params
            const params = { ...currentParams };
            if (!params.search) delete params.search;
            if (!params.paymentStatus) delete params.paymentStatus;
            if (!params.date) delete params.date;

            const res = await PurchaseService.getMyPurchases(params); 
            renderPurchases(res.data);
            renderPagination(res.pagination);
        } catch (error) {
            console.error('Error fetching purchases:', error);
            showToast('Failed to load purchases', 'error');
            tbody.innerHTML = `<tr><td colspan="5" class="h-24 text-center text-red-500">Failed to load purchases.</td></tr>`;
        }
    }

    function renderPurchases(purchases) {
        const tbody = document.getElementById('purchasesTableBody');
        
        if (!purchases || purchases.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="h-24 text-center text-muted-foreground">No purchases found. <a href="/#products" class="text-primary hover:underline">Start shopping</a></td></tr>`;
            return;
        }

        tbody.innerHTML = purchases.map(purchase => {
            const statusColor = purchase.paymentStatus === 'Paid' 
                ? 'bg-green-500/10 text-green-700 border-green-200' 
                : purchase.paymentStatus === 'Pending' 
                ? 'bg-yellow-500/10 text-yellow-700 border-yellow-200' 
                : 'bg-gray-500/10 text-gray-700 border-gray-200';

            return `
            <tr class="hover:bg-muted/30 transition-colors">
                <td class="px-4 py-4 font-medium whitespace-nowrap">${purchase.purchaseId || purchase._id.substring(0, 8)}</td>
                <td class="px-4 py-4 text-muted-foreground whitespace-nowrap">${new Date(purchase.date || purchase.createdAt).toLocaleDateString()}</td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors ${statusColor}">
                        ${purchase.paymentStatus || purchase.status}
                    </span>
                </td>
                <td class="px-4 py-4 text-right font-medium whitespace-nowrap">₦${parseFloat(purchase.total || purchase.totalAmount || 0).toLocaleString('en-NG', { minimumFractionDigits: 2 })}</td>
                <td class="px-4 py-4 text-right whitespace-nowrap">
                    <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 w-8">
                        <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                    </button>
                </td>
            </tr>
        `}).join('');
        
        lucide.createIcons();
    }

    function renderPagination(pagination) {
        const info = document.getElementById('paginationInfo');
        const prevBtn = document.getElementById('prevPageBtn');
        const nextBtn = document.getElementById('nextPageBtn');

        if (!pagination) return;

        const start = (pagination.page - 1) * pagination.limit + 1;
        const end = Math.min(pagination.page * pagination.limit, pagination.total);
        
        info.textContent = `Showing ${pagination.total === 0 ? 0 : start} to ${end} of ${pagination.total} entries`;

        prevBtn.disabled = pagination.page <= 1;
        nextBtn.disabled = pagination.page >= pagination.pages;
    }
</script>
</body>
</html>
