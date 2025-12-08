<?php 
include __DIR__ . '/../includes/head.php'; 
include __DIR__ . '/../includes/ui/components.php';
?>

<div class="flex min-h-screen w-full flex-col bg-muted/20">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="flex flex-col sm:gap-4 sm:py-4 md:ml-64 transition-all duration-300">
        <?php include __DIR__ . '/../includes/dashboard_header.php'; ?>
        
        <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <div class="flex flex-col gap-8 min-w-0 fade-up">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-headline font-bold tracking-tight">
                            Supplies
                        </h1>
                        <p class="text-muted-foreground">Track incoming product supplies.</p>
                    </div>
                    <button id="addSupplyBtn" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-0.5 transition-all duration-200">
                        <i data-lucide="plus-circle" class="mr-2 h-4 w-4"></i>
                        Add Supply
                    </button>
                </div>

                <div class="glass-card rounded-xl p-6 space-y-6">
                    <!-- Filters -->
                    <div class="grid md:grid-cols-3 gap-4 items-end">
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-3 h-4 w-4 text-muted-foreground"></i>
                            <input type="search" id="searchInput" placeholder="Search by ID, supplier..." class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 pl-9 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                        </div>
                        <div class="grid gap-2">
                            <label for="fromDate" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">From Date</label>
                            <input type="date" id="fromDate" class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                        </div>
                        <div class="grid gap-2">
                            <label for="toDate" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">To Date</label>
                            <input type="date" id="toDate" class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="rounded-lg border border-border/50 overflow-hidden">
                        <div class="relative w-full overflow-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-muted-foreground uppercase bg-muted/30">
                                    <tr>
                                        <th class="px-6 py-3 font-medium">Supply ID</th>
                                        <th class="px-6 py-3 font-medium">Supplier</th>
                                        <th class="px-6 py-3 font-medium">Status</th>
                                        <th class="px-6 py-3 font-medium">Date</th>
                                        <th class="px-6 py-3 font-medium text-right">Total Amount</th>
                                        <th class="px-6 py-3 font-medium text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="suppliesTableBody" class="divide-y divide-border/50 bg-card/50">
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-muted-foreground">
                                            <div class="flex flex-col items-center gap-2">
                                                <i data-lucide="loader-2" class="h-6 w-6 animate-spin text-primary"></i>
                                                <span>Loading supplies...</span>
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

<!-- Supply Modal -->
<?php
$supplyFormContent = '
<form id="supplyForm" class="grid gap-6">
    <input type="hidden" name="id" id="supplyId">
    <div class="space-y-6 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
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

        <div class="grid gap-2">
            <label class="text-sm font-medium leading-none" for="supplyNotes">Notes (Optional)</label>
            <textarea name="notes" id="supplyNotes" placeholder="Add any notes..." class="flex min-h-[80px] w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary resize-y"></textarea>
        </div>
    </div>

    <div class="flex justify-end items-center pt-4 border-t border-border/50">
        <div class="flex gap-2">
            <button type="button" onclick="document.getElementById(\'supply-modal\').classList.add(\'hidden\')" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                Cancel
            </button>
            <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20">
                Save Supply
            </button>
        </div>
    </div>
</form>
';

echo UI::dialog('supply-modal', 'Add New Supply', $supplyFormContent);
?>

<!-- Supply Details Modal -->
<?php
$detailsContent = '
<div id="supplyDetailsContent" class="space-y-6">
    <!-- Details injected via JS -->
</div>
';
$detailsFooter = '
<button type="button" onclick="document.getElementById(\'details-modal\').classList.add(\'hidden\')" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
    Close
</button>
<button type="button" id="editSupplyBtn" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20">
    Edit
</button>
';

echo UI::dialog('details-modal', 'Supply Details', $detailsContent, $detailsFooter);
?>

