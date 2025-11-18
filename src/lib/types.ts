
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
    totalAmount?: number;
    paymentStatus: 'Pending' | 'Paid' | 'Partial' | 'Overdue';
    notes?: string;
    date: string; // This is the supply date set by user
    createdAt: string;
    updatedAt: string;
};

export type SupplySummary = {
    _id: string;
    id: string;
    supplyId: string;
    supplierName?: string;
    paymentStatus: 'Pending' | 'Paid' | 'Partial' | 'Overdue';
    totalAmount?: number;
    updatedAt: string;
    supplier: { 
        _id: string;
        name: string;
    };
    products: SupplyProduct[];
    notes?: string;
}

export type PurchaseProduct = {
    product: string; // Product ID
    name: string;
    quantity: number;
    price: number;
    quantityUnit: "pcs" | "kg" | "ltr" | "box";
};

export type Purchase = {
    id: string;
    _id: string;
    purchaseNumber: string;
    customer: {
        _id: string;
        name: string;
    };
    customerName?: string;
    products: PurchaseProduct[];
    total: number;
    paymentStatus: "Paid" | "Pending" | "Cancelled" | "Refunded" | "Partial";
    deliveryStatus: 'Pending' | 'Processing' | 'Shipped' | 'Delivered' | 'Cancelled';
    date: string;
    createdAt: string;
    updatedAt: string;
    notes?: string;
    pickUpFee?: number;
    paymentMethod?: "Cash" | "Card" | "Transfer" | "Check" | "Other";
    paymentReference?: string;
    deliveryAddress?: {
        street?: string;
        city?: string;
        state?: string;
        country?: string;
        postalCode?: string;
    };
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

    
