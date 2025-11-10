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
  productId: string;
  productName: string;
  quantity: number;
  quantityType: "pcs" | "kg" | "ltr" | "box";
};

export type Supply = {
  id: string;
  supplier: string;
  date: string;
  products: SupplyProduct[];
  totalItems: number;
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
