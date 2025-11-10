import { api } from '@/lib/api';
import type { UniqueName } from '@/lib/types';

export const UniqueNameService = {
    getAllUniqueNames: async (params = {}) => {
        const query = new URLSearchParams(params).toString();
        const response = await api.get(`/api/v1/unique-names?${query}`);
        if (!response.ok) {
            throw new Error('Failed to fetch unique names');
        }
        return response.json();
    },
    getUniqueNameById: async (id: string) => {
        const response = await api.get(`/api/v1/unique-names/${id}`);
        if (!response.ok) {
            throw new Error('Failed to fetch unique name');
        }
        return response.json();
    },
    createUniqueName: async (uniqueNameData: { name: string }) => {
        const response = await api.post('/api/v1/unique-names', uniqueNameData);
        if (!response.ok) {
            throw new Error('Failed to create unique name');
        }
        return response.json();
    },
    updateUniqueName: async (id: string, uniqueNameData: { name: string }) => {
        const response = await api.put(`/api/v1/unique-names/${id}`, uniqueNameData);
        if (!response.ok) {
            throw new Error('Failed to update unique name');
        }
        return response.json();
    },
    deleteUniqueName: async (id: string) => {
        const response = await api.delete(`/api/v1/unique-names/${id}`);
        if (!response.ok) {
            throw new Error('Failed to delete unique name');
        }
        return response.json();
    }
};
