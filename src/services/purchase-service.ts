
import { api } from '@/lib/api';
import type { Purchase } from '@/lib/types';

export const PurchaseService = {
    getAllPurchases: async (params: Record<string, any> = {}) => {
        const cleanedParams = Object.fromEntries(
            Object.entries(params).filter(([, value]) => value !== null && value !== undefined && value !== '')
        );
        const query = new URLSearchParams(cleanedParams).toString();
        const response = await api.get(`/api/v1/purchases?${query}`);
        if (!response.ok) {
            throw new Error('Failed to fetch purchases');
        }
        return response.json();
    },

    getPurchaseById: async (id: string) => {
        const response = await api.get(`/api/v1/purchases/${id}`);
        if (!response.ok) {
            throw new Error('Failed to fetch purchase');
        }
        return response.json();
    },

    createPurchase: async (purchaseData: any) => {
        const response = await api.post('/api/v1/purchases', purchaseData);
        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.message || 'Failed to create purchase');
        }
        return response.json();
    },

    updatePurchase: async (id: string, purchaseData: any) => {
        const response = await api.put(`/api/v1/purchases/${id}`, purchaseData);
        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.message || 'Failed to update purchase');
        }
        return response.json();
    },

    deletePurchase: async (id: string) => {
        const response = await api.delete(`/api/v1/purchases/${id}`);
        if (!response.ok) {
            throw new Error('Failed to delete purchase');
        }
        return response.json();
    },

    markAsPaid: async (id: string) => {
        const response = await api.put(`/api/v1/purchases/${id}/pay`, {});
        if (!response.ok) {
            throw new Error('Failed to mark purchase as paid');
        }
        return response.json();
    },

    markAsPending: async (id: string) => {
        const response = await api.put(`/api/v1/purchases/${id}`, { paymentStatus: 'Pending' });
        if (!response.ok) {
            throw new Error('Failed to mark purchase as pending');
        }
        return response.json();
    }
};

    