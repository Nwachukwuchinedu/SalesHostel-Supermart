"use client";

import { createContext, useContext, useState, useEffect, ReactNode } from 'react';
import type { User } from '@/lib/types';
import Cookies from 'js-cookie';
import { api } from '@/lib/api';

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

  useEffect(() => {
    const accessToken = Cookies.get('accessToken');
    const userData = Cookies.get('user');
    if (accessToken && userData) {
        try {
            setUser(JSON.parse(userData));
        } catch (error) {
            console.error("Failed to parse user data from cookies", error);
            Cookies.remove('accessToken');
            Cookies.remove('user');
        }
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
    Cookies.set('accessToken', accessToken, { expires: 1, secure: process.env.NODE_ENV === 'production' });
    Cookies.set('user', JSON.stringify(userData), { expires: 1, secure: process.env.NODE_ENV === 'production' });
  };

  const signup = async (userData: Omit<User, 'id' | '_id' | 'role' | 'avatar'> & {role?: undefined}) => {
    const response = await api.post('/api/v1/auth/register', { ...userData, role: 'Customer' });
    const data = await response.json();

    if (!response.ok || !data.success) {
      throw new Error(data.message || 'Signup failed');
    }
  };

  const logout = () => {
    const accessToken = Cookies.get('accessToken');
    if (accessToken) {
        api.post('/api/v1/auth/logout', {}).catch(err => console.error("Logout failed on server:", err));
    }
    
    setUser(null);
    Cookies.remove('accessToken');
    Cookies.remove('user');
    Cookies.remove('refreshToken');
    Cookies.remove('csrfToken');
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
