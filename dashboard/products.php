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
                            Products
                        </h1>
                        <p class="text-muted-foreground">Manage your product inventory.</p>
                    </div>
                    <button id="addProductBtn" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-0.5 transition-all duration-200">
                        <i data-lucide="plus-circle" class="mr-2 h-4 w-4"></i>
                        Add Product
                    </button>
                </div>

                <div class="glass-card rounded-xl p-6 space-y-6">
                    <!-- Search -->
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-3 h-4 w-4 text-muted-foreground"></i>
                        <input type="search" id="searchInput" placeholder="Search by name, group, or tag..." class="flex h-10 w-full md:w-1/3 rounded-lg border border-input bg-background/50 px-3 py-2 pl-9 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                    </div>

                    <!-- Table -->
                    <div class="rounded-lg border border-border/50 overflow-hidden">
                        <div class="relative w-full overflow-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-muted-foreground uppercase bg-muted/30">
                                    <tr>
                                        <th class="px-6 py-3 font-medium w-[80px]">Image</th>
                                        <th class="px-6 py-3 font-medium">Name</th>
                                        <th class="px-6 py-3 font-medium">Group</th>
                                        <th class="px-6 py-3 font-medium">Stock</th>
                                        <th class="px-6 py-3 font-medium text-right">Price</th>
                                        <th class="px-6 py-3 font-medium text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="productsTableBody" class="divide-y divide-border/50 bg-card/50">
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-muted-foreground">
                                            <div class="flex flex-col items-center gap-2">
                                                <i data-lucide="loader-2" class="h-6 w-6 animate-spin text-primary"></i>
                                                <span>Loading products...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Unique Names Card -->
                    <div class="glass-card rounded-xl p-6 space-y-4 fade-up" style="animation-delay: 0.1s;">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="p-2 bg-primary/10 rounded-lg text-primary">
                                <i data-lucide="text" class="h-5 w-5"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg">Unique Names</h3>
                                <p class="text-sm text-muted-foreground">Manage unique names for selection.</p>
                            </div>
                        </div>
                        
                        <form id="uniqueNameForm" class="flex gap-2">
                            <input type="text" id="newUniqueName" placeholder="Add new unique name" class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                            <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-sm">
                                Add
                            </button>
                        </form>
                        
                        <div class="h-48 overflow-y-auto pr-2 custom-scrollbar">
                            <div id="uniqueNamesList" class="flex flex-col gap-2">
                                <!-- Unique Names List -->
                            </div>
                        </div>
                    </div>

                    <!-- Groups Card -->
                    <div class="glass-card rounded-xl p-6 space-y-4 fade-up" style="animation-delay: 0.2s;">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="p-2 bg-blue-500/10 rounded-lg text-blue-600">
                                <i data-lucide="tags" class="h-5 w-5"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg">Groups</h3>
                                <p class="text-sm text-muted-foreground">Manage product categorization.</p>
                            </div>
                        </div>

                        <form id="groupForm" class="flex gap-2">
                            <input type="text" id="newGroup" placeholder="Add new group" class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                            <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-sm">
                                Add
                            </button>
                        </form>
                        
                        <div class="h-48 overflow-y-auto pr-2 custom-scrollbar">
                            <div id="groupsList" class="flex flex-col gap-2">
                                <!-- Groups List -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Product Modal -->
<?php
$productFormContent = '
<form id="productForm" class="grid gap-6">
    <input type="hidden" name="id" id="productId">
    <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
        <div class="grid gap-2">
            <label class="text-sm font-medium leading-none" for="productName">Name</label>
            <input type="text" name="name" id="productName" placeholder="Product Name" required class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div class="grid gap-2">
                <label class="text-sm font-medium leading-none" for="productGroup">Group</label>
                <select name="group" id="productGroup" class="flex h-10 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                    <option value="">Select Group</option>
                </select>
            </div>
            <div class="grid gap-2">
                <label class="text-sm font-medium leading-none" for="productUniqueName">Unique Name (Optional)</label>
                <select name="uniqueName" id="productUniqueName" class="flex h-10 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                    <option value="">Select Unique Name</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="grid gap-2">
                <label class="text-sm font-medium leading-none" for="productPrice">Selling Price</label>
                <input type="number" name="sellingPrice" id="productPrice" step="0.01" placeholder="0.00" required class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
            </div>
            <div class="grid gap-2">
                <label class="text-sm font-medium leading-none" for="productCost">Cost Price</label>
                <input type="number" name="costPrice" id="productCost" step="0.01" placeholder="0.00" required class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="grid gap-2">
                <label class="text-sm font-medium leading-none" for="productQuantity">Quantity Available</label>
                <input type="number" name="quantityAvailable" id="productQuantity" placeholder="0" class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
            </div>
            <div class="grid gap-2">
                <label class="text-sm font-medium leading-none" for="productUnit">Quantity Unit</label>
                <input type="text" name="quantityUnit" id="productUnit" placeholder="e.g., kg, pcs" class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
            </div>
        </div>

        <div class="grid gap-2">
            <label class="text-sm font-medium leading-none" for="productImage">Image URL</label>
            <input type="text" name="imageUrl" id="productImage" placeholder="https://..." class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
        </div>
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-border/50">
        <button type="button" onclick="document.getElementById(\'product-modal\').classList.add(\'hidden\')" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
            Cancel
        </button>
        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20">
            Save Product
        </button>
    </div>
</form>
';

echo UI::dialog('product-modal', 'Add New Product', $productFormContent);
?>

<!-- Edit Group/UniqueName Modal -->
<?php
$editFormContent = '
<div class="grid gap-4 py-4">
    <div class="grid gap-2">
        <label class="text-sm font-medium leading-none" for="edit-value">Name</label>
        <input type="text" id="edit-value" class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
    </div>
</div>
<div class="flex justify-end gap-2">
    <button type="button" onclick="document.getElementById(\'edit-modal\').classList.add(\'hidden\')" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
        Cancel
    </button>
    <button type="button" id="saveEditBtn" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20">
        Save Changes
    </button>
</div>
';
echo UI::dialog('edit-modal', 'Edit Item', $editFormContent);
?>

