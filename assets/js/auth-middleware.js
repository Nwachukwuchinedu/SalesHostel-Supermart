// Middleware for Authentication and Role-Based Access Control

const protectedRoutes = [
    '/dashboard/',
    '/dashboard/products',
    '/dashboard/purchases',
    '/dashboard/supplies',
    '/dashboard/reports'
];

const rolePermissions = {
    'Admin': ['*'],
    'Staff': ['/dashboard/', '/dashboard/products', '/dashboard/purchases', '/dashboard/reports'],
    'Supplier': ['/dashboard/', '/dashboard/supplies']
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
            window.location.href = '/login';
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
            // If user has no dashboard access at all (e.g. Customer), redirect to home
            if (allowedRoutes.length === 0) {
                window.location.href = '/';
                return;
            }

            alert('You do not have permission to access this page.');
            window.location.href = '/dashboard/'; // Redirect to a safe page
        }
    } else {
        // If on login/signup page and already logged in, redirect to dashboard
        if ((currentPath.includes('/login') || currentPath.includes('/signup')) && accessToken) {
            window.location.href = '/dashboard/';
        }
    }
}

// Run check immediately
checkAuth();