<!-- Delete Alert Dialog -->
<?php
echo UI::alertDialog('delete-alert', 'Are you absolutely sure?', 'This action cannot be undone. This will permanently delete this supply record.', 'confirmDeleteBtn');
?>

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
            suppliesTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-8 text-center text-muted-foreground">No supplies found.</td></tr>`;
            return;
        }

        suppliesTableBody.innerHTML = supplies.map(supply => {
            const statusColor = supply.paymentStatus === 'Paid' 
                ? 'bg-green-500/10 text-green-700 border-green-200' 
                : supply.paymentStatus === 'Pending' 
                ? 'bg-yellow-500/10 text-yellow-700 border-yellow-200' 
                : 'bg-gray-500/10 text-gray-700 border-gray-200';

            return `
            <tr class="hover:bg-muted/30 transition-colors">
                <td class="px-6 py-4 font-medium">${supply.supplyId || 'N/A'}</td>
                <td class="px-6 py-4">${supply.supplierName || 'N/A'}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors ${statusColor}">
                        ${supply.paymentStatus || supply.status}
                    </span>
                </td>
                <td class="px-6 py-4 text-muted-foreground">${new Date(supply.updatedAt || supply.createdAt).toLocaleDateString()}</td>
                <td class="px-6 py-4 text-right font-medium">₦${parseFloat(supply.totalAmount || 0).toLocaleString('en-NG', { minimumFractionDigits: 2 })}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end relative group/dropdown">
                        <button class="inline-flex items-center justify-center rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 w-8">
                            <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                        </button>
                        <div class="absolute right-0 top-8 w-32 rounded-lg border bg-popover p-1 text-popover-foreground shadow-lg hidden group-hover/dropdown:block z-10 bg-white animate-in fade-in zoom-in-95 duration-200">
                            <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openDetails('${supply.id}')">
                                <i data-lucide="eye" class="mr-2 h-3.5 w-3.5 text-muted-foreground"></i>
                                View Details
                            </div>
                            <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openEditSupply('${supply.id}')">
                                <i data-lucide="edit" class="mr-2 h-3.5 w-3.5 text-muted-foreground"></i>
                                Edit
                            </div>
                            <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 hover:text-red-600 text-red-600" onclick="openDeleteAlert('${supply.id}')">
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
        row.className = 'grid grid-cols-[1fr_auto_auto] items-end gap-2 p-3 border border-border/50 rounded-lg bg-background shadow-sm animate-in fade-in slide-in-from-bottom-2 duration-300';
        
        const productOptions = `<option value="">Select Product</option>` + 
            availableProducts.map(p => `<option value="${p.id}" ${data && data.productId === p.id ? 'selected' : ''}>${p.name} (Cost: ₦${p.costPrice || 0})</option>`).join('');

        row.innerHTML = `
            <div class="grid gap-1.5">
                <label class="text-xs font-medium text-muted-foreground">Product</label>
                <select name="productId[]" class="flex h-9 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    ${productOptions}
                </select>
            </div>
            <div class="grid gap-1.5">
                <label class="text-xs font-medium text-muted-foreground">Qty</label>
                <input type="number" name="quantity[]" placeholder="Qty" value="${data ? data.quantity : 1}" min="1" class="flex h-9 w-24 rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
            </div>
            <button type="button" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive/10 text-destructive hover:bg-destructive/20 h-9 w-9 mb-[1px]" onclick="this.parentElement.remove(); lucide.createIcons();">
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
                <div class="rounded-lg border border-border/50 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-muted/30 text-muted-foreground">
                            <tr>
                                <th class="h-10 px-4 text-left font-medium">Product</th>
                                <th class="h-10 px-4 text-left font-medium">Qty</th>
                                <th class="h-10 px-4 text-right font-medium">Cost</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border/50">
                            ${selectedSupply.products.map(p => `
                                <tr>
                                    <td class="p-4">${p.productName || 'Unknown'}</td>
                                    <td class="p-4">${p.quantity} ${p.quantityType || ''}</td>
                                    <td class="p-4 text-right">₦${(p.totalCost || 0).toFixed(2)}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>`;
            }

            detailsContent.innerHTML = `
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <span class="text-xs font-medium text-muted-foreground uppercase">Supplier</span>
                        <div class="font-medium">${selectedSupply.supplierName || 'N/A'}</div>
                    </div>
                    <div class="space-y-1">
                        <span class="text-xs font-medium text-muted-foreground uppercase">Date</span>
                        <div class="font-medium">${new Date(selectedSupply.updatedAt || selectedSupply.createdAt).toLocaleDateString()}</div>
                    </div>
                    <div class="space-y-1">
                        <span class="text-xs font-medium text-muted-foreground uppercase">Status</span>
                        <div><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors ${selectedSupply.paymentStatus === 'Paid' ? 'bg-green-500/10 text-green-700 border-green-200' : 'bg-yellow-500/10 text-yellow-700 border-yellow-200'}">${selectedSupply.paymentStatus || selectedSupply.status}</span></div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <h4 class="text-sm font-medium text-muted-foreground uppercase">Items</h4>
                    ${productsHtml}
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-border/50">
                    <span class="text-lg font-bold">Total Amount</span>
                    <span class="text-lg font-bold text-primary">₦${parseFloat(selectedSupply.totalAmount || 0).toFixed(2)}</span>
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
            selectedSupply = {...supply, id: supply._id || supply.id};
            
            document.getElementById('supplyId').value = selectedSupply.id;
            document.getElementById('supplyId').value = selectedSupply.id;
            document.getElementById('supplyNotes').value = selectedSupply.notes || '';
            
            productItemsContainer.innerHTML = '';
            if (selectedSupply.products) {
                selectedSupply.products.forEach(p => {
                    // Robust ID finding (Handle 'product' or 'productId')
                    let pId = p.productId;
                    if (!pId && p.product) {
                        pId = typeof p.product === 'object' ? (p.product._id || p.product.id) : p.product;
                    }
                    
                    if (!pId && p.productName) {
                         const prod = availableProducts.find(ap => ap.name === p.productName);
                         if (prod) pId = prod.id;
                    }

                    addProductRow({
                        productId: pId || '',
                        quantity: p.quantity
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

    // Total Cost Calculation (Removed - handled by backend)

    // Event Listeners
    addSupplyBtn.addEventListener('click', () => {
        supplyForm.reset();
        document.getElementById('supplyId').value = '';
        document.getElementById('supplyNotes').value = '';
        productItemsContainer.innerHTML = '';
        addProductRow();
        supplyModalTitle.textContent = 'Add New Supply';
        supplyModal.classList.remove('hidden');
    });

    addProductItemBtn.addEventListener('click', () => {
        addProductRow();
    });

    editSupplyBtn.addEventListener('click', () => {
        if (selectedSupply) {
            openEditSupply(selectedSupply.id);
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
        
        const notes = formData.get('notes');
        const productIds = formData.getAll('productId[]');
        const quantities = formData.getAll('quantity[]');
        const costs = formData.getAll('cost[]');

        const products = [];

        for (let i = 0; i < productIds.length; i++) {
            if (productIds[i]) {
                const qty = parseInt(quantities[i]);
                products.push({
                    product: productIds[i],
                    quantity: qty
                });
            }
        }

        if (products.length === 0) {
            showToast('Please select at least one product', 'error');
            return;
        }

        const supplyData = {
            products,
            notes
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
