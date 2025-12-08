<?php 
include __DIR__ . '/../includes/head.php'; 
include __DIR__ . '/../includes/ui/components.php';
?>

<div class="flex min-h-screen w-full flex-col bg-muted/20">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="flex flex-col sm:gap-4 sm:py-4 md:ml-64 transition-all duration-300">
        <?php include __DIR__ . '/../includes/dashboard_header.php'; ?>
        
        <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <div class="flex flex-col gap-8 min-w-0">
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

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
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

                    <!-- Quantity Units Card -->
                    <div class="glass-card rounded-xl p-6 space-y-4">
                        <div class="flex items-center justify-between mb-2">
                             <div class="flex items-center gap-2">
                                <div class="p-2 bg-green-500/10 rounded-lg text-green-600">
                                    <i data-lucide="scale" class="h-5 w-5"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg">Quantity Units</h3>
                                    <p class="text-sm text-muted-foreground">Manage measurement units.</p>
                                </div>
                             </div>
                             <button onclick="openQuantityUnitModal()" class="inline-flex items-center justify-center rounded-lg text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none bg-primary text-primary-foreground hover:bg-primary/90 h-8 w-8 shadow-sm">
                                <i data-lucide="plus" class="h-4 w-4"></i>
                             </button>
                        </div>
                        
                        <div class="px-2 mb-2">
                             <input type="text" id="quListSearch" placeholder="Filter by Unique Name..." class="flex h-9 w-full rounded-md border border-input bg-background/50 px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50">
                        </div>

                        <div class="h-48 overflow-y-auto pr-2 custom-scrollbar">
                            <div id="quantityUnitsList" class="flex flex-col gap-2">
                                <!-- Quantity Units List -->
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
            <div class="grid gap-2 relative">
                <label class="text-sm font-medium leading-none" for="productGroup">Group</label>
                <input type="text" name="group" id="productGroup" placeholder="Select Group" autocomplete="off" class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                <div id="productGroupResults" class="absolute top-[70px] w-full rounded-md border bg-popover text-popover-foreground shadow-md outline-none animate-in fade-in-0 zoom-in-95 hidden z-50 max-h-60 overflow-y-auto bg-white border-border"></div>
            </div>
            <div class="grid gap-2 relative">
                <label class="text-sm font-medium leading-none" for="productUniqueNameDisplay">Unique Name (Optional)</label>
                <input type="text" id="productUniqueNameDisplay" placeholder="Search unique name..." autocomplete="off" class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                <input type="hidden" name="uniqueName" id="productUniqueName">
                <div id="productUniqueNameResults" class="absolute top-[70px] w-full rounded-md border bg-popover text-popover-foreground shadow-md outline-none animate-in fade-in-0 zoom-in-95 hidden z-50 max-h-60 overflow-y-auto bg-white border-border"></div>
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
            <div class="grid gap-2 relative">
                <label class="text-sm font-medium leading-none" for="productUnitDisplay">Quantity Unit</label>
                <input type="text" id="productUnitDisplay" placeholder="Select Unique Name first..." disabled autocomplete="off" class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                <input type="hidden" name="quantityUnit" id="productUnit">
                <div id="productUnitResults" class="absolute top-[70px] w-full rounded-md border bg-popover text-popover-foreground shadow-md outline-none animate-in fade-in-0 zoom-in-95 hidden z-50 max-h-60 overflow-y-auto bg-white border-border"></div>
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

