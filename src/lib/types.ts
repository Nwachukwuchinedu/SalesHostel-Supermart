
export type UserRole = "Admin" | "Staff" | "Supplier" | "Customer";

export type User = {
  id: string;
  name: string;
  email: string;
  avatar: string;
  role: UserRole;
};

export type Product = {
  id: string;
  name: string;
  group: string;
  uniqueName: string;
  costPrice: number;
  sellingPrice: number;
  quantityAvailable: number;
  quantityUnit: "pcs" | "kg" | "ltr" | "box";
  imageUrl?: string;
  tags: string[];
  description: string;
};

export type Supply = {
  id: string;
  productName: string;
  uniqueName: string;
  quantityType: "pcs" | "kg" | "ltr" | "box";
  quantity: number;
  supplier: string;
  date: string;
};

export type Purchase = {
  id: string;
  customerName: string;
  products: { name: string; quantity: number; price: number }[];
  total: number;
  paymentStatus: "Paid" | "Pending";
  date: string;
};

    