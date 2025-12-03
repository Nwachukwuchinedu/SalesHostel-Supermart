<?php 
include '../includes/head.php'; 
include '../includes/ui/components.php';
?>

<div class="flex min-h-screen w-full flex-col bg-muted/20">
    <?php include '../includes/sidebar.php'; ?>
    
    <div class="flex flex-col sm:gap-4 sm:py-4 md:ml-64 transition-all duration-300">
        <?php include '../includes/dashboard_header.php'; ?>
        
        <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <div class="flex flex-col gap-8 min-w-0 fade-up">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-headline font-bold tracking-tight">
                            Purchases
                        </h1>
                        <p class="text-muted-foreground">Manage customer purchases and orders.</p>
                    </div>
                    <button id="addPurchaseBtn" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-0.5 transition-all duration-200">
                        <i data-lucide="plus-circle" class="mr-2 h-4 w-4"></i>
                        New Purchase
                    </button>
                </div>

                <div class="glass-card rounded-xl p-6 space-y-6">
                    <!-- Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div class="md:col-span-2 relative">
                            <i data-lucide="search" class="absolute left-3 top-3 h-4 w-4 text-muted-foreground"></i>
                            <input type="search" id="searchInput" placeholder="Search by customer, purchase #..." class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 pl-9 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                        </div>
                        <div class="grid gap-2">
                            <label for="statusFilter" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Payment Status</label>
                            <select id="statusFilter" class="flex h-10 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                                <option value="">All Statuses</option>
                                <option value="Paid">Paid</option>
                                <option value="Pending">Pending</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="Refunded">Refunded</option>
                                <option value="Partial">Partial</option>
                            </select>
                        </div>
                        <div class="grid gap-2">
                            <label for="dateFilter" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Date</label>
                            <input type="date" id="dateFilter" class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="rounded-lg border border-border/50 overflow-hidden">
                        <div class="relative w-full overflow-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-muted-foreground uppercase bg-muted/30">
                                    <tr>
                                        <th class="px-6 py-3 font-medium">Purchase #</th>
                                        <th class="px-6 py-3 font-medium">Customer</th>
                                        <th class="px-6 py-3 font-medium">Payment</th>
                                        <th class="px-6 py-3 font-medium">Date</th>
                                        <th class="px-6 py-3 font-medium text-right">Total</th>
                                        <th class="px-6 py-3 font-medium text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="purchasesTableBody" class="divide-y divide-border/50 bg-card/50">
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-muted-foreground">
                                            <div class="flex flex-col items-center gap-2">
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

<!-- Purchase Modal -->
<?php
$purchaseFormContent = '
<form id="purchaseForm" class="grid gap-6">
    <input type="hidden" name="id" id="purchaseId">
    <div class="space-y-6 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
        <div class="grid gap-2">
            <label class="text-sm font-medium leading-none" for="customerName">Customer</label>
            <select name="customerName" id="customerName" class="flex h-11 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary" required>
                <option value="">Select a customer</option>
                <!-- Options populated via JS -->
            </select>
        </div>

        <div class="grid gap-2">
            <label class="text-sm font-medium leading-none">Products</label>
            <div class="p-4 space-y-4 border border-border/50 rounded-lg bg-muted/10">
                <div id="productItems" class="space-y-3">
                    <!-- Product items will be added here -->
                </div>
                <button type="button" id="addProductItemBtn" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 w-full border-dashed">
                    <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                    Add Product
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="grid gap-2">
                <label class="text-sm font-medium leading-none">Payment Status</label>
                <select name="paymentStatus" id="paymentStatus" class="flex h-11 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                    <option value="Pending">Pending</option>
                    <option value="Paid">Paid</option>
                    <option value="Partial">Partial</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="Refunded">Refunded</option>
                </select>
            </div>
            <div class="grid gap-2">
                <label class="text-sm font-medium leading-none">Delivery Status</label>
                <select name="deliveryStatus" id="deliveryStatus" class="flex h-11 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <div class="grid gap-2">
            <label class="text-sm font-medium leading-none">Notes</label>
            <textarea name="notes" id="purchaseNotes" placeholder="Add any notes for this purchase..." class="flex min-h-[80px] w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary"></textarea>
        </div>
    </div>

    <div class="flex justify-between items-center pt-4 border-t border-border/50">
        <div class="text-lg font-bold text-primary">
            Total: <span id="totalDisplay">₦0.00</span>
        </div>
        <div class="flex gap-2">
            <button type="button" onclick="document.getElementById(\'purchase-modal\').classList.add(\'hidden\')" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                Cancel
            </button>
            <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20">
                Save Purchase
            </button>
        </div>
    </div>
