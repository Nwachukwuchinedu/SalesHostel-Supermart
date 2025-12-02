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
                            Supplies
                        </h1>
                        <p class="text-muted-foreground">Track incoming product supplies.</p>
                    </div>
                    <?php echo UI::button('Add Supply', ['icon' => 'plus-circle', 'id' => 'addSupplyBtn']); ?>
                </div>

                <?php
                $searchContent = '
                <div class="grid md:grid-cols-3 gap-4 mt-4">
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"></i>
                        ' . UI::input(['type' => 'search', 'placeholder' => 'Search by ID, supplier...', 'class' => 'pl-8', 'id' => 'searchInput']) . '
                    </div>
                    ' . UI::input(['type' => 'date', 'placeholder' => 'From Date', 'id' => 'fromDate']) . '
                    ' . UI::input(['type' => 'date', 'placeholder' => 'To Date', 'id' => 'toDate']) . '
                </div>';

                echo UI::card(
                    UI::table([
                        ['text' => 'Supply ID'],
                        ['text' => 'Supplier'],
                        ['text' => 'Status'],
                        ['text' => 'Date'],
                        ['text' => 'Total Amount', 'class' => 'text-right'],
                        ['text' => 'Actions']
                    ], 'suppliesTableBody'),
                    ['title' => 'Supply Records', 'description' => 'A log of all supplies received from suppliers.', 'content' => $searchContent]
                );
                ?>
            </div>
        </main>
    </div>
</div>

<!-- Supply Modal -->
<?php
$supplyFormContent = '
<form id="supplyForm" class="grid gap-4">
    <input type="hidden" name="id" id="supplyId">
    <div class="grid gap-2">
        ' . UI::label('Supplier Name') . '
        ' . UI::input(['name' => 'supplierName', 'id' => 'supplierName', 'placeholder' => 'Supplier Name', 'required' => true]) . '
    </div>
    
    <div class="grid gap-2">
        ' . UI::label('Products') . '
        <div id="productItems" class="space-y-2">
            <!-- Product items will be added here -->
        </div>
        ' . UI::button('Add Product', ['type' => 'button', 'variant' => 'outline', 'icon' => 'plus', 'id' => 'addProductItemBtn']) . '
    </div>

    <div class="grid gap-2">
        ' . UI::label('Status') . '
        <select name="status" id="supplyStatus" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
            <option value="Paid">Paid</option>
            <option value="Pending">Pending</option>
        </select>
    </div>

    <div class="flex justify-between items-center pt-4 border-t px-4 mt-4">
        <div class="text-lg font-semibold">
            Total Cost: <span id="totalCostDisplay">₦0.00</span>
        </div>
        <div class="flex gap-2">
            ' . UI::button('Cancel', ['variant' => 'outline', 'type' => 'button', 'attrs' => 'onclick="document.getElementById(\'supply-modal\').classList.add(\'hidden\')"']) . '
            ' . UI::button('Save Supply', ['type' => 'submit']) . '
        </div>
    </div>
</form>
';

echo UI::dialog('supply-modal', 'Add New Supply', $supplyFormContent);
?>

<!-- Supply Details Modal -->
<?php
$detailsContent = '
<div id="supplyDetailsContent" class="space-y-4">
    <!-- Details injected via JS -->
</div>
';
$detailsFooter = '
' . UI::button('Close', ['variant' => 'outline', 'type' => 'button', 'attrs' => 'onclick="document.getElementById(\'details-modal\').classList.add(\'hidden\')"']) . '
' . UI::button('Edit', ['id' => 'editSupplyBtn']) . '
';

echo UI::dialog('details-modal', 'Supply Details', $detailsContent, $detailsFooter);
?>