<!-- Quantity Unit Modal -->
<?php
$quBoxContent = '
<form id="quantityUnitForm" class="grid gap-4">
    <input type="hidden" name="id" id="quId">
    
    <div class="grid gap-2">
        <label class="text-sm font-medium leading-none" for="quName">Name</label>
        <input type="text" name="name" id="quName" placeholder="e.g. Bag, kg" required class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
    </div>

    <div class="grid gap-2 relative">
        <label class="text-sm font-medium leading-none" for="quUniqueNameDisplay">Unique Name Category</label>
        <input type="text" id="quUniqueNameDisplay" placeholder="Search unique name..." class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
        <input type="hidden" name="uniqueName" id="quUniqueName">
        <div id="quUniqueNameResults" class="absolute top-[70px] w-full rounded-md border bg-popover text-popover-foreground shadow-md outline-none animate-in fade-in-0 zoom-in-95 hidden z-50 max-h-60 overflow-y-auto bg-white border-border"></div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="grid gap-2">
            <label class="text-sm font-medium leading-none" for="quSubUnit">Sub Unit (Optional)</label>
            <select name="subUnit" id="quSubUnit" class="flex h-10 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                <option value="">None</option>
            </select>
        </div>
        <div class="grid gap-2">
            <label class="text-sm font-medium leading-none" for="quSubUnitCount">Sub Unit Count</label>
            <input type="number" name="subUnitCount" id="quSubUnitCount" placeholder="e.g. 10" class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
        </div>
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-border/50">
        <button type="button" onclick="document.getElementById(\'qu-modal\').classList.add(\'hidden\')" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
            Cancel
        </button>
        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20">
            Save Unit
        </button>
    </div>
