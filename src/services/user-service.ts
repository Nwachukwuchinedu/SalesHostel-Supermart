
import { api } from '@/lib/api';

export const UserService = {
    getAllCustomerNames: async () => {
        const response = await api.get('/api/v1/users?role=Customer&fields=name');
        if(!response.ok) {
            throw new Error('Failed to fetch customer names');
        }
        return response.json();
    }
}
