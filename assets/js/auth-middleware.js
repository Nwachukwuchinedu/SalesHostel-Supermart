// Middleware for Authentication and Role-Based Access Control

const protectedRoutes = [
    '/dashboard/index.php',
    '/dashboard/products.php',
    '/dashboard/purchases.php',
    '/dashboard/supplies.php',
    '/dashboard/reports.php'
];

const rolePermissions = {
    'Admin': ['*'],
    'Staff': ['/dashboard/index.php', '/dashboard/products.php', '/dashboard/purchases.php', '/dashboard/reports.php'],
    'Supplier': ['/dashboard/index.php', '/dashboard/supplies.php'],
    'Customer': ['/dashboard/index.php', '/dashboard/purchases.php']
};

function checkAuth() {
    const accessToken = localStorage.getItem('accessToken');
    const user = JSON.parse(localStorage.getItem('user') || 'null');
    const currentPath = window.location.pathname;

    // Check if current page is protected
    const isProtected = protectedRoutes.some(route => currentPath.includes(route));

    if (isProtected) {
        if (!accessToken || !user) {
            // Not authenticated, redirect to login
            window.location.href = '/login.php';
            return;
        }

        // Check Role Permissions
        const userRole = user.role;
        const allowedRoutes = rolePermissions[userRole] || [];

        // Admin has access to everything
        if (allowedRoutes.includes('*')) return;

        // Check specific route access
        const hasAccess = allowedRoutes.some(route => currentPath.includes(route));

        if (!hasAccess) {
            alert('You do not have permission to access this page.');
            window.location.href = '/dashboard/index.php'; // Redirect to a safe page
        }
    } else {
        // If on login/signup page and already logged in, redirect to dashboard
        if ((currentPath.includes('/login.php') || currentPath.includes('/signup.php')) && accessToken) {
            window.location.href = '/dashboard/index.php';
        }
    }
}

// Run check immediately
checkAuth();