<!-- Delete Alert Dialog -->
<?php
echo UI::alertDialog('delete-alert', 'Are you absolutely sure?', 'This action cannot be undone.', 'confirmDeleteBtn');
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
    let allProducts = [];
    let allGroups = [];
    let allUniqueNames = [];
    let itemToDelete = null;
    let itemToEdit = null;

    // Elements
    const productsTableBody = document.getElementById('productsTableBody');
    const groupsList = document.getElementById('groupsList');
    const uniqueNamesList = document.getElementById('uniqueNamesList');
    const productModal = document.getElementById('product-modal');
    const productModalTitle = productModal.querySelector('h3');
    const editModal = document.getElementById('edit-modal');
    const editModalTitle = editModal.querySelector('h3');
    const deleteAlert = document.getElementById('delete-alert');
    const deleteAlertDesc = deleteAlert.querySelector('p');
    
    // Forms
    const productForm = document.getElementById('productForm');
    const groupForm = document.getElementById('groupForm');
    const uniqueNameForm = document.getElementById('uniqueNameForm');
    
    // Inputs
    const searchInput = document.getElementById('searchInput');
    const editValueInput = document.getElementById('edit-value');
    const productGroupSelect = document.getElementById('productGroup');
    const productUniqueNameSelect = document.getElementById('productUniqueName');

    // Buttons
    const addProductBtn = document.getElementById('addProductBtn');
    const saveEditBtn = document.getElementById('saveEditBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    // Fetch Data
    async function fetchData() {
        try {
            const [productsRes, groupsRes, uniqueNamesRes] = await Promise.all([
                ProductService.getAllProducts(),
                GroupService.getAllGroups(),
                UniqueNameService.getAllUniqueNames()
            ]);
            
            allProducts = productsRes.data;
            allGroups = groupsRes.data;
            allUniqueNames = uniqueNamesRes.data;

            renderProducts(allProducts);
            renderGroups(allGroups);
            renderUniqueNames(allUniqueNames);
            updateSelects();
        } catch (error) {
            showToast('Failed to fetch data', 'error');
        }
    }

    function updateSelects() {
        productGroupSelect.innerHTML = '<option value="">Select Group</option>' + 
            allGroups.map(g => `<option value="${g.name}">${g.name}</option>`).join('');
        
        productUniqueNameSelect.innerHTML = '<option value="">Select Unique Name</option>' + 
            allUniqueNames.map(u => `<option value="${u.name}">${u.name}</option>`).join('');
    }

    function renderProducts(products) {
        if (products.length === 0) {
            productsTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-8 text-center text-muted-foreground">No products found.</td></tr>`;
            return;
        }

        productsTableBody.innerHTML = products.map(product => `
            <tr class="hover:bg-muted/30 transition-colors">
                <td class="px-6 py-4">
                    <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-lg border border-border/50">
                        <img class="aspect-square h-full w-full object-cover" src="${product.imageUrl || 'https://via.placeholder.com/40'}" alt="${product.name}" onerror="this.src='https://via.placeholder.com/40'" />
                    </span>
                </td>
                <td class="px-6 py-4 font-medium">${product.name}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">${product.group}</span>
                </td>
                <td class="px-6 py-4 text-muted-foreground">${product.quantityAvailable} ${product.quantityUnit}</td>
                <td class="px-6 py-4 text-right font-medium">₦${parseFloat(product.sellingPrice).toLocaleString('en-NG', { minimumFractionDigits: 2 })}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end relative group/dropdown">
                        <button class="inline-flex items-center justify-center rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 w-8">
                            <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                        </button>
                        <div class="absolute right-0 top-8 w-32 rounded-lg border bg-popover p-1 text-popover-foreground shadow-lg hidden group-hover/dropdown:block z-10 bg-white animate-in fade-in zoom-in-95 duration-200">
                            <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openEditProduct('${product.id}')">
                                <i data-lucide="edit" class="mr-2 h-3.5 w-3.5 text-muted-foreground"></i>
                                Edit
                            </div>
                            <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 hover:text-red-600 text-red-600" onclick="openDeleteAlert('product', '${product.id}', '${product.name}')">
                                <i data-lucide="trash-2" class="mr-2 h-3.5 w-3.5"></i>
                                Delete
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        `).join('');
        lucide.createIcons();
    }

    function renderGroups(groups) {
        groupsList.innerHTML = groups.map(group => `
            <div class="flex items-center justify-between p-3 rounded-lg border border-border/50 bg-background/50 hover:bg-muted/50 transition-colors group">
                <span class="font-medium text-sm">${group.name}</span>
                <div class="relative group/dropdown">
                    <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-6 w-6 opacity-0 group-hover:opacity-100 transition-opacity">
                        <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                    </button>
                    <div class="absolute right-0 top-6 w-32 rounded-lg border bg-popover p-1 text-popover-foreground shadow-lg hidden group-hover/dropdown:block z-10 bg-white animate-in fade-in zoom-in-95 duration-200">
                         <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openEditItem('group', '${group.id}', '${group.name}')">
                            <i data-lucide="edit" class="mr-2 h-3.5 w-3.5 text-muted-foreground"></i> Edit
                        </div>
                        <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 hover:text-red-600 text-red-600" onclick="openDeleteAlert('group', '${group.id}', '${group.name}')">
                            <i data-lucide="trash-2" class="mr-2 h-3.5 w-3.5"></i> Delete
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        lucide.createIcons();
    }

    function renderUniqueNames(names) {
        uniqueNamesList.innerHTML = names.map(name => `
            <div class="flex items-center justify-between p-3 rounded-lg border border-border/50 bg-background/50 hover:bg-muted/50 transition-colors group">
                <span class="font-medium text-sm">${name.name}</span>
                <div class="relative group/dropdown">
                    <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-6 w-6 opacity-0 group-hover:opacity-100 transition-opacity">
                        <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                    </button>
                    <div class="absolute right-0 top-6 w-32 rounded-lg border bg-popover p-1 text-popover-foreground shadow-lg hidden group-hover/dropdown:block z-10 bg-white animate-in fade-in zoom-in-95 duration-200">
                         <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openEditItem('uniqueName', '${name.id}', '${name.name}')">
                            <i data-lucide="edit" class="mr-2 h-3.5 w-3.5 text-muted-foreground"></i> Edit
                        </div>
                        <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 hover:text-red-600 text-red-600" onclick="openDeleteAlert('uniqueName', '${name.id}', '${name.name}')">
                            <i data-lucide="trash-2" class="mr-2 h-3.5 w-3.5"></i> Delete
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        lucide.createIcons();
    }

    // Actions
    window.openEditProduct = (id) => {
        const product = allProducts.find(p => p.id === id);
        if (!product) return;
        
        document.getElementById('productId').value = product.id;
        document.getElementById('productName').value = product.name;
        document.getElementById('productGroup').value = product.group;
        document.getElementById('productUniqueName').value = product.uniqueName || '';
        document.getElementById('productPrice').value = product.sellingPrice;
        document.getElementById('productCost').value = product.costPrice || 0;
        document.getElementById('productQuantity').value = product.quantityAvailable;
        document.getElementById('productUnit').value = product.quantityUnit;
        document.getElementById('productImage').value = product.imageUrl || '';
        
        productModalTitle.textContent = 'Edit Product';
        productModal.classList.remove('hidden');
    };

    window.openEditItem = (type, id, value) => {
        itemToEdit = { type, id, value };
        editValueInput.value = value;
        editModalTitle.textContent = `Edit ${type === 'group' ? 'Group' : 'Unique Name'}`;
        editModal.classList.remove('hidden');
    };

    window.openDeleteAlert = (type, id, value) => {
        itemToDelete = { type, id, value };
        deleteAlertDesc.textContent = type === 'product' 
            ? 'This action cannot be undone. This will permanently delete this product.'
            : `This action cannot be undone. This will permanently delete the ${type} "${value}" and all products associated with it.`;
        deleteAlert.classList.remove('hidden');
    };

    // Event Listeners
    addProductBtn.addEventListener('click', () => {
        productForm.reset();
        document.getElementById('productId').value = '';
        productModalTitle.textContent = 'Add New Product';
        productModal.classList.remove('hidden');
    });

    productForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(productForm);
        const data = Object.fromEntries(formData.entries());
        const id = data.id;
        delete data.id;
        
        // Convert types
        data.sellingPrice = parseFloat(data.sellingPrice);
        data.costPrice = parseFloat(data.costPrice);
        data.quantityAvailable = parseInt(data.quantityAvailable);

        try {
            if (id) {
                await ProductService.updateProduct(id, data);
                showToast('Product updated successfully', 'success');
            } else {
                await ProductService.createProduct(data);
                showToast('Product created successfully', 'success');
            }
            productModal.classList.add('hidden');
            fetchData();
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    saveEditBtn.addEventListener('click', async () => {
        if (!itemToEdit) return;
        const newValue = editValueInput.value;
        
        try {
            if (itemToEdit.type === 'group') {
                await GroupService.updateGroup(itemToEdit.id, { name: newValue });
                showToast('Group updated successfully', 'success');
            } else {
                await UniqueNameService.updateUniqueName(itemToEdit.id, { name: newValue });
                showToast('Unique Name updated successfully', 'success');
            }
            editModal.classList.add('hidden');
            fetchData();
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    confirmDeleteBtn.addEventListener('click', async () => {
        if (!itemToDelete) return;
        
        try {
            if (itemToDelete.type === 'product') {
                await ProductService.deleteProduct(itemToDelete.id);
            } else if (itemToDelete.type === 'group') {
                await GroupService.deleteGroup(itemToDelete.id);
            } else {
                await UniqueNameService.deleteUniqueName(itemToDelete.id);
            }
            showToast('Item deleted successfully', 'success');
            deleteAlert.classList.add('hidden');
            fetchData();
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    groupForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const name = document.getElementById('newGroup').value;
        if (!name) return;
        
        try {
            await GroupService.createGroup({ name });
            showToast('Group created successfully', 'success');
            document.getElementById('newGroup').value = '';
            fetchData();
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    uniqueNameForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const name = document.getElementById('newUniqueName').value;
        if (!name) return;
        
        try {
            await UniqueNameService.createUniqueName({ name });
            showToast('Unique Name created successfully', 'success');
            document.getElementById('newUniqueName').value = '';
            fetchData();
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    searchInput.addEventListener('input', (e) => {
        const term = e.target.value.toLowerCase();
        const filtered = allProducts.filter(p => 
            p.name.toLowerCase().includes(term) || 
            p.group.toLowerCase().includes(term) ||
            (p.uniqueName && p.uniqueName.toLowerCase().includes(term))
        );
        renderProducts(filtered);
    });

    // Initial Load
    fetchData();

</script>
</body>
</html>
