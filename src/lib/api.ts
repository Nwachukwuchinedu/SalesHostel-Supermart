
const getApiUrl = (endpoint: string) => {
    const baseUrl = process.env.NEXT_PUBLIC_API_BASE_URL;
    if (!baseUrl) {
      throw new Error("API base URL is not configured. Please set NEXT_PUBLIC_API_BASE_URL in your environment variables.");
    }
    return `${baseUrl}${endpoint}`;
};

const getAuthHeaders = () => {
    const accessToken = localStorage.getItem('accessToken');
    const headers: Record<string, string> = {
        'Content-Type': 'application/json',
    };
    if (accessToken) {
        headers['Authorization'] = `Bearer ${accessToken}`;
    }
    return headers;
}
  
export const api = {
    post: async (endpoint: string, body: any) => {
      const response = await fetch(getApiUrl(endpoint), {
        method: 'POST',
        credentials: 'include',
        headers: getAuthHeaders(),
        body: JSON.stringify(body),
      });
      return response;
    },
    get: async (endpoint: string) => {
        const response = await fetch(getApiUrl(endpoint), {
            method: 'GET',
            credentials: 'include',
            headers: getAuthHeaders(),
        });
        return response;
    },
    put: async (endpoint: string, body: any) => {
        const response = await fetch(getApiUrl(endpoint), {
            method: 'PUT',
            credentials: 'include',
            headers: getAuthHeaders(),
            body: JSON.stringify(body),
        });
        return response;
    },
    delete: async (endpoint: string) => {
        const response = await fetch(getApiUrl(endpoint), {
            method: 'DELETE',
            credentials: 'include',
            headers: getAuthHeaders(),
        });
        return response;
    }
};
