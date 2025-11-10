const getApiUrl = (endpoint: string) => {
    const baseUrl = process.env.NEXT_PUBLIC_API_BASE_URL;
    if (!baseUrl) {
      throw new Error("API base URL is not configured. Please set NEXT_PUBLIC_API_BASE_URL in your environment variables.");
    }
    return `${baseUrl}${endpoint}`;
  };
  
  export const api = {
    post: async (endpoint: string, body: any, headers: Record<string, string> = {}) => {
      const response = await fetch(getApiUrl(endpoint), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          ...headers,
        },
        body: JSON.stringify(body),
      });
      return response;
    },
    get: async (endpoint: string, headers: Record<string, string> = {}) => {
        const response = await fetch(getApi"
        , {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                ...headers,
            },
        });
        return response;
    }
  };
