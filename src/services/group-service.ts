import { api } from '@/lib/api';
import type { Group } from '@/lib/types';

export const GroupService = {
    getAllGroups: async (params = {}) => {
        const query = new URLSearchParams(params).toString();
        const response = await api.get(`/api/v1/groups?${query}`);
        if (!response.ok) {
            throw new Error('Failed to fetch groups');
        }
        return response.json();
    },
    getGroupById: async (id: string) => {
        const response = await api.get(`/api/v1/groups/${id}`);
        if (!response.ok) {
            throw new Error('Failed to fetch group');
        }
        return response.json();
    },
    createGroup: async (groupData: { name: string }) => {
        const response = await api.post('/api/v1/groups', groupData);
        if (!response.ok) {
            throw new Error('Failed to create group');
        }
        return response.json();
    },
    updateGroup: async (id: string, groupData: { name: string }) => {
        const response = await api.put(`/api/v1/groups/${id}`, groupData);
        if (!response.ok) {
            throw new Error('Failed to update group');
        }
        return response.json();
    },
    deleteGroup: async (id: string) => {
        const response = await api.delete(`/api/v1/groups/${id}`);
        if (!response.ok) {
            throw new Error('Failed to delete group');
        }
        return response.json();
    }
};
