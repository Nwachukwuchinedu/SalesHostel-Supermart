
"use client";

import { createContext, useContext, useState, useEffect, ReactNode, useCallback } from 'react';
import type { User } from '@/lib/types';
import { api } from '@/lib/api';
import { useRouter } from 'next/navigation';
import Cookies from 'js-cookie';

interface AuthContextType {
  user: User | null;
  loading: boolean;
  login: (email: string, password: string) => Promise<void>;
  signup: (userData: Omit<User, 'id' | '_id' | 'role' | 'avatar'> & {role?: undefined}) => Promise<void>;
  logout: () => void;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function AuthProvider({ children }: { children: ReactNode }) {
  const [user, setUser] = useState<User | null>(null);
  const [loading, setLoading] = useState(true);
  const router = useRouter();

  const refreshAuth = useCallback(async () => {
    try {
      const refreshResponse = await api.post('/api/v1/auth/refresh', {});
      const refreshData = await refreshResponse.json();
      if (refreshData.success) {
        const { accessToken } = refreshData.data;
        localStorage.setItem('accessToken', accessToken);
        // At this point, we have a valid access token, but we need user data.
        // Let's assume we need to fetch it or it was stored previously.
        const userData = localStorage.getItem('user');
        if (userData) {
          setUser(JSON.parse(userData));
        }
      } else {
        // If refresh fails, clear everything.
        setUser(null);
        localStorage.removeItem('user');
        localStorage.removeItem('accessToken');
        Cookies.remove('csrfToken');
        Cookies.remove('refreshToken');
      }
    } catch (error) {
      console.error("Failed to refresh token", error);
      setUser(null);
      localStorage.removeItem('user');
      localStorage.removeItem('accessToken');
    }
  }, []);


  useEffect(() => {
    const initializeAuth = async () => {
      const accessToken = localStorage.getItem('accessToken');
      const userData = localStorage.getItem('user');
      const refreshToken = Cookies.get('refreshToken');
  
      if (accessToken && userData) {
        // Assume user is logged in if we have token and data
        setUser(JSON.parse(userData));
      } else if (refreshToken) {
        // If no access token but have a refresh token, try to refresh
        await refreshAuth();
      }
      setLoading(false);
    };
  
    initializeAuth();
  }, [refreshAuth]);

  const login = async (email: string, password: string) => {
    const response = await fetch(`${process.env.NEXT_PUBLIC_API_BASE_URL}/api/v1/auth/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password }),
        credentials: 'include',
    });

    const data = await response.json();

    if (!response.ok || !data.success) {
      throw new Error(data.message || 'Login failed');
    }

    const { user: userData, accessToken } = data.data;
    setUser(userData);
    localStorage.setItem('user', JSON.stringify(userData));
    localStorage.setItem('accessToken', accessToken);
  };

  const signup = async (userData: Omit<User, 'id' | '_id' | 'role' | 'avatar'> & {role?: undefined}) => {
    const response = await api.post('/api/v1/auth/register', { ...userData, role: 'Customer' });
    const data = await response.json();

    if (!response.ok || !data.success) {
      throw new Error(data.message || 'Signup failed');
    }
  };

  const logout = async () => {
    try {
        await api.post('/api/v1/auth/logout', {});
    } catch (err) {
        console.error("Logout failed on server:", err)
    } finally {
        setUser(null);
        localStorage.removeItem('user');
        localStorage.removeItem('accessToken');
        Cookies.remove('csrfToken');
        Cookies.remove('refreshToken');
        router.push('/login');
    }
  };

  return (
    <AuthContext.Provider value={{ user, loading, login, signup, logout }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const context = useContext(AuthContext);
  if (context === undefined) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
}
