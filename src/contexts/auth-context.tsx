"use client";

import { createContext, useContext, useState, useEffect, ReactNode } from 'react';
import type { User } from '@/lib/types';
import { api } from '@/lib/api';
import { useRouter } from 'next/navigation';

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

  useEffect(() => {
    try {
        const userData = localStorage.getItem('user');
        const accessToken = localStorage.getItem('accessToken');
        if (userData && accessToken) {
            setUser(JSON.parse(userData));
        }
    } catch (error) {
        console.error("Failed to parse user data from localStorage", error);
        localStorage.removeItem('user');
        localStorage.removeItem('accessToken');
    }
    setLoading(false);
  }, []);

  const login = async (email: string, password: string) => {
    const response = await api.post('/api/v1/auth/login', { email, password });
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
        router.push('/login');
    }
  };

  return (
    <AuthContext.Provider value={{ user, loading, login, signup, logout }}>
      {!loading && children}
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
