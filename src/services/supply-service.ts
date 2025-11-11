
import { api } from '@/lib/api';

type SupplyInput = {
    products: {
        product: string;
        quantity: number;
        quantityType: "pcs" | "kg" | "ltr" | "box";
        totalCost?: number;
    }[];
    supplierRef?: string;
    notes?: string;
    date?: string;
    paymentStatus?: 'Pending' | 'Paid' | 'Partial' | 'Overdue';
};


export const SupplyService = {
    getAllSupplies: async (params = {}) => {
        const query = new URLSearchParams(params).toString();
        const response = await api.get(`/api/v1/supplies?${query}`);
        if (!response.ok) {
            throw new Error('Failed to fetch supplies');
        }
        return response.json();
    },
    getSupplyById: async (id: string) => {
        const response = await api.get(`/api/v1/supplies/${id}`);
        if (!response.ok) {
            throw new Error('Failed to fetch supply');
        }
        return response.json();
    },
    getAllSupplierNames: async () => {
        const response = await api.get('/api/v1/supplies/suppliers');
        if(!response.ok) {
            throw new Error('Failed to fetch supplier names');
        }
        return response.json();
    },
    createSupply: async (supplyData: SupplyInput) => {
        const response = await api.post('/api/v1/supplies', supplyData);
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({ message: 'Failed to create supply' }));
            throw new Error(errorData.message);
        }
        return response.json();
    },
    updateSupply: async (id: string, supplyData: Partial<SupplyInput>) => {
        const response = await api.put(`/api/v1/supplies/${id}`, supplyData);
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({ message: 'Failed to update supply' }));
            throw new Error(errorData.message);
        }
        return response.json();
    },
    deleteSupply: async (id: string) => {
        const response = await api.delete(`/api/v1/supplies/${id}`);
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({ message: 'Failed to delete supply' }));
            throw new Error(errorData.message);
        }
        return response.json();
    }
};
