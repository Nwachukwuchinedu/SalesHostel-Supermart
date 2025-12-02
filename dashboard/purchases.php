<?php 
include '../includes/head.php'; 
include '../includes/ui/components.php';
?>

<div class="flex min-h-screen w-full flex-col bg-muted/40">
    <?php include '../includes/sidebar.php'; ?>
    
    <div class="flex flex-col sm:gap-4 sm:py-4 md:ml-64">
        <?php include '../includes/dashboard_header.php'; ?>
        
        <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <div class="flex flex-col gap-8 min-w-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-headline font-bold tracking-tight">
                            Purchases
                        </h1>
                        <p class="text-muted-foreground">Manage customer purchases and orders.</p>
                    </div>
                    <?php echo UI::button('New Purchase', ['icon' => 'plus-circle', 'id' => 'addPurchaseBtn']); ?>
                </div>

                <?php
                $searchContent = '
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end mt-4">
                    <div class="md:col-span-2 relative">
                        <i data-lucide="search" class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"></i>
                        ' . UI::input(['type' => 'search', 'placeholder' => 'Search by customer, purchase #...', 'class' => 'pl-8', 'id' => 'searchInput']) . '
                    </div>
                    <div class="grid gap-2">
                        ' . UI::label('Payment Status', 'statusFilter') . '
                        <select id="statusFilter" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            <option value="">All Statuses</option>
                            <option value="Paid">Paid</option>
                            <option value="Pending">Pending</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="Refunded">Refunded</option>
                            <option value="Partial">Partial</option>
                        </select>
                    </div>
                    <div class="grid gap-2">
                        ' . UI::label('Date', 'dateFilter') . '
                        ' . UI::input(['type' => 'date', 'id' => 'dateFilter']) . '
                    </div>
                </div>';

                echo UI::card(
                    UI::table([
                        ['text' => 'Purchase #'],
                        ['text' => 'Customer'],
                        ['text' => 'Payment'],
                        ['text' => 'Date'],
                        ['text' => 'Total', 'class' => 'text-right'],
                        ['text' => 'Actions']
                    ], 'purchasesTableBody'),
                    ['title' => 'Purchase History', 'description' => 'A list of all purchases made by customers.', 'content' => $searchContent]
                );
                ?>
            </div>
        </main>
    </div>
</div>

<!-- Purchase Modal -->
<?php
$purchaseFormContent = '
<form id="purchaseForm" class="grid gap-4">
    <input type="hidden" name="id" id="purchaseId">
    <div class="p-4 space-y-6 max-h-[70vh] overflow-y-auto">
        <div class="grid gap-2">
            ' . UI::label('Customer') . '
            <select name="customerName" id="customerName" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required>
                <option value="">Select a customer</option>
                <!-- Options populated via JS -->
            </select>
        </div>

        <div class="grid gap-2">
            ' . UI::label('Products') . '
            <div class="p-4 space-y-4 border rounded-md mt-2">
                <div id="productItems" class="space-y-2">
                    <!-- Product items will be added here -->
                </div>
                ' . UI::button('Add Product', ['type' => 'button', 'variant' => 'outline', 'icon' => 'plus', 'id' => 'addProductItemBtn']) . '
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="grid gap-2">
                ' . UI::label('Payment Status') . '
                <select name="paymentStatus" id="paymentStatus" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="Pending">Pending</option>
                    <option value="Paid">Paid</option>
                    <option value="Partial">Partial</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="Refunded">Refunded</option>
                </select>
            </div>
            <div class="grid gap-2">
                ' . UI::label('Delivery Status') . '
                <select name="deliveryStatus" id="deliveryStatus" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <div class="grid gap-2">
            ' . UI::label('Notes') . '
            <textarea name="notes" id="purchaseNotes" placeholder="Add any notes for this purchase..." class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"></textarea>
        </div>
    </div>

    <div class="flex justify-between items-center pt-4 border-t px-4 mt-4">
        <div class="text-lg font-semibold">
            Total: <span id="totalDisplay">₦0.00</span>
        </div>
        <div class="flex gap-2">
            ' . UI::button('Cancel', ['variant' => 'outline', 'type' => 'button', 'attrs' => 'onclick="document.getElementById(\'purchase-modal\').classList.add(\'hidden\')"']) . '
            ' . UI::button('Save Purchase', ['type' => 'submit']) . '
        </div>
    </div>
</form>
';

echo UI::dialog('purchase-modal', 'Create New Purchase', $purchaseFormContent);
?>

<!-- Purchase Details Modal -->
<?php
$detailsContent = '
<div id="purchaseDetailsContent" class="space-y-4">
    <!-- Details injected via JS -->
</div>
';
$detailsFooter = '
' . UI::button('Close', ['variant' => 'outline', 'type' => 'button', 'attrs' => 'onclick="document.getElementById(\'details-modal\').classList.add(\'hidden\')"']) . '
' . UI::button('Edit', ['id' => 'editPurchaseBtn']) . '
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
' . UI::button('Close', ['variant' => 'outline', 'type' => 'button', 'attrs' => 'onclick="document.getElementById(\'receipt-modal\').classList.add(\'hidden\')"']) . '
' . UI::button('Print', ['attrs' => 'onclick="window.print()"']) . '
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
            purchasesTableBody.innerHTML = `<tr><td colspan="6" class="p-4 text-center text-muted-foreground">No purchases found.</td></tr>`;
            return;
        }

        purchasesTableBody.innerHTML = purchases.map(purchase => {
            const statusColor = purchase.paymentStatus === 'Paid' 
                ? 'bg-green-500/20 text-green-700 hover:bg-green-500/30' 
                : purchase.paymentStatus === 'Pending' 
                ? 'bg-yellow-500/20 text-yellow-700 hover:bg-yellow-500/30' 
                : 'bg-gray-500/20 text-gray-700 hover:bg-gray-500/30';

            return `
            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0 font-medium">${purchase.purchaseNumber || 'N/A'}</td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">${purchase.customerName || 'N/A'}</td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent ${statusColor}">
                        ${purchase.paymentStatus}
                    </div>
                </td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">${new Date(purchase.createdAt || purchase.date).toLocaleDateString()}</td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0 text-right">₦${parseFloat(purchase.total || purchase.totalAmount || 0).toFixed(2)}</td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                    <div class="flex justify-end relative group/dropdown">
                        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 w-8">
                            <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                        </button>
                        <div class="absolute right-0 top-8 w-32 rounded-md border bg-popover p-1 text-popover-foreground shadow-md hidden group-hover/dropdown:block z-10 bg-white">
                            <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openDetails('${purchase.id}')">
                                View Details
                            </div>
                            <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openReceipt('${purchase.id}')">
                                View Receipt
                            </div>
                            <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openEditPurchase('${purchase.id}')">
                                Edit
                            </div>
                            <div class="h-[1px] bg-border my-1"></div>
                            ${purchase.paymentStatus !== 'Paid' ? 
                                `<div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="markAsPaid('${purchase.id}')">Mark as Paid</div>` : 
                                `<div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="markAsPending('${purchase.id}')">Mark as Pending</div>`
                            }
                            <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground text-red-600" onclick="openDeleteAlert('${purchase.id}')">
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
        row.className = 'grid grid-cols-[1fr_auto_auto_auto] items-end gap-2 p-2 border rounded-lg';
        
        const productOptions = `<option value="">Select Product</option>` + 
            availableProducts.map(p => `<option value="${p.id}" data-price="${p.sellingPrice}" ${data && data.productId === p.id ? 'selected' : ''}>${p.name}</option>`).join('');

        row.innerHTML = `
            <div class="grid gap-2">
                <select name="productId[]" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" onchange="calculateTotal()">
                    ${productOptions}
                </select>
            </div>
            <div class="grid gap-2">
                <input type="number" name="quantity[]" placeholder="Qty" value="${data ? data.quantity : 1}" min="1" class="flex h-10 w-20 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" oninput="calculateTotal()">
            </div>
            <div class="grid gap-2">
                 <select name="quantityUnit[]" class="flex h-10 w-24 items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="pcs" ${data && data.quantityUnit === 'pcs' ? 'selected' : ''}>pcs</option>
                    <option value="kg" ${data && data.quantityUnit === 'kg' ? 'selected' : ''}>kg</option>
                    <option value="ltr" ${data && data.quantityUnit === 'ltr' ? 'selected' : ''}>ltr</option>
                    <option value="box" ${data && data.quantityUnit === 'box' ? 'selected' : ''}>box</option>
                </select>
            </div>
            <button type="button" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-10 w-10" onclick="this.parentElement.remove(); calculateTotal(); lucide.createIcons();">
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
                <h4 class="font-semibold">Products</h4>
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Product</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Quantity</th>
                                <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Price</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            ${selectedPurchase.products.map(p => `
                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-4 align-middle">${p.name || p.productName}</td>
                                    <td class="p-4 align-middle">${p.quantity} ${p.quantityUnit || ''}</td>
                                    <td class="p-4 align-middle text-right">₦${(p.price || 0).toFixed(2)}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>`;
            }

            detailsContent.innerHTML = `
                <div><strong>Customer:</strong> ${selectedPurchase.customerName || 'N/A'}</div>
                <div><strong>Date:</strong> ${new Date(selectedPurchase.createdAt || selectedPurchase.date).toLocaleDateString()}</div>
                <div><strong>Payment Status:</strong> ${selectedPurchase.paymentStatus}</div>
                <div><strong>Delivery Status:</strong> ${selectedPurchase.deliveryStatus || 'Pending'}</div>
                <div class="h-[1px] w-full bg-border my-4"></div>
                ${productsHtml}
                <div class="h-[1px] w-full bg-border my-4"></div>
                <div class="text-right font-bold text-lg">
                    Total: ₦${parseFloat(selectedPurchase.total || selectedPurchase.totalAmount || 0).toFixed(2)}
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
                <div class="h-[1px] w-full bg-border my-4"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><strong>Customer:</strong></div>
                    <div>${purchase.customerName || 'N/A'}</div>
                    <div><strong>Date:</strong></div>
                    <div>${new Date(purchase.createdAt || purchase.date).toLocaleDateString()}</div>
                    <div><strong>Purchase #:</strong></div>
                    <div>${purchase.purchaseNumber || 'N/A'}</div>
                </div>
                <div class="h-[1px] w-full bg-border my-4"></div>
                <div class="space-y-2">
                    ${purchase.products.map(item => `
                        <div class="flex justify-between">
                            <span>${item.quantity}x ${item.name || item.productName}</span>
                            <span>₦${((item.price || 0) * item.quantity).toFixed(2)}</span>
                        </div>
                    `).join('')}
                </div>
                <div class="h-[1px] w-full bg-border my-4"></div>
                <div class="flex justify-between font-bold text-base">
                    <span>Total</span>
                    <span>₦${parseFloat(purchase.total || purchase.totalAmount || 0).toFixed(2)}</span>
                </div>
                <div class="h-[1px] w-full bg-border my-4"></div>
                <div class="text-center text-muted-foreground text-xs">
                    <p>Thank you for your purchase!</p>
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