<!-- Delete Alert Dialog -->
<?php
echo UI::alertDialog('delete-alert', 'Are you absolutely sure?', 'This action cannot be undone. This will permanently delete this supply record.', 'confirmDeleteBtn');
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
    let allSupplies = [];
    let availableProducts = [];
    let selectedSupply = null;
    let supplyToDelete = null;

    // Elements
    const suppliesTableBody = document.getElementById('suppliesTableBody');
    const supplyModal = document.getElementById('supply-modal');
    const supplyModalTitle = supplyModal.querySelector('h3');
    const detailsModal = document.getElementById('details-modal');
    const detailsContent = document.getElementById('supplyDetailsContent');
    const deleteAlert = document.getElementById('delete-alert');
    
    // Forms
    const supplyForm = document.getElementById('supplyForm');
    const productItemsContainer = document.getElementById('productItems');
    
    // Inputs
    const searchInput = document.getElementById('searchInput');
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');

    // Buttons
    const addSupplyBtn = document.getElementById('addSupplyBtn');
    const addProductItemBtn = document.getElementById('addProductItemBtn');
    const editSupplyBtn = document.getElementById('editSupplyBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    // Fetch Data
    async function fetchData() {
        try {
            const [suppliesRes, productsRes] = await Promise.all([
                SupplyService.getAllSupplies(),
                ProductService.getAllProducts()
            ]);
            
            allSupplies = suppliesRes.data.map(s => ({...s, id: s._id || s.id}));
            availableProducts = productsRes.data.map(p => ({...p, id: p._id || p.id}));
            
            renderSupplies(allSupplies);
        } catch (error) {
            showToast('Failed to fetch data', 'error');
        }
    }

    function renderSupplies(supplies) {
        if (supplies.length === 0) {
            suppliesTableBody.innerHTML = `<tr><td colspan="6" class="p-4 text-center text-muted-foreground">No supplies found.</td></tr>`;
            return;
        }

        suppliesTableBody.innerHTML = supplies.map(supply => {
            const statusColor = supply.paymentStatus === 'Paid' 
                ? 'bg-green-500/20 text-green-700 hover:bg-green-500/30' 
                : supply.paymentStatus === 'Pending' 
                ? 'bg-yellow-500/20 text-yellow-700 hover:bg-yellow-500/30' 
                : 'bg-gray-500/20 text-gray-700 hover:bg-gray-500/30';

            return `
            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0 font-medium">${supply.supplyId || 'N/A'}</td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">${supply.supplierName || 'N/A'}</td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent ${statusColor}">
                        ${supply.paymentStatus || supply.status}
                    </div>
                </td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">${new Date(supply.updatedAt || supply.createdAt).toLocaleDateString()}</td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0 text-right">₦${parseFloat(supply.totalAmount || 0).toFixed(2)}</td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                    <div class="flex justify-end relative group/dropdown">
                        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 w-8">
                            <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                        </button>
                        <div class="absolute right-0 top-8 w-32 rounded-md border bg-popover p-1 text-popover-foreground shadow-md hidden group-hover/dropdown:block z-10 bg-white">
                            <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openDetails('${supply.id}')">
                                View Details
                            </div>
                            <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openEditSupply('${supply.id}')">
                                Edit
                            </div>
                            <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground text-red-600" onclick="openDeleteAlert('${supply.id}')">
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
        row.className = 'flex gap-2 items-center';
        
        const productOptions = `<option value="">Select Product</option>` + 
            availableProducts.map(p => `<option value="${p.id}" ${data && data.productId === p.id ? 'selected' : ''}>${p.name} (Cost: ₦${p.costPrice || 0})</option>`).join('');

        row.innerHTML = `
            <select name="productId[]" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                ${productOptions}
            </select>
            <input type="number" name="quantity[]" placeholder="Qty" value="${data ? data.quantity : 1}" min="1" class="flex h-10 w-20 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
            <input type="number" name="cost[]" placeholder="Cost" value="${data ? data.costPrice : ''}" min="0" step="0.01" class="flex h-10 w-24 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
            <button type="button" class="text-red-500 hover:text-red-700" onclick="this.parentElement.remove(); lucide.createIcons();">
                <i data-lucide="trash-2" class="h-4 w-4"></i>
            </button>
        `;
        
        productItemsContainer.appendChild(row);
        lucide.createIcons();
    }

    // Actions
    window.openDetails = async (id) => {
        try {
            const res = await SupplyService.getSupplyById(id);
            selectedSupply = {...res.data, id: res.data._id || res.data.id};
            
            let productsHtml = '';
            if (selectedSupply.products && selectedSupply.products.length > 0) {
                productsHtml = `
                <h4 class="font-semibold">Products Supplied</h4>
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Product</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Quantity</th>
                                <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Cost</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            ${selectedSupply.products.map(p => `
                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-4 align-middle">${p.productName || 'Unknown'}</td>
                                    <td class="p-4 align-middle">${p.quantity} ${p.quantityType || ''}</td>
                                    <td class="p-4 align-middle text-right">₦${(p.totalCost || 0).toFixed(2)}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>`;
            }

            detailsContent.innerHTML = `
                <div><strong>Supplier:</strong> ${selectedSupply.supplierName || 'N/A'}</div>
                <div><strong>Date:</strong> ${new Date(selectedSupply.updatedAt || selectedSupply.createdAt).toLocaleDateString()}</div>
                <div><strong>Status:</strong> ${selectedSupply.paymentStatus || selectedSupply.status}</div>
                <div class="h-[1px] w-full bg-border my-4"></div>
                ${productsHtml}
                <div class="h-[1px] w-full bg-border my-4"></div>
                <div class="text-right font-bold text-lg">
                    Total Amount: ₦${parseFloat(selectedSupply.totalAmount || 0).toFixed(2)}
                </div>
            `;
            
            detailsModal.classList.remove('hidden');
        } catch (error) {
            showToast('Failed to fetch details', 'error');
        }
    };

    window.openEditSupply = async (id) => {
        try {
            const res = await SupplyService.getSupplyById(id);
            const supply = res.data;
            
            document.getElementById('supplyId').value = supply._id || supply.id;
            document.getElementById('supplierName').value = supply.supplierName;
            document.getElementById('supplyStatus').value = supply.paymentStatus || supply.status;
            
            productItemsContainer.innerHTML = '';
            if (supply.products) {
                supply.products.forEach(p => {
                    // Find product ID if not directly available (mock logic might need adjustment)
                    const prod = availableProducts.find(ap => ap.name === p.productName);
                    addProductRow({
                        productId: p.productId || (prod ? prod.id : ''),
                        quantity: p.quantity,
                        costPrice: p.costPrice || (p.totalCost / p.quantity)
                    });
                });
            }

            supplyModalTitle.textContent = 'Edit Supply';
            detailsModal.classList.add('hidden');
            supplyModal.classList.remove('hidden');
        } catch (error) {
            showToast('Failed to fetch supply for editing', 'error');
        }
    };

    window.openDeleteAlert = (id) => {
        supplyToDelete = id;
        deleteAlert.classList.remove('hidden');
    };

    // Total Cost Calculation
    function calculateTotalCost() {
        const costInputs = document.querySelectorAll('input[name="cost[]"]');
        let total = 0;
        costInputs.forEach(input => {
            total += parseFloat(input.value || 0);
        });
        document.getElementById('totalCostDisplay').textContent = '₦' + total.toFixed(2);
    }

    // Event delegation for cost inputs
    productItemsContainer.addEventListener('input', (e) => {
        if (e.target.name === 'cost[]') {
            calculateTotalCost();
        }
    });

    // Update addProductRow to trigger calculation on removal
    const originalAddProductRow = addProductRow;
    addProductRow = function(data = null) {
        originalAddProductRow(data);
        calculateTotalCost();
    };

    // Override remove button click to recalculate
    productItemsContainer.addEventListener('click', (e) => {
        if (e.target.closest('button') && e.target.closest('button').classList.contains('text-red-500')) {
            setTimeout(calculateTotalCost, 0); // Wait for element to be removed
        }
    });

    // Event Listeners
    addSupplyBtn.addEventListener('click', () => {
        supplyForm.reset();
        document.getElementById('supplyId').value = '';
        productItemsContainer.innerHTML = '';
        addProductRow();
        calculateTotalCost();
        supplyModalTitle.textContent = 'Add New Supply';
        supplyModal.classList.remove('hidden');
    });

    addProductItemBtn.addEventListener('click', () => {
        // addProductRow is already overridden to call calculateTotalCost
    });

    editSupplyBtn.addEventListener('click', () => {
        if (selectedSupply) {
            openEditSupply(selectedSupply.id);
            // Calculate total after populating
            setTimeout(calculateTotalCost, 100);
        }
    });


    confirmDeleteBtn.addEventListener('click', async () => {
        if (!supplyToDelete) return;
        try {
            await SupplyService.deleteSupply(supplyToDelete);
            showToast('Supply deleted successfully', 'success');
            deleteAlert.classList.add('hidden');
            fetchData();
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    supplyForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(supplyForm);
        const id = formData.get('id');
        
        const supplierName = formData.get('supplierName');
        const status = formData.get('status');
        const productIds = formData.getAll('productId[]');
        const quantities = formData.getAll('quantity[]');
        const costs = formData.getAll('cost[]');

        const items = [];
        let totalAmount = 0;

        for (let i = 0; i < productIds.length; i++) {
            if (productIds[i]) {
                const qty = parseInt(quantities[i]);
                const cost = parseFloat(costs[i] || 0);
                items.push({
                    productId: productIds[i],
                    quantity: qty,
                    costPrice: cost
                });
                totalAmount += cost * qty;
            }
        }

        if (items.length === 0) {
            showToast('Please select at least one product', 'error');
            return;
        }

        const supplyData = {
            supplierName,
            status, // Note: Backend might expect 'paymentStatus' or 'status' depending on implementation
            paymentStatus: status,
            items,
            totalAmount
        };

        try {
            if (id) {
                await SupplyService.updateSupply(id, supplyData);
                showToast('Supply updated successfully', 'success');
            } else {
                await SupplyService.createSupply(supplyData);
                showToast('Supply created successfully', 'success');
            }
            supplyModal.classList.add('hidden');
            fetchData();
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    // Filtering
    function filterSupplies() {
        const term = searchInput.value.toLowerCase();
        const from = fromDate.value;
        const to = toDate.value;

        const filtered = allSupplies.filter(s => {
            const matchesTerm = (s.supplyId && s.supplyId.toLowerCase().includes(term)) || 
                              (s.supplierName && s.supplierName.toLowerCase().includes(term));
            
            const date = new Date(s.updatedAt || s.createdAt).toISOString().split('T')[0];
            const matchesFrom = !from || date >= from;
            const matchesTo = !to || date <= to;
            
            return matchesTerm && matchesFrom && matchesTo;
        });
        renderSupplies(filtered);
    }

    searchInput.addEventListener('input', filterSupplies);
    fromDate.addEventListener('change', filterSupplies);
    toDate.addEventListener('change', filterSupplies);

    // Initial Load
    fetchData();

</script>
</body>
</html>
