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
                            Users
                        </h1>
                        <p class="text-muted-foreground">Manage system users and their roles.</p>
                    </div>
                </div>

                <div class="glass-card rounded-xl p-6 space-y-6">
                    <!-- Filters -->
                    <div class="grid md:grid-cols-2 gap-4 items-end">
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-3 h-4 w-4 text-muted-foreground"></i>
                            <input type="search" id="searchInput" placeholder="Search by name or email..." class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 pl-9 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                        </div>
                        <div class="grid gap-2">
                            <label for="roleFilter" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Role</label>
                            <select id="roleFilter" class="flex h-10 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                                <option value="">All Roles</option>
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                                <option value="Supplier">Supplier</option>
                                <option value="Customer">Customer</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="rounded-lg border border-border/50 overflow-hidden">
                        <div class="relative w-full overflow-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-muted-foreground uppercase bg-muted/30">
                                    <tr>
                                        <th class="px-6 py-3 font-medium">Name</th>
                                        <th class="px-6 py-3 font-medium">Email</th>
                                        <th class="px-6 py-3 font-medium">Role</th>
                                        <th class="px-6 py-3 font-medium text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="usersTableBody" class="divide-y divide-border/50 bg-card/50">
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-muted-foreground">
                                            <div class="flex flex-col items-center gap-2">
                                                <i data-lucide="loader-2" class="h-6 w-6 animate-spin text-primary"></i>
                                                <span>Loading users...</span>
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

<!-- Edit User Modal -->
<?php
$editUserFormContent = '
<form id="editUserForm" class="grid gap-6">
    <input type="hidden" name="id" id="userId">
    <div class="space-y-4">
        <div class="grid gap-2">
            <label class="text-sm font-medium leading-none" for="userName">Name</label>
            <input type="text" name="name" id="userName" placeholder="User Name" required class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
        </div>
        <div class="grid gap-2">
            <label class="text-sm font-medium leading-none" for="userEmail">Email</label>
            <input type="email" name="email" id="userEmail" placeholder="User Email" required class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
        </div>
        <div class="grid gap-2">
            <label class="text-sm font-medium leading-none" for="userRole">Role</label>
            <select name="role" id="userRole" class="flex h-10 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                <option value="Admin">Admin</option>
                <option value="Staff">Staff</option>
                <option value="Supplier">Supplier</option>
                <option value="Customer">Customer</option>
            </select>
        </div>
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-border/50">
        <button type="button" onclick="document.getElementById(\'edit-user-modal\').classList.add(\'hidden\')" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
            Cancel
        </button>
        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20">
            Save Changes
        </button>
    </div>
</form>
';

echo UI::dialog('edit-user-modal', 'Edit User', $editUserFormContent);
?>

<!-- Delete Alert Dialog -->
<?php
echo UI::alertDialog('delete-alert', 'Are you absolutely sure?', 'This action cannot be undone. This will permanently delete this user account.', 'confirmDeleteBtn');
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
    let allUsers = [];
    let userToDelete = null;

    // Elements
    const usersTableBody = document.getElementById('usersTableBody');
    const editUserModal = document.getElementById('edit-user-modal');
    const deleteAlert = document.getElementById('delete-alert');
    
    // Forms
    const editUserForm = document.getElementById('editUserForm');
    
    // Inputs
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const userIdInput = document.getElementById('userId');
    const userNameInput = document.getElementById('userName');
    const userEmailInput = document.getElementById('userEmail');
    const userRoleSelect = document.getElementById('userRole');

    // Buttons
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    // Fetch Data
    async function fetchData() {
        try {
            const res = await UserService.getAllUsers();
            allUsers = res.data.map(u => ({...u, id: u._id || u.id}));
            renderUsers(allUsers);
        } catch (error) {
            showToast('Failed to fetch users', 'error');
        }
    }

    function renderUsers(users) {
        if (users.length === 0) {
            usersTableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-8 text-center text-muted-foreground">No users found.</td></tr>`;
            return;
        }

        usersTableBody.innerHTML = users.map(user => {
            const roleColor = user.role === 'Admin' 
                ? 'bg-purple-500/10 text-purple-700 border-purple-200' 
                : user.role === 'Staff' 
                ? 'bg-blue-500/10 text-blue-700 border-blue-200'
                : user.role === 'Supplier'
                ? 'bg-orange-500/10 text-orange-700 border-orange-200'
                : 'bg-green-500/10 text-green-700 border-green-200';

            return `
            <tr class="hover:bg-muted/30 transition-colors">
                <td class="px-6 py-4 font-medium">
                    <div class="flex items-center gap-2">
                        <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                            ${(user.name || 'U').charAt(0).toUpperCase()}
                        </div>
                        ${user.name}
                    </div>
                </td>
                <td class="px-6 py-4 text-muted-foreground">${user.email}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors ${roleColor}">
                        ${user.role}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end relative group/dropdown">
                        <button class="inline-flex items-center justify-center rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 w-8">
                            <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                        </button>
                        <div class="absolute right-0 top-8 w-32 rounded-lg border bg-popover p-1 text-popover-foreground shadow-lg hidden group-hover/dropdown:block z-10 bg-white animate-in fade-in zoom-in-95 duration-200">
                            <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground" onclick="openEditUser('${user.id}')">
                                <i data-lucide="edit" class="mr-2 h-3.5 w-3.5 text-muted-foreground"></i>
                                Edit
                            </div>
                            <div class="relative flex cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 hover:text-red-600 text-red-600" onclick="openDeleteAlert('${user.id}')">
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

    // Actions
    window.openEditUser = (id) => {
        const user = allUsers.find(u => u.id === id);
        if (!user) return;
        
        userIdInput.value = user.id;
        userNameInput.value = user.name;
        userEmailInput.value = user.email;
        userRoleSelect.value = user.role;
        
        editUserModal.classList.remove('hidden');
    };

    window.openDeleteAlert = (id) => {
        userToDelete = id;
        deleteAlert.classList.remove('hidden');
    };

    // Event Listeners
    editUserForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = userIdInput.value;
        const name = userNameInput.value;
        const email = userEmailInput.value;
        const role = userRoleSelect.value;
        
        try {
            await UserService.updateUser(id, { name, email, role });
            showToast('User updated successfully', 'success');
            editUserModal.classList.add('hidden');
            fetchData();
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    confirmDeleteBtn.addEventListener('click', async () => {
        if (!userToDelete) return;
        try {
            await UserService.deleteUser(userToDelete);
            showToast('User deleted successfully', 'success');
            deleteAlert.classList.add('hidden');
            fetchData();
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    // Filtering
    function filterUsers() {
        const term = searchInput.value.toLowerCase();
        const role = roleFilter.value;

        const filtered = allUsers.filter(u => {
            const matchesTerm = (u.name && u.name.toLowerCase().includes(term)) || 
                              (u.email && u.email.toLowerCase().includes(term));
            const matchesRole = !role || u.role === role;
            
            return matchesTerm && matchesRole;
        });
        renderUsers(filtered);
    }

    searchInput.addEventListener('input', filterUsers);
    roleFilter.addEventListener('change', filterUsers);

    // Initial Load
    fetchData();

</script>
</body>
</html>