</form>
';

echo UI::dialog('purchase-modal', 'Create New Purchase', $purchaseFormContent);
?>

<!-- Purchase Details Modal -->
<?php
$detailsContent = '
<div id="purchaseDetailsContent" class="space-y-6">
    <!-- Details injected via JS -->
</div>
';
$detailsFooter = '
<button type="button" onclick="document.getElementById(\'details-modal\').classList.add(\'hidden\')" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
    Close
</button>
<button type="button" id="editPurchaseBtn" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20">
    Edit
</button>
';

echo UI::dialog('details-modal', 'Purchase Details', $detailsContent, $detailsFooter);
?>

<!-- Receipt Modal -->
<?php
$receiptContent = '
<div class="space-y-4 text-sm" id="receiptContent">
    <!-- Receipt injected via JS -->
</div>
';
$receiptFooter = '
<button type="button" onclick="document.getElementById(\'receipt-modal\').classList.add(\'hidden\')" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
    Close
</button>
<button type="button" onclick="window.print()" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20">
    <i data-lucide="printer" class="mr-2 h-4 w-4"></i>
    Print
</button>
';

echo UI::dialog('receipt-modal', 'SalesHostel Digital', $receiptContent, $receiptFooter);
?>

<!-- Delete Alert Dialog -->
<?php
echo UI::alertDialog('delete-alert', 'Are you absolutely sure?', 'This action cannot be undone. This will permanently delete this purchase record.', 'confirmDeleteBtn');
?>

