
export type UserRole = "Admin" | "Staff" | "Supplier" | "Customer";

export type User = {
  _id: string;
  id: string;
  name: string;
  email: string;
  avatar: string | null;
  role: UserRole;
  isActive?: boolean;
  lastLogin?: string | null;
  phone?: string | null;
  createdAt?: string;
  updatedAt?: string;
};

export type Product = {
  id: string;
  _id: string;
  name: string;
  group: string;
  uniqueName: string;
  costPrice: number;
  sellingPrice: number;
  quantityAvailable: number;
  quantityUnit: "pcs" | "kg" | "ltr" | "box";
  imageUrl?: string;
  images?: string[];
  tags: string[];
  description: string;
};

export type SupplyProduct = {
    product: string; // Product ID
    productName: string;
    quantity: number;
    quantityType: 'pcs' | 'kg' | 'ltr' | 'box';
    totalCost?: number;
};
  
export type Supply = {
    _id: string;
    id: string;
    supplyId: string;
    supplier: {
        _id: string;
        name: string;
    };
    supplierRef?: string;
    products: SupplyProduct[];
    totalAmount: number;
    paymentStatus: 'Pending' | 'Paid' | 'Partial' | 'Overdue';
    notes?: string;
    date: string;
    createdAt: string;
    updatedAt: string;
};

export type Purchase = {
  id: string;
  customerName: string;
  products: { name: string; quantity: number; price: number }[];
  total: number;
  paymentStatus: "Paid" | "Pending";
  date: string;
};

export type Group = {
    _id: string;
    id: string;
    name: string;
}

export type UniqueName = {
    _id: string;
    id: string;
    name: string;
}
