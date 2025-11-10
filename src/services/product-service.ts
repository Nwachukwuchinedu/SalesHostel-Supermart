import { api } from '@/lib/api';
import type { Product } from '@/lib/types';

export const ProductService = {
    getAllProducts: async (params = {}) => {
        const query = new URLSearchParams(params).toString();
        const response = await api.get(`/api/v1/products?${query}`);
        if (!response.ok) {
            throw new Error('Failed to fetch products');
        }
        return response.json();
    },
    getProductById: async (id: string) => {
        const response = await api.get(`/api/v1/products/${id}`);
        if (!response.ok) {
            throw new Error('Failed to fetch product');
        }
        return response.json();
    },
    createProduct: async (productData: Omit<Product, 'id' | '_id'>) => {
        const response = await api.post('/api/v1/products', productData);
        if (!response.ok) {
            throw new Error('Failed to create product');
        }
        return response.json();
    },
    updateProduct: async (id: string, productData: Partial<Omit<Product, 'id' | '_id'>>) => {
        const response = await api.put(`/api/v1/products/${id}`, productData);
        if (!response.ok) {
            throw new Error('Failed to update product');
        }
        return response.json();
    },
    deleteProduct: async (id: string) => {
        const response = await api.delete(`/api/v1/products/${id}`);
        if (!response.ok) {
            throw new Error('Failed to delete product');
        }
        return response.json();
    }
};