<div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>

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
    });

    // Sidebar Logic
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

    // State
    let allPurchases = [];
    let availableProducts = [];
    let availableCustomers = [];
    let selectedPurchase = null;
    let purchaseToDelete = null;

    // Elements
    const purchasesTableBody = document.getElementById('purchasesTableBody');
    const purchaseModal = document.getElementById('purchase-modal');
    const purchaseModalTitle = purchaseModal.querySelector('h3');
    const detailsModal = document.getElementById('details-modal');
    const detailsContent = document.getElementById('purchaseDetailsContent');
    const receiptModal = document.getElementById('receipt-modal');
    const receiptContent = document.getElementById('receiptContent');
    const deleteAlert = document.getElementById('delete-alert');
    
    // Forms
    const purchaseForm = document.getElementById('purchaseForm');
    const productItemsContainer = document.getElementById('productItems');
    
    // Inputs
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const customerSelect = document.getElementById('customerName');

    // Buttons
    const addPurchaseBtn = document.getElementById('addPurchaseBtn');
    const addProductItemBtn = document.getElementById('addProductItemBtn');
    const editPurchaseBtn = document.getElementById('editPurchaseBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    // Fetch Data
    async function fetchData() {
        try {
            const [purchasesRes, productsRes, customersRes] = await Promise.all([
                PurchaseService.getAllPurchases(),
                ProductService.getAllProducts(),
                PurchaseService.getAllCustomerNames() // Assuming this method exists or we use getAllUsers with role filter
            ]);
            
            allPurchases = purchasesRes.data.map(p => ({...p, id: p._id || p.id}));
            availableProducts = productsRes.data.map(p => ({...p, id: p._id || p.id}));
            availableCustomers = customersRes.data || [];
            
            renderPurchases(allPurchases);
            updateCustomerSelect();
        } catch (error) {
            console.error(error);
            showToast('Failed to fetch data', 'error');
        }
    }

    function updateCustomerSelect() {
        customerSelect.innerHTML = '<option value="">Select a customer</option>' + 
            availableCustomers.map(c => `<option value="${c._id}">${c.name}</option>`).join('');
    }

    function renderPurchases(purchases) {
        if (purchases.length === 0) {
            purchasesTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-8 text-center text-muted-foreground">No purchases found.</td></tr>`;
            return;
        }

        purchasesTableBody.innerHTML = purchases.map(purchase => {
            const statusColor = purchase.paymentStatus === 'Paid' 
                ? 'bg-green-500/10 text-green-700 border-green-200' 
                : purchase.paymentStatus === 'Pending' 
                ? 'bg-yellow-500/10 text-yellow-700 border-yellow-200' 
                : 'bg-red-500/10 text-red-700 border-red-200';

            return `
            <tr class="hover:bg-muted/30 transition-colors">
                <td class="px-6 py-4 font-medium">${purchase.purchaseNumber || 'N/A'}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="h-6 w-6 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold">
                            ${(purchase.customerName || 'U').charAt(0).toUpperCase()}
                        </div>
                        ${purchase.customerName || 'N/A'}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors ${statusColor}">
                        ${purchase.paymentStatus}
                    </span>
                </td>
                <td class="px-6 py-4 text-muted-foreground">${new Date(purchase.createdAt || purchase.date).toLocaleDateString()}</td>
                <td class="px-6 py-4 text-right font-medium">₦${parseFloat(purchase.total || purchase.totalAmount || 0).toLocaleString('en-NG', { minimumFractionDigits: 2 })}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end relative group/dropdown">
                        <button class="inline-flex items-center justify-center rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 w-8">
                            <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                        </button>
                        <div class="absolute right-0 top-8 w-40 rounded-lg border bg-popover p-1 text-popover-foreground shadow-lg hidden group-hover/dropdown:block z-10 bg-white animate-in fade-in zoom-in-95 duration-200">
                            <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openDetails('${purchase.id}')">
                                <i data-lucide="eye" class="mr-2 h-3.5 w-3.5 text-muted-foreground"></i>
                                View Details
                            </div>
                            <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openReceipt('${purchase.id}')">
                                <i data-lucide="receipt" class="mr-2 h-3.5 w-3.5 text-muted-foreground"></i>
                                View Receipt
                            </div>
                            <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openEditPurchase('${purchase.id}')">
                                <i data-lucide="edit" class="mr-2 h-3.5 w-3.5 text-muted-foreground"></i>
                                Edit
                            </div>
                            <div class="h-[1px] bg-border my-1"></div>
                            ${purchase.paymentStatus !== 'Paid' ? 
                                `<div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="markAsPaid('${purchase.id}')">
                                    <i data-lucide="check-circle" class="mr-2 h-3.5 w-3.5 text-green-500"></i>
                                    Mark as Paid
                                </div>` : 
                                `<div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="markAsPending('${purchase.id}')">
                                    <i data-lucide="clock" class="mr-2 h-3.5 w-3.5 text-yellow-500"></i>
                                    Mark as Pending
                                </div>`
                            }
                            <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 hover:text-red-600 text-red-600" onclick="openDeleteAlert('${purchase.id}')">
                                <i data-lucide="trash-2" class="mr-2 h-3.5 w-3.5"></i>
                                Delete
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        `}).join('');
        lucide.createIcons();
    }

    function addProductRow(data = null) {
        const row = document.createElement('div');
        row.className = 'grid grid-cols-[1fr_auto_auto_auto] items-end gap-2 p-3 border border-border/50 rounded-lg bg-background shadow-sm animate-in fade-in slide-in-from-bottom-2 duration-300';
        
        const productOptions = `<option value="">Select Product</option>` + 
            availableProducts.map(p => `<option value="${p.id}" data-price="${p.sellingPrice}" ${data && data.productId === p.id ? 'selected' : ''}>${p.name}</option>`).join('');

        row.innerHTML = `
            <div class="grid gap-1.5">
                <label class="text-xs font-medium text-muted-foreground">Item</label>
                <select name="productId[]" class="flex h-9 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" onchange="calculateTotal()">
                    ${productOptions}
                </select>
            </div>
            <div class="grid gap-1.5">
                <label class="text-xs font-medium text-muted-foreground">Qty</label>
                <input type="number" name="quantity[]" placeholder="1" value="${data ? data.quantity : 1}" min="1" class="flex h-9 w-16 rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" oninput="calculateTotal()">
            </div>
            <div class="grid gap-1.5">
                <label class="text-xs font-medium text-muted-foreground">Unit</label>
                 <select name="quantityUnit[]" class="flex h-9 w-20 items-center justify-between rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="pcs" ${data && data.quantityUnit === 'pcs' ? 'selected' : ''}>pcs</option>
                    <option value="kg" ${data && data.quantityUnit === 'kg' ? 'selected' : ''}>kg</option>
                    <option value="ltr" ${data && data.quantityUnit === 'ltr' ? 'selected' : ''}>ltr</option>
                    <option value="box" ${data && data.quantityUnit === 'box' ? 'selected' : ''}>box</option>
                </select>
            </div>
            <button type="button" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive/10 text-destructive hover:bg-destructive/20 h-9 w-9 mb-[1px]" onclick="this.parentElement.remove(); calculateTotal(); lucide.createIcons();">
                <i data-lucide="trash-2" class="h-4 w-4"></i>
            </button>
        `;
        
        productItemsContainer.appendChild(row);
        lucide.createIcons();
    }

    function calculateTotal() {
        let total = 0;
        const rows = productItemsContainer.children;
        for (let row of rows) {
            const select = row.querySelector('select[name="productId[]"]');
            const input = row.querySelector('input[name="quantity[]"]');
            if (select && input) {
                const option = select.options[select.selectedIndex];
                const price = parseFloat(option.getAttribute('data-price') || 0);
                const qty = parseInt(input.value || 0);
                total += price * qty;
            }
        }
        document.getElementById('totalDisplay').textContent = '₦' + total.toFixed(2);
    }

    // Actions
    window.openDetails = async (id) => {
        try {
            const res = await PurchaseService.getPurchaseById(id);
            selectedPurchase = {...res.data, id: res.data._id || res.data.id};
            
            let productsHtml = '';
            if (selectedPurchase.products && selectedPurchase.products.length > 0) {
                productsHtml = `
                <div class="rounded-lg border border-border/50 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-muted/30 text-muted-foreground">
                            <tr>
                                <th class="h-10 px-4 text-left font-medium">Product</th>
                                <th class="h-10 px-4 text-left font-medium">Qty</th>
                                <th class="h-10 px-4 text-right font-medium">Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border/50">
                            ${selectedPurchase.products.map(p => `
                                <tr>
                                    <td class="p-4">${p.name || p.productName}</td>
                                    <td class="p-4">${p.quantity} ${p.quantityUnit || ''}</td>
                                    <td class="p-4 text-right">₦${(p.price || 0).toFixed(2)}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>`;
            }

            detailsContent.innerHTML = `
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <span class="text-xs font-medium text-muted-foreground uppercase">Customer</span>
                        <div class="font-medium">${selectedPurchase.customerName || 'N/A'}</div>
                    </div>
                    <div class="space-y-1">
                        <span class="text-xs font-medium text-muted-foreground uppercase">Date</span>
                        <div class="font-medium">${new Date(selectedPurchase.createdAt || selectedPurchase.date).toLocaleDateString()}</div>
                    </div>
                    <div class="space-y-1">
                        <span class="text-xs font-medium text-muted-foreground uppercase">Payment</span>
                        <div><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors ${selectedPurchase.paymentStatus === 'Paid' ? 'bg-green-500/10 text-green-700 border-green-200' : 'bg-yellow-500/10 text-yellow-700 border-yellow-200'}">${selectedPurchase.paymentStatus}</span></div>
                    </div>
                    <div class="space-y-1">
                        <span class="text-xs font-medium text-muted-foreground uppercase">Delivery</span>
                        <div><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors bg-secondary text-secondary-foreground">${selectedPurchase.deliveryStatus || 'Pending'}</span></div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <h4 class="text-sm font-medium text-muted-foreground uppercase">Items</h4>
                    ${productsHtml}
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-border/50">
                    <span class="text-lg font-bold">Total Amount</span>
                    <span class="text-lg font-bold text-primary">₦${parseFloat(selectedPurchase.total || selectedPurchase.totalAmount || 0).toFixed(2)}</span>
                </div>
            `;
            
            detailsModal.classList.remove('hidden');
        } catch (error) {
            showToast('Failed to fetch details', 'error');
        }
    };

    window.openReceipt = async (id) => {
        try {
             const res = await PurchaseService.getPurchaseById(id);
             const purchase = {...res.data, id: res.data._id || res.data.id};
             
             receiptContent.innerHTML = `
                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold">SalesHostel Digital</h2>
                    <p class="text-muted-foreground text-xs">Receipt #${purchase.purchaseNumber || 'N/A'}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-2 text-sm mb-6">
                    <div class="text-muted-foreground">Customer:</div>
                    <div class="font-medium text-right">${purchase.customerName || 'N/A'}</div>
                    <div class="text-muted-foreground">Date:</div>
                    <div class="font-medium text-right">${new Date(purchase.createdAt || purchase.date).toLocaleDateString()}</div>
                </div>
                
                <div class="border-y border-dashed border-border py-4 space-y-2 mb-6">
                    ${purchase.products.map(item => `
                        <div class="flex justify-between text-sm">
                            <span>${item.quantity}x ${item.name || item.productName}</span>
                            <span class="font-medium">₦${((item.price || 0) * item.quantity).toFixed(2)}</span>
                        </div>
                    `).join('')}
                </div>
                
                <div class="flex justify-between font-bold text-lg mb-6">
                    <span>Total</span>
                    <span>₦${parseFloat(purchase.total || purchase.totalAmount || 0).toFixed(2)}</span>
                </div>
                
                <div class="text-center text-muted-foreground text-xs">
                    <p>Thank you for your business!</p>
                </div>
             `;
             
             receiptModal.classList.remove('hidden');
        } catch (error) {
             showToast('Failed to fetch receipt', 'error');
        }
    };

    window.openEditPurchase = async (id) => {
        try {
            const res = await PurchaseService.getPurchaseById(id);
            const purchase = res.data;
            selectedPurchase = {...purchase, id: purchase._id || purchase.id};
            
            document.getElementById('purchaseId').value = selectedPurchase.id;
            document.getElementById('customerName').value = selectedPurchase.customer?._id || selectedPurchase.customer;
            document.getElementById('paymentStatus').value = selectedPurchase.paymentStatus;
            document.getElementById('deliveryStatus').value = selectedPurchase.deliveryStatus || 'Pending';
            document.getElementById('purchaseNotes').value = selectedPurchase.notes || '';
            
            productItemsContainer.innerHTML = '';
            if (selectedPurchase.products) {
                selectedPurchase.products.forEach(p => {
                    // Find product ID if not directly available
                    const prod = availableProducts.find(ap => ap.name === (p.name || p.productName));
                    addProductRow({
                        productId: p.productId || (prod ? prod.id : ''),
                        quantity: p.quantity,
                        quantityUnit: p.quantityUnit
                    });
                });
            }
            calculateTotal();

            purchaseModalTitle.textContent = 'Edit Purchase';
            detailsModal.classList.add('hidden');
            purchaseModal.classList.remove('hidden');
        } catch (error) {
            console.error(error);
            showToast('Failed to fetch purchase for editing', 'error');
        }
    };

    window.markAsPaid = async (id) => {
        try {
            await PurchaseService.markAsPaid(id);
            showToast('Purchase marked as paid', 'success');
            fetchData();
        } catch (error) {
            showToast('Failed to update status', 'error');
        }
    };

    window.markAsPending = async (id) => {
        try {
            await PurchaseService.markAsPending(id);
            showToast('Purchase marked as pending', 'success');
            fetchData();
        } catch (error) {
            showToast('Failed to update status', 'error');
        }
    };

    window.openDeleteAlert = (id) => {
        purchaseToDelete = id;
        deleteAlert.classList.remove('hidden');
    };

    // Event Listeners
    addPurchaseBtn.addEventListener('click', () => {
        purchaseForm.reset();
        document.getElementById('purchaseId').value = '';
        productItemsContainer.innerHTML = '';
        addProductRow();
        calculateTotal();
        purchaseModalTitle.textContent = 'Create New Purchase';
        purchaseModal.classList.remove('hidden');
    });

    addProductItemBtn.addEventListener('click', () => {
        addProductRow();
        calculateTotal();
    });

    editPurchaseBtn.addEventListener('click', () => {
        if (selectedPurchase) {
            openEditPurchase(selectedPurchase.id);
        }
    });

    confirmDeleteBtn.addEventListener('click', async () => {
        if (!purchaseToDelete) return;
        try {
            await PurchaseService.deletePurchase(purchaseToDelete);
            showToast('Purchase deleted successfully', 'success');
            deleteAlert.classList.add('hidden');
            fetchData();
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    purchaseForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(purchaseForm);
        const id = formData.get('id');
        
        const customer = formData.get('customerName');
        const paymentStatus = formData.get('paymentStatus');
        const deliveryStatus = formData.get('deliveryStatus');
        const notes = formData.get('notes');
        const productIds = formData.getAll('productId[]');
        const quantities = formData.getAll('quantity[]');
        const quantityUnits = formData.getAll('quantityUnit[]');

        const items = [];
        let totalAmount = 0;

        for (let i = 0; i < productIds.length; i++) {
            if (productIds[i]) {
                const qty = parseInt(quantities[i]);
                const product = availableProducts.find(p => p.id === productIds[i]);
                const price = product ? parseFloat(product.sellingPrice) : 0;
                
                items.push({
                    product: productIds[i],
                    quantity: qty,
                    quantityUnit: quantityUnits[i],
                    price: price
                });
                totalAmount += price * qty;
            }
        }

        if (items.length === 0) {
            showToast('Please select at least one product', 'error');
            return;
        }

        const purchaseData = {
            customer,
            paymentStatus,
            deliveryStatus,
            notes,
            products: items,
            totalAmount
        };

        try {
            if (id) {
                await PurchaseService.updatePurchase(id, purchaseData);
                showToast('Purchase updated successfully', 'success');
            } else {
                await PurchaseService.createPurchase(purchaseData);
                showToast('Purchase created successfully', 'success');
            }
            purchaseModal.classList.add('hidden');
            fetchData();
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    // Filtering
    function filterPurchases() {
        const term = searchInput.value.toLowerCase();
        const status = statusFilter.value;
        const date = dateFilter.value;

        const filtered = allPurchases.filter(p => {
            const matchesTerm = (p.purchaseNumber && p.purchaseNumber.toLowerCase().includes(term)) || 
                              (p.customerName && p.customerName.toLowerCase().includes(term));
            
            const matchesStatus = !status || p.paymentStatus === status;
            
            const pDate = new Date(p.createdAt || p.date).toISOString().split('T')[0];
            const matchesDate = !date || pDate === date;
            
            return matchesTerm && matchesStatus && matchesDate;
        });
        renderPurchases(filtered);
    }

    searchInput.addEventListener('input', filterPurchases);
    statusFilter.addEventListener('change', filterPurchases);
    dateFilter.addEventListener('change', filterPurchases);

    // Initial Load
    fetchData();

</script>
</body>
</html>