</form>
';
echo UI::dialog('qu-modal', 'Add Quantity Unit', $quBoxContent);
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
    let allQuantityUnits = [];
    let itemToDelete = null;
    let itemToEdit = null;

    // Elements
    const productsTableBody = document.getElementById('productsTableBody');
    const groupsList = document.getElementById('groupsList');
    const uniqueNamesList = document.getElementById('uniqueNamesList');
    const quantityUnitsList = document.getElementById('quantityUnitsList');
    const productModal = document.getElementById('product-modal');
    const productModalTitle = productModal.querySelector('h3');
    const editModal = document.getElementById('edit-modal');
    const editModalTitle = editModal.querySelector('h3');
    const quModal = document.getElementById('qu-modal');
    const quModalTitle = quModal.querySelector('h3');
    const deleteAlert = document.getElementById('delete-alert');
    const deleteAlertDesc = deleteAlert.querySelector('p');
    
    // Forms
    const productForm = document.getElementById('productForm');
    const groupForm = document.getElementById('groupForm');
    const uniqueNameForm = document.getElementById('uniqueNameForm');
    const quForm = document.getElementById('quantityUnitForm');
    
    // Inputs
    const searchInput = document.getElementById('searchInput');
    const editValueInput = document.getElementById('edit-value');
    const productGroupSelect = document.getElementById('productGroup');
    const productUniqueNameSelect = document.getElementById('productUniqueName');
    const productUnitSelect = document.getElementById('productUnit');
    const quUniqueNameSelect = document.getElementById('quUniqueName');
    const quSubUnitSelect = document.getElementById('quSubUnit');
    const quListContainer = document.getElementById('quantityUnitsList');
    const quListSearch = document.getElementById('quListSearch');

    // Buttons
    const addProductBtn = document.getElementById('addProductBtn');
    const saveEditBtn = document.getElementById('saveEditBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    // Fetch Data
    async function fetchData() {
        try {
            const [productsRes, groupsRes, uniqueNamesRes, quRes] = await Promise.all([
                ProductService.getAllProducts({ limit: 100 }),
                GroupService.getAllGroups(),
                UniqueNameService.getAllUniqueNames({ limit: 1000 }),
                QuantityUnitService.getAllQuantityUnits({ limit: 1000 })
            ]);
            
            console.log('UniqueNames Response:', uniqueNamesRes);

            const getData = (res) => Array.isArray(res) ? res : (res.data || []);

            allProducts = getData(productsRes);
            allGroups = getData(groupsRes);
            allUniqueNames = getData(uniqueNamesRes);
            allQuantityUnits = getData(quRes);

            renderProducts(allProducts);
            renderGroups(allGroups);
            renderUniqueNames(allUniqueNames);
            renderQuantityUnits(allQuantityUnits);
            updateSelects();
        } catch (error) {
            console.error('Fetch error:', error);
            showToast('Failed to fetch data', 'error');
        }
    }

    function updateSelects() {
        const getName = (item) => item.name || item;
        const getId = (item) => item.id || item._id || item;

        // Re-query elements to ensure they exist
        const productGroupSelect = document.getElementById('productGroup');
        const productUniqueNameSelect = document.getElementById('productUniqueName');
        const productUnitSelect = document.getElementById('productUnit');
        const quUniqueNameSelect = document.getElementById('quUniqueName');
        const quSubUnitSelect = document.getElementById('quSubUnit');

        // Removed Product Form Group Select population (Converted to Input Search)
        
        // Removed Product Unique Name & Unit Select population (Converted to Input Search)



        // Quantity Unit Modal Sub Units
        if (quSubUnitSelect) {
            quSubUnitSelect.innerHTML = '<option value="">None</option>' + 
                allQuantityUnits.map(u => `<option value="${getId(u)}">${getName(u)}</option>`).join('');
        }
    }

    function renderProducts(products) {
        if (products.length === 0) {
            productsTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-8 text-center text-muted-foreground">No products found.</td></tr>`;
            return;
        }

        const getUnitDisplay = (u) => {
            if (!u) return '';
            if (typeof u === 'object') return u.name || '';
            const match = allQuantityUnits.find(qu => (qu.id || qu._id) === u);
            return match ? match.name : '';
        };

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
                <td class="px-6 py-4 text-muted-foreground">${product.quantityAvailable} ${getUnitDisplay(product.quantityUnit)}</td>
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
        
        // Unique Name Setup
        const pUniqueName = document.getElementById('productUniqueName');
        const pUniqueNameDisplay = document.getElementById('productUniqueNameDisplay');
        const uVal = product.uniqueName || '';
        pUniqueName.value = uVal;
        
        // Resolve Unique Name Display
        let uNameDisplay = '';
        if (uVal) {
             const uMatch = allUniqueNames.find(u => (u.id || u._id) === uVal);
             if (uMatch) uNameDisplay = uMatch.name;
             else uNameDisplay = uVal; // Fallback
        }
        pUniqueNameDisplay.value = uNameDisplay;
        
        // Unit Setup
        const pUnit = document.getElementById('productUnit');
        const pUnitDisplay = document.getElementById('productUnitDisplay');
        
        if (uVal) {
            pUnitDisplay.disabled = false;
            pUnitDisplay.placeholder = "Search unit...";
        } else {
            pUnitDisplay.disabled = true;
            pUnitDisplay.placeholder = "Select Unique Name first...";
        }
        
        const unitVal = product.quantityUnit ? (typeof product.quantityUnit === 'object' ? (product.quantityUnit.id || product.quantityUnit._id) : product.quantityUnit) : '';
        pUnit.value = unitVal;
        
        // Resolve Unit Display
        let unitNameDisplay = '';
        if (product.quantityUnit && typeof product.quantityUnit === 'object') {
             unitNameDisplay = product.quantityUnit.name;
        } else if (unitVal) {
             const uMatch = allQuantityUnits.find(u => (u.id || u._id) === unitVal);
             if (uMatch) unitNameDisplay = uMatch.name;
        }
        pUnitDisplay.value = unitNameDisplay;

        document.getElementById('productPrice').value = product.sellingPrice;
        document.getElementById('productCost').value = product.costPrice || 0;
        document.getElementById('productQuantity').value = product.quantityAvailable;
        document.getElementById('productImage').value = product.imageUrl || '';
        
        productModalTitle.textContent = 'Edit Product';
        productModal.classList.remove('hidden');
    };

    // Obsolete Cascading - handled by new logic below

    


    function renderQuantityUnits(units) {
        if (!quListContainer) return;
        
        if (!units || units.length === 0) {
            quListContainer.innerHTML = `<div class="p-4 text-center text-sm text-muted-foreground">No units found</div>`;
            return;
        }

        const getName = (item) => item.name || item;
        const getId = (item) => item.id || item._id || item;

        quListContainer.innerHTML = units.map(unit => {
            // Resolve Unique Name Display
            let uniqNameDisplay = 'Unknown';
            if (typeof unit.uniqueName === 'object' && unit.uniqueName) {
                uniqNameDisplay = unit.uniqueName.name;
            } else {
                const match = allUniqueNames.find(un => getId(un) === unit.uniqueName);
                if (match) uniqNameDisplay = getName(match);
            }

            // Resolve Sub Unit Name
            let subUnitName = 'SubUnit';
            if (unit.subUnit) {
                if (typeof unit.subUnit === 'object' && unit.subUnit.name) {
                    subUnitName = unit.subUnit.name;
                } else {
                    const match = allQuantityUnits.find(u => getId(u) === unit.subUnit);
                    if (match) subUnitName = getName(match);
                }
            }

            return `
            <div class="flex items-center justify-between p-3 rounded-lg border border-border/50 bg-background/50 hover:bg-muted/50 transition-colors group">
                <div>
                   <div class="font-medium text-sm flex items-center gap-2">
                        ${unit.name}
                        <span class="text-xs px-1.5 py-0.5 rounded-full bg-primary/10 text-primary">${uniqNameDisplay}</span>
                   </div>
                   ${unit.subUnit ? `<div class="text-xs text-muted-foreground mt-1">Sub: ${unit.subUnitCount || 0} x ${subUnitName}</div>` : ''}
                </div>
                <div class="relative group/dropdown">
                    <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-6 w-6 opacity-0 group-hover:opacity-100 transition-opacity">
                        <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                    </button>
                    <div class="absolute right-0 top-6 w-32 rounded-lg border bg-popover p-1 text-popover-foreground shadow-lg hidden group-hover/dropdown:block z-10 bg-white animate-in fade-in zoom-in-95 duration-200">
                         <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openEditQU('${getId(unit)}')">
                            <i data-lucide="edit" class="mr-2 h-3.5 w-3.5 text-muted-foreground"></i> Edit
                        </div>
                        <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 hover:text-red-600 text-red-600" onclick="openDeleteAlert('quantityUnit', '${getId(unit)}', '${unit.name}')">
                            <i data-lucide="trash-2" class="mr-2 h-3.5 w-3.5"></i> Delete
                        </div>
                    </div>
                </div>
            </div>
            `;
        }).join('');
        
        if (window.lucide) lucide.createIcons();
    }

    if (quListSearch) {
        quListSearch.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            const filtered = allQuantityUnits.filter(unit => {
                const uName = (unit.name || '').toLowerCase();
                
                let uniqNameVal = '';
                if (typeof unit.uniqueName === 'object' && unit.uniqueName) {
                    uniqNameVal = unit.uniqueName.name;
                } else {
                     const match = allUniqueNames.find(un => (un.id || un._id || un) === unit.uniqueName);
                     uniqNameVal = match ? (match.name || match) : '';
                }
                uniqNameVal = (uniqNameVal || '').toLowerCase();
                
                return uName.includes(term) || uniqNameVal.includes(term);
            });
            renderQuantityUnits(filtered);
        });
    }

    window.openQuantityUnitModal = async () => {
        quForm.reset();
        document.getElementById('quId').value = '';
        quModalTitle.textContent = 'Add Quantity Unit';
        
        // Refresh Unique Names specifically
        try {
            const res = await UniqueNameService.getAllUniqueNames({ limit: 1000 });
            const getData = (res) => Array.isArray(res) ? res : (res.data || []);
            allUniqueNames = getData(res);
            updateSelects();
        } catch (e) {
            console.error(e);
        }

        quModal.classList.remove('hidden');
    };

    window.openEditQU = (id) => {
        const unit = allQuantityUnits.find(u => u.id === id);
        if (!unit) return;
        
        document.getElementById('quId').value = unit.id;
        document.getElementById('quName').value = unit.name;
        document.getElementById('quUniqueName').value = unit.uniqueName ? (typeof unit.uniqueName === 'object' ? unit.uniqueName.id : unit.uniqueName) : '';
        document.getElementById('quSubUnit').value = unit.subUnit ? (typeof unit.subUnit === 'object' ? unit.subUnit.id : unit.subUnit) : '';
        document.getElementById('quSubUnitCount').value = unit.subUnitCount || '';
        
        quModalTitle.textContent = 'Edit Quantity Unit';
        quModal.classList.remove('hidden');
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
            : (type === 'quantityUnit' 
                ? `This action cannot be undone. This will permanently delete the unit "${value}".`
                : `This action cannot be undone. This will permanently delete the ${type} "${value}" and all products associated with it.`);
        deleteAlert.classList.remove('hidden');
    };

    // Search Logic for Quantity Unit Modal
    const quUniqueNameDisplay = document.getElementById('quUniqueNameDisplay');
    const quUniqueNameResults = document.getElementById('quUniqueNameResults');
    const quUniqueID = document.getElementById('quUniqueName');

    if (quUniqueNameDisplay) {
        quUniqueNameDisplay.addEventListener('input', async (e) => {
            const term = e.target.value;
            if (term.length < 1) { 
                quUniqueNameResults.classList.add('hidden'); 
                return; 
            }
            
            try {
                const res = await UniqueNameService.getAllUniqueNames({ search: term });
                const getData = (res) => Array.isArray(res) ? res : (res.data || []);
                const names = getData(res);
                
                if (names.length === 0) {
                    quUniqueNameResults.innerHTML = '<div class="p-2 text-sm text-muted-foreground">No matches found</div>';
                } else {
                    const getName = (item) => item.name || item;
                    const getId = (item) => item.id || item._id || item;
                    
                    quUniqueNameResults.innerHTML = names.map(n => `
                        <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none hover:bg-accent hover:text-accent-foreground cursor-pointer" 
                             onclick="selectUniqueName('${getId(n)}', '${getName(n)}')">
                            ${getName(n)}
                        </div>
                    `).join('');
                }
                quUniqueNameResults.classList.remove('hidden');
            } catch (err) { console.error(err); }
        });

        // Hide results when clicking outside
        document.addEventListener('click', (e) => {
            if (!quUniqueNameDisplay.contains(e.target) && !quUniqueNameResults.contains(e.target)) {
                quUniqueNameResults.classList.add('hidden');
            }
        });
    }

    window.selectUniqueName = async (id, name) => {
        quUniqueID.value = id;
        quUniqueNameDisplay.value = name;
        quUniqueNameResults.classList.add('hidden');
        
        // Fetch Quantity Units for SubUnit
        try {
            const res = await QuantityUnitService.getAllQuantityUnits({ uniqueName: id });
            const getData = (res) => Array.isArray(res) ? res : (res.data || []);
            const units = getData(res);
            
            const quSubUnitSelect = document.getElementById('quSubUnit');
            const getName = (item) => item.name || item;
            const getId = (item) => item.id || item._id || item;

            if (quSubUnitSelect) {
                quSubUnitSelect.innerHTML = '<option value="">None</option>' + 
                    units.map(u => `<option value="${getId(u)}">${getName(u)}</option>`).join('');
            }
        } catch (e) {
            console.error(e);
        }
    };

    // Event Listeners
    addProductBtn.addEventListener('click', () => {
        productForm.reset();
        document.getElementById('productId').value = '';
        
        // Reset Inputs
        document.getElementById('productUniqueName').value = '';
        document.getElementById('productUniqueNameDisplay').value = '';
        document.getElementById('productUnit').value = '';
        const pUnitDisplay = document.getElementById('productUnitDisplay');
        pUnitDisplay.value = '';
        pUnitDisplay.disabled = true;
        pUnitDisplay.placeholder = "Select Unique Name first...";

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
            } else if (itemToDelete.type === 'quantityUnit') {
                await QuantityUnitService.deleteQuantityUnit(itemToDelete.id);
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

    quForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(quForm);
        const data = Object.fromEntries(formData.entries());
        const id = data.id;
        delete data.id;
        
        // Validation/Conversion
        if (data.subUnitCount) data.subUnitCount = parseInt(data.subUnitCount);
        if (!data.subUnit) delete data.subUnit; // Remove empty subUnit if None selected
        if (!data.subUnitCount) delete data.subUnitCount;

        try {
            if (id) {
                await QuantityUnitService.updateQuantityUnit(id, data);
                showToast('Unit updated successfully', 'success');
            } else {
                await QuantityUnitService.createQuantityUnit(data);
                showToast('Unit created successfully', 'success');
            }
            quModal.classList.add('hidden');
            fetchData();
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    searchInput.addEventListener('input', (e) => {
        const term = e.target.value.toLowerCase();
        const filtered = allProducts.filter(p => {
            const pName = (p.name || '').toLowerCase();
            const pGroup = (p.group || '').toLowerCase();
            
            // Resolve Unique Name
            let uName = p.uniqueName || '';
            const uMatch = allUniqueNames.find(u => (u.id || u._id) === uName);
            if (uMatch) uName = uMatch.name;
            uName = (uName || '').toLowerCase();

            // Resolve Unit
            let unitName = '';
            if (p.quantityUnit) {
                 if (typeof p.quantityUnit === 'object') unitName = p.quantityUnit.name;
                 else {
                      const qMatch = allQuantityUnits.find(q => (q.id || q._id) === p.quantityUnit);
                      if (qMatch) unitName = qMatch.name;
                 }
            }
            unitName = (unitName || '').toLowerCase();

            return pName.includes(term) || pGroup.includes(term) || uName.includes(term) || unitName.includes(term);
        });
        renderProducts(filtered);
    });

    // Product Form Search Logic
    const pUniqueNameDisplay = document.getElementById('productUniqueNameDisplay');
    const pUniqueNameResults = document.getElementById('productUniqueNameResults');
    const pUniqueNameHidden = document.getElementById('productUniqueName');
    
    const pUnitDisplay = document.getElementById('productUnitDisplay');
    const pUnitResults = document.getElementById('productUnitResults');
    const pUnitHidden = document.getElementById('productUnit');

    // Unique Name Search
    if (pUniqueNameDisplay) {
        pUniqueNameDisplay.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            pUniqueNameHidden.value = ''; // Clear ID on input
            
            // Disable Unit
            pUnitDisplay.disabled = true;
            pUnitDisplay.value = '';
            pUnitHidden.value = '';
            pUnitDisplay.placeholder = "Select Unique Name first...";
            
            if (term.length < 1) { 
                pUniqueNameResults.classList.add('hidden'); 
                return; 
            }

            const matches = allUniqueNames.filter(u => (u.name || '').toLowerCase().includes(term));
            
            if (matches.length === 0) {
                 pUniqueNameResults.innerHTML = '<div class="p-2 text-sm text-muted-foreground">No matches found</div>';
            } else {
                 const getName = (item) => item.name || item;
                 const getId = (item) => item.id || item._id || item;
                 pUniqueNameResults.innerHTML = matches.map(m => `
                    <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none hover:bg-accent hover:text-accent-foreground cursor-pointer" 
                         onclick="selectProductUniqueName('${getId(m)}', '${getName(m)}')">
                        ${getName(m)}
                    </div>
                `).join('');
            }
            pUniqueNameResults.classList.remove('hidden');
        });

        document.addEventListener('click', (e) => {
             if (!pUniqueNameDisplay.contains(e.target) && !pUniqueNameResults.contains(e.target)) {
                 pUniqueNameResults.classList.add('hidden');
             }
        });
    }

    window.selectProductUniqueName = (id, name) => {
        pUniqueNameHidden.value = id;
        pUniqueNameDisplay.value = name;
        pUniqueNameResults.classList.add('hidden');
        
        // Enable Unit
        pUnitDisplay.disabled = false;
        pUnitDisplay.placeholder = "Search unit...";
        pUnitDisplay.value = ''; // Clear unit
        pUnitHidden.value = '';
    };

    // Unit Search
    if (pUnitDisplay) {
        pUnitDisplay.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            pUnitHidden.value = '';

            const uniqueNameId = pUniqueNameHidden.value;
            if (!uniqueNameId) return; // Should be disabled, but safe check

            if (term.length < 1) { 
                pUnitResults.classList.add('hidden'); 
                return; 
            }

            const getId = (item) => item.id || item._id || item;
            
            // Filter by Unique Name ID AND Term
            const matches = allQuantityUnits.filter(u => {
                const uUni = u.uniqueName;
                const uUniId = (typeof uUni === 'object' && uUni) ? getId(uUni) : uUni;
                
                const matchesUniqueName = uUniId === uniqueNameId;
                const matchesTerm = (u.name || '').toLowerCase().includes(term);
                
                return matchesUniqueName && matchesTerm;
            });
            
            if (matches.length === 0) {
                 pUnitResults.innerHTML = '<div class="p-2 text-sm text-muted-foreground">No matches found used selected unique name</div>';
            } else {
                 const getName = (item) => item.name || item;
                 pUnitResults.innerHTML = matches.map(m => `
                    <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none hover:bg-accent hover:text-accent-foreground cursor-pointer" 
                         onclick="selectProductUnit('${getId(m)}', '${getName(m)}')">
                        ${getName(m)}
                    </div>
                `).join('');
            }
            pUnitResults.classList.remove('hidden');
        });

        document.addEventListener('click', (e) => {
             if (!pUnitDisplay.contains(e.target) && !pUnitResults.contains(e.target)) {
                 pUnitResults.classList.add('hidden');
             }
        });
    }

    window.selectProductUnit = (id, name) => {
        pUnitHidden.value = id;
        pUnitDisplay.value = name;
        pUnitResults.classList.add('hidden');
    };

    // Group Search Logic
    const pGroupInput = document.getElementById('productGroup');
    const pGroupResults = document.getElementById('productGroupResults');

    if (pGroupInput) {
        pGroupInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            if (term.length < 1) { 
                pGroupResults.classList.add('hidden'); 
                return; 
            }

            const matches = allGroups.filter(g => (g.name || '').toLowerCase().includes(term));
            
            if (matches.length === 0) {
                 pGroupResults.innerHTML = `<div class="p-2 text-sm text-muted-foreground">No groups found</div>`;
            } else {
                 pGroupResults.innerHTML = matches.map(g => `
                    <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none hover:bg-accent hover:text-accent-foreground cursor-pointer" 
                         onclick="selectProductGroup('${g.name}')">
                        ${g.name}
                    </div>
                `).join('');
            }
            pGroupResults.classList.remove('hidden');
        });

        // Show all groups on focus if empty? Optional.
        // For now just search.

        document.addEventListener('click', (e) => {
             if (!pGroupInput.contains(e.target) && !pGroupResults.contains(e.target)) {
                 pGroupResults.classList.add('hidden');
             }
        });
    }

    window.selectProductGroup = (name) => {
        pGroupInput.value = name;
        pGroupResults.classList.add('hidden');
    };

    // Initial Load
    fetchData();

</script>
</body>
</html>
