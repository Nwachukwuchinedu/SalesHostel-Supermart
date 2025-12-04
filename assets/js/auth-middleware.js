// Middleware for Authentication and Role-Based Access Control

const protectedRoutes = [
    '/dashboard/',
    '/dashboard/products',
    '/dashboard/purchases',
    '/dashboard/supplies',
    '/dashboard/reports',
    '/user/',
    '/user/orders',
    '/user/shop',
    '/user/cart'
];

const rolePermissions = {
    'Admin': ['/dashboard/', '/dashboard/products', '/dashboard/purchases', '/dashboard/supplies', '/dashboard/reports'],
    'Staff': ['/dashboard/', '/dashboard/products', '/dashboard/purchases', '/dashboard/reports'],
    'Supplier': ['/dashboard/', '/dashboard/supplies'],
    'Customer': ['/user/', '/user/orders', '/user/shop', '/user/cart']
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
            // If user has no dashboard access at all (e.g. Customer trying to access Admin dashboard), redirect to their home
            if (userRole === 'Customer') {
                window.location.href = '/user/';
                return;
            }

            if (allowedRoutes.length === 0) {
                window.location.href = '/';
                return;
            }

            // Redirect to custom 403 page
            window.location.href = '/403';
        }
    } else {
        // If on login/signup page and already logged in
        if ((currentPath.includes('/login') || currentPath.includes('/signup')) && accessToken) {
            if (user && user.role === 'Customer') {
                window.location.href = '/user/';
            } else {
                window.location.href = '/dashboard/';
            }
        }
    }

    // Hide unauthorized sidebar links (Run this regardless of whether the route is protected, as long as the user is logged in)
    if (accessToken && user) {
        const userRole = user.role;
        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => {
            const roles = JSON.parse(link.getAttribute('data-roles') || '[]');
            if (roles.length > 0 && !roles.includes(userRole)) {
                link.style.display = 'none';
            }
        });
    }
}

// Run check immediately
checkAuth();
