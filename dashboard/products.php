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
                            Products
                        </h1>
                        <p class="text-muted-foreground">Manage your product inventory.</p>
                    </div>
                    <?php echo UI::button('Add Product', ['icon' => 'plus-circle', 'id' => 'addProductBtn']); ?>
                </div>

                <?php
                $searchContent = '
                <div class="relative mt-4">
                    <i data-lucide="search" class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"></i>
                    ' . UI::input(['type' => 'search', 'placeholder' => 'Search by name, group, or tag...', 'class' => 'pl-8', 'id' => 'searchInput']) . '
                </div>';

                echo UI::card(
                    UI::table([
                        ['text' => 'Image', 'class' => 'w-[80px]'],
                        ['text' => 'Name'],
                        ['text' => 'Group'],
                        ['text' => 'Stock'],
                        ['text' => 'Price', 'class' => 'text-right'],
                        ['text' => 'Actions']
                    ], 'productsTableBody'),
                    ['title' => 'Product List', 'description' => 'A list of all products in your store.', 'content' => $searchContent]
                );
                ?>

                <div class="grid md:grid-cols-2 gap-8">
                    <?php
                    // Unique Names Card
                    $uniqueNameForm = '
                    <form id="uniqueNameForm" class="flex gap-2 mb-4">
                        ' . UI::input(['placeholder' => 'Add new unique name', 'id' => 'newUniqueName']) . '
                        ' . UI::button('Add', ['type' => 'submit']) . '
                    </form>
                    <div class="h-40 overflow-auto">
                        <div id="uniqueNamesList" class="flex flex-col gap-2">
                            <!-- Unique Names List -->
                        </div>
                    </div>';
                    
                    echo UI::card($uniqueNameForm, ['title' => '<div class="flex items-center gap-2"><i data-lucide="text" class="h-5 w-5"></i> Unique Names</div>', 'description' => 'Manage the unique names for product selection.']);

                    // Groups Card
                    $groupForm = '
                    <form id="groupForm" class="flex gap-2 mb-4">
                        ' . UI::input(['placeholder' => 'Add new group', 'id' => 'newGroup']) . '
                        ' . UI::button('Add', ['type' => 'submit']) . '
                    </form>
                    <div class="h-40 overflow-auto">
                        <div id="groupsList" class="flex flex-col gap-2">
                            <!-- Groups List -->
                        </div>
                    </div>';

                    echo UI::card($groupForm, ['title' => '<div class="flex items-center gap-2"><i data-lucide="tags" class="h-5 w-5"></i> Groups</div>', 'description' => 'Manage the groups for product categorization.']);
                    ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Product Modal -->
<?php
$productFormContent = '
<form id="productForm" class="grid gap-4">
    <input type="hidden" name="id" id="productId">
    <div class="grid gap-2">
        ' . UI::label('Name') . '
        ' . UI::input(['name' => 'name', 'id' => 'productName', 'placeholder' => 'Product Name', 'required' => true]) . '
    </div>
    <div class="grid gap-2">
        ' . UI::label('Group') . '
        <select name="group" id="productGroup" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
            <option value="">Select Group</option>
        </select>
    </div>
    <div class="grid gap-2">
        ' . UI::label('Unique Name (Optional)') . '
        <select name="uniqueName" id="productUniqueName" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
            <option value="">Select Unique Name</option>
        </select>
    </div>
    <div class="grid gap-2">
        ' . UI::label('Selling Price') . '
        ' . UI::input(['name' => 'sellingPrice', 'id' => 'productPrice', 'type' => 'number', 'step' => '0.01', 'placeholder' => '0.00', 'required' => true]) . '
    </div>
     <div class="grid gap-2">
        ' . UI::label('Cost Price') . '
        ' . UI::input(['name' => 'costPrice', 'id' => 'productCost', 'type' => 'number', 'step' => '0.01', 'placeholder' => '0.00', 'required' => true]) . '
    </div>
    <div class="grid gap-2">
        ' . UI::label('Quantity Available') . '
        ' . UI::input(['name' => 'quantityAvailable', 'id' => 'productQuantity', 'type' => 'number', 'placeholder' => '0', 'required' => true]) . '
    </div>
     <div class="grid gap-2">
        ' . UI::label('Quantity Unit') . '
        ' . UI::input(['name' => 'quantityUnit', 'id' => 'productUnit', 'placeholder' => 'e.g., kg, pcs', 'required' => true]) . '
    </div>
    <div class="grid gap-2">
        ' . UI::label('Image URL') . '
        ' . UI::input(['name' => 'imageUrl', 'id' => 'productImage', 'placeholder' => 'https://...']) . '
    </div>
    <div class="flex justify-end gap-2 mt-4">
        ' . UI::button('Cancel', ['variant' => 'outline', 'type' => 'button', 'attrs' => 'onclick="document.getElementById(\'product-modal\').classList.add(\'hidden\')"']) . '
        ' . UI::button('Save Product', ['type' => 'submit']) . '
    </div>
</form>
';

echo UI::dialog('product-modal', 'Add New Product', $productFormContent);
?>

<!-- Edit Group/UniqueName Modal -->
<?php
$editFormContent = '
<div class="grid gap-4 py-4">
    <div class="grid grid-cols-4 items-center gap-4">
        ' . UI::label('Name', 'edit-value', 'text-right') . '
        ' . UI::input(['id' => 'edit-value', 'class' => 'col-span-3']) . '
    </div>
</div>
<div class="flex justify-end gap-2">
    ' . UI::button('Cancel', ['variant' => 'outline', 'type' => 'button', 'attrs' => 'onclick="document.getElementById(\'edit-modal\').classList.add(\'hidden\')"']) . '
    ' . UI::button('Save Changes', ['id' => 'saveEditBtn']) . '
</div>
';
echo UI::dialog('edit-modal', 'Edit Item', $editFormContent);
?>

<!-- Delete Alert Dialog -->
<?php
echo UI::alertDialog('delete-alert', 'Are you absolutely sure?', 'This action cannot be undone.', 'confirmDeleteBtn');
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
            productsTableBody.innerHTML = `<tr><td colspan="6" class="p-4 text-center text-muted-foreground">No products found.</td></tr>`;
            return;
        }

        productsTableBody.innerHTML = products.map(product => `
            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                    <span class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full">
                        <img class="aspect-square h-full w-full object-cover" src="${product.imageUrl || 'https://via.placeholder.com/40'}" alt="${product.name}" />
                    </span>
                </td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0 font-medium">${product.name}</td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">${product.group}</td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">${product.quantityAvailable} ${product.quantityUnit}</td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0 text-right">₦${parseFloat(product.sellingPrice).toFixed(2)}</td>
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                    <div class="flex justify-end relative group/dropdown">
                        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 w-8">
                            <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                        </button>
                        <div class="absolute right-0 top-8 w-32 rounded-md border bg-popover p-1 text-popover-foreground shadow-md hidden group-hover/dropdown:block z-10 bg-white">
                            <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50" onclick="openEditProduct('${product.id}')">
                                Edit
                            </div>
                            <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 text-red-600" onclick="openDeleteAlert('product', '${product.id}', '${product.name}')">
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
            <div class="flex items-center justify-between p-2 rounded-md border group">
                <span>${group.name}</span>
                <div class="relative group/dropdown">
                    <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-6 w-6 opacity-0 group-hover:opacity-100">
                        <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                    </button>
                    <div class="absolute right-0 top-6 w-32 rounded-md border bg-popover p-1 text-popover-foreground shadow-md hidden group-hover/dropdown:block z-10 bg-white">
                         <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openEditItem('group', '${group.id}', '${group.name}')">
                            <i data-lucide="edit" class="mr-2 h-4 w-4"></i> Edit
                        </div>
                        <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground text-red-600" onclick="openDeleteAlert('group', '${group.id}', '${group.name}')">
                            <i data-lucide="trash-2" class="mr-2 h-4 w-4"></i> Delete
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        lucide.createIcons();
    }

    function renderUniqueNames(names) {
        uniqueNamesList.innerHTML = names.map(name => `
            <div class="flex items-center justify-between p-2 rounded-md border group">
                <span>${name.name}</span>
                <div class="relative group/dropdown">
                    <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-6 w-6 opacity-0 group-hover:opacity-100">
                        <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                    </button>
                    <div class="absolute right-0 top-6 w-32 rounded-md border bg-popover p-1 text-popover-foreground shadow-md hidden group-hover/dropdown:block z-10 bg-white">
                         <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openEditItem('uniqueName', '${name.id}', '${name.name}')">
                            <i data-lucide="edit" class="mr-2 h-4 w-4"></i> Edit
                        </div>
                        <div class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground text-red-600" onclick="openDeleteAlert('uniqueName', '${name.id}', '${name.name}')">
                            <i data-lucide="trash-2" class="mr-2 h-4 w-4"></i> Delete
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
