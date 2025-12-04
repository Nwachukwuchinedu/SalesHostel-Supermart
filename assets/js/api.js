// API Helper
const getApiUrl = (endpoint) => {
    if (!CONFIG.API_BASE_URL) {
        console.error("API base URL is not configured.");
        return endpoint;
    }
    return `${CONFIG.API_BASE_URL}${endpoint}`;
};

const getAuthHeaders = () => {
    const accessToken = localStorage.getItem('accessToken');
    const headers = {
        'Content-Type': 'application/json',
    };
    if (accessToken) {
        headers['Authorization'] = `Bearer ${accessToken}`;
    } else {
        console.warn('No access token found in localStorage');
    }
    return headers;
};

const api = {
    post: async (endpoint, body) => {
        try {
            const response = await fetch(getApiUrl(endpoint), {
                method: 'POST',
                headers: getAuthHeaders(),
                body: JSON.stringify(body),
            });
            return response;
        } catch (error) {
            console.error('API POST Error:', error);
            throw error;
        }
    },
    get: async (endpoint) => {
        try {
            const response = await fetch(getApiUrl(endpoint), {
                method: 'GET',
                headers: getAuthHeaders(),
            });
            if (response.status === 401) {
                localStorage.removeItem('user');
                localStorage.removeItem('accessToken');
                window.location.href = '/login';
                throw new Error('Unauthorized');
            }
            return response;
        } catch (error) {
            console.error('API GET Error:', error);
            throw error;
        }
    },
    put: async (endpoint, body) => {
        try {
            const response = await fetch(getApiUrl(endpoint), {
                method: 'PUT',
                headers: getAuthHeaders(),
                body: JSON.stringify(body),
            });
            return response;
        } catch (error) {
            console.error('API PUT Error:', error);
            throw error;
        }
    },
    delete: async (endpoint) => {
        try {
            const response = await fetch(getApiUrl(endpoint), {
                method: 'DELETE',
                headers: getAuthHeaders(),
            });
            return response;
        } catch (error) {
            console.error('API DELETE Error:', error);
            throw error;
        }
    }
};

// Services

const AuthService = {
    login: async (email, password) => {
        const response = await api.post('/api/v1/auth/login', { email, password });
        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Login failed');
        }
        // Store auth data
        if (data.data && data.data.accessToken) {
            localStorage.setItem('accessToken', data.data.accessToken);
            localStorage.setItem('user', JSON.stringify(data.data.user));
        }
        return data;
    },
    signup: async (userData) => {
        const response = await api.post('/api/v1/auth/register', { ...userData, role: 'Customer' });
        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Signup failed');
        }
        // Store auth data
        if (data.data && data.data.accessToken) {
            localStorage.setItem('accessToken', data.data.accessToken);
            localStorage.setItem('user', JSON.stringify(data.data.user));
        }
        return data;
    },
    logout: async () => {
        try {
            await api.post('/api/v1/auth/logout', {});
        } catch (err) {
            console.error("Logout failed on server:", err);
        } finally {
            localStorage.removeItem('user');
            localStorage.removeItem('accessToken');
            window.location.href = '/login';
        }
    },
    getCurrentUser: () => {
        const userStr = localStorage.getItem('user');
        return userStr ? JSON.parse(userStr) : null;
    },
    isAuthenticated: () => {
        return !!localStorage.getItem('accessToken');
    }
};

const ProductService = {
    getAllProducts: async (params = {}) => {
        const query = new URLSearchParams(params).toString();
        const response = await api.get(`/api/v1/products?${query}`);
        if (!response.ok) throw new Error('Failed to fetch products');
        return response.json();
    },
    getAllProductNames: async () => {
        const response = await api.get('/api/v1/products/names');
        if (!response.ok) throw new Error('Failed to fetch product names');
        return response.json();
    },
    getProductById: async (id) => {
        const response = await api.get(`/api/v1/products/${id}`);
        if (!response.ok) throw new Error('Failed to fetch product');
        return response.json();
    },
    createProduct: async (productData) => {
        const response = await api.post('/api/v1/products', productData);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to create product');
        return result;
    },
    updateProduct: async (id, productData) => {
        const response = await api.put(`/api/v1/products/${id}`, productData);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to update product');
        return result;
    },
    deleteProduct: async (id) => {
        const response = await api.delete(`/api/v1/products/${id}`);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to delete product');
        return result;
    }
};

const GroupService = {
    getAllGroups: async () => {
        const response = await api.get('/api/v1/groups');
        if (!response.ok) throw new Error('Failed to fetch groups');
        return response.json();
    },
    createGroup: async (data) => {
        const response = await api.post('/api/v1/groups', data);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to create group');
        return result;
    },
    updateGroup: async (id, data) => {
        const response = await api.put(`/api/v1/groups/${id}`, data);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to update group');
        return result;
    },
    deleteGroup: async (id) => {
        const response = await api.delete(`/api/v1/groups/${id}`);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to delete group');
        return result;
    }
};

const UniqueNameService = {
    getAllUniqueNames: async () => {
        const response = await api.get('/api/v1/unique-names');
        if (!response.ok) throw new Error('Failed to fetch unique names');
        return response.json();
    },
    createUniqueName: async (data) => {
        const response = await api.post('/api/v1/unique-names', data);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to create unique name');
        return result;
    },
    updateUniqueName: async (id, data) => {
        const response = await api.put(`/api/v1/unique-names/${id}`, data);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to update unique name');
        return result;
    },
    deleteUniqueName: async (id) => {
        const response = await api.delete(`/api/v1/unique-names/${id}`);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to delete unique name');
        return result;
    }
};

const PurchaseService = {
    getAllPurchases: async (params = {}) => {
        const query = new URLSearchParams(params).toString();
        const response = await api.get(`/api/v1/purchases?${query}`);
        if (!response.ok) throw new Error('Failed to fetch purchases');
        return response.json();
    },
    getPurchaseById: async (id) => {
        const response = await api.get(`/api/v1/purchases/${id}`);
        if (!response.ok) throw new Error('Failed to fetch purchase');
        return response.json();
    },
    createPurchase: async (data) => {
        const response = await api.post('/api/v1/purchases', data);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to create purchase');
        return result;
    },
    updatePurchase: async (id, data) => {
        const response = await api.put(`/api/v1/purchases/${id}`, data);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to update purchase');
        return result;
    },
    deletePurchase: async (id) => {
        const response = await api.delete(`/api/v1/purchases/${id}`);
        if (!response.ok) throw new Error('Failed to delete purchase');
        return response.json();
    },
    markAsPaid: async (id) => {
        const response = await api.put(`/api/v1/purchases/${id}/pay`, {});
        if (!response.ok) throw new Error('Failed to mark as paid');
        return response.json();
    },
    markAsPending: async (id) => {
        const response = await api.put(`/api/v1/purchases/${id}`, { paymentStatus: 'Pending' });
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to mark as pending');
        return result;
    },
    getMyPurchases: async (params = {}) => {
        const query = new URLSearchParams(params).toString();
        const response = await api.get(`/api/v1/purchases/my-purchases?${query}`);
        if (!response.ok) throw new Error('Failed to fetch my purchases');
        return response.json();
    },
    getAllCustomerNames: async () => {
        const response = await api.get('/api/v1/purchases/customers');
        if (!response.ok) throw new Error('Failed to fetch customer names');
        return response.json();
    }
};

const SupplyService = {
    getAllSupplies: async () => {
        const response = await api.get('/api/v1/supplies');
        if (!response.ok) throw new Error('Failed to fetch supplies');
        return response.json();
    },
    getSupplyById: async (id) => {
        const response = await api.get(`/api/v1/supplies/${id}`);
        if (!response.ok) throw new Error('Failed to fetch supply');
        return response.json();
    },
    createSupply: async (data) => {
        const response = await api.post('/api/v1/supplies', data);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to create supply');
        return result;
    },
    updateSupply: async (id, data) => {
        const response = await api.put(`/api/v1/supplies/${id}`, data);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to update supply');
        return result;
    },
    deleteSupply: async (id) => {
        const response = await api.delete(`/api/v1/supplies/${id}`);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to delete supply');
        return result;
    }
};

const CartService = {
    getCart: async () => {
        const response = await api.get('/api/v1/cart');
        if (!response.ok) throw new Error('Failed to fetch cart');
        return response.json();
    },
    addToCart: async (productId, quantity = 1) => {
        const response = await api.post('/api/v1/cart', { productId, quantity });
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to add to cart');
        return result;
    },
    removeFromCart: async (productId) => {
        const response = await api.delete(`/api/v1/cart/${productId}`);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to remove from cart');
        return result;
    },
    clearCart: async () => {
        const response = await api.delete('/api/v1/cart');
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to clear cart');
        return result;
    },
    increaseQuantity: async (productId) => {
        const response = await fetch(getApiUrl(`/api/v1/cart/${productId}/increase`), {
            method: 'PATCH',
            headers: getAuthHeaders()
        });
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to increase quantity');
        return result;
    },
    decreaseQuantity: async (productId) => {
        const response = await fetch(getApiUrl(`/api/v1/cart/${productId}/decrease`), {
            method: 'PATCH',
            headers: getAuthHeaders()
        });
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to decrease quantity');
        return result;
    }
};

const UserService = {
    getAllUsers: async (params = {}) => {
        const query = new URLSearchParams(params).toString();
        const response = await api.get(`/api/v1/users?${query}`);
        if (!response.ok) throw new Error('Failed to fetch users');
        return response.json();
    },
    getUserById: async (id) => {
        const response = await api.get(`/api/v1/users/${id}`);
        if (!response.ok) throw new Error('Failed to fetch user');
        return response.json();
    },
    updateUser: async (id, data) => {
        const response = await api.put(`/api/v1/users/${id}`, data);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to update user');
        return result;
    },
    deleteUser: async (id) => {
        const response = await api.delete(`/api/v1/users/${id}`);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to delete user');
        return result;
    }
};

const PublicService = {
    getAllGroups: async (params = {}) => {
        const query = new URLSearchParams(params).toString();
        // Use fetch directly to avoid auth headers if not needed, or use api.get if auth is optional/handled
        // The user specified "Authentication: Not required", so we can use a simple fetch or a modified api.get
        // However, api.get adds auth headers which shouldn't hurt if the endpoint ignores them.
        // But to be safe and strictly follow "Not required", let's use a direct fetch wrapper or ensure api.get handles it.
        // Given existing api.get structure, it adds headers. Let's create a public helper or just use fetch here.

        try {
            const response = await fetch(getApiUrl(`/api/v1/public/groups?${query}`), {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            });
            if (!response.ok) throw new Error('Failed to fetch public groups');
            return response.json();
        } catch (error) {
            console.error('Public API Groups Error:', error);
            throw error;
        }
    },
    getAllProducts: async (params = {}) => {
        const query = new URLSearchParams(params).toString();
        try {
            const response = await fetch(getApiUrl(`/api/v1/public/products?${query}`), {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            });
            if (!response.ok) throw new Error('Failed to fetch public products');
            return response.json();
        } catch (error) {
            console.error('Public API Products Error:', error);
            throw error;
        }
    }
};
