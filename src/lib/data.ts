
import type { User, Product, Supply, Purchase, Invoice } from "./types";

export const users: User[] = [
  { id: "1", name: "Admin User", email: "admin@example.com", avatar: "1", role: "Admin" },
  { id: "2", name: "Staff User", email: "staff@example.com", avatar: "2", role: "Staff" },
  { id: "3", name: "Supplier User", email: "supplier@example.com", avatar: "3", role: "Supplier" },
  { id: "4", name: "Customer User", email: "customer@example.com", avatar: "4", role: "Customer" },
];

export const products: Product[] = [
  { id: "PROD001", name: "Organic Fuji Apples", uniqueName: "Apples", group: "Fruits", costPrice: 1.50, sellingPrice: 2.99, quantityAvailable: 100, quantityUnit: "kg", tags: ["organic", "fruit", "fresh"], description: "Fresh and crispy Fuji apples, certified organic." },
  { id: "PROD002", name: "Artisanal Whole Wheat Bread", uniqueName: "Bread", group: "Bakery", costPrice: 2.00, sellingPrice: 4.50, quantityAvailable: 50, quantityUnit: "pcs", tags: ["bakery", "bread", "healthy"], description: "A loaf of freshly baked whole wheat bread." },
  { id: "PROD003", name: "Unsweetened Almond Milk", uniqueName: "Almond Milk", group: "Beverages", costPrice: 2.50, sellingPrice: 3.75, quantityAvailable: 75, quantityUnit: "ltr", tags: ["vegan", "dairy-free", "milk"], description: "Unsweetened almond milk, a great dairy alternative." },
  { id: "PROD004", name: "Boneless Chicken Breast", uniqueName: "Chicken", group: "Meat", costPrice: 6.00, sellingPrice: 9.99, quantityAvailable: 30, quantityUnit: "kg", tags: ["meat", "poultry", "protein"], description: "Boneless, skinless chicken breast, sold by the pound." },
  { id: "PROD005", name: "Sharp Cheddar Cheese Block", uniqueName: "Cheddar", group: "Dairy", costPrice: 3.00, sellingPrice: 5.25, quantityAvailable: 40, quantityUnit: "pcs", tags: ["dairy", "cheese"], description: "A block of sharp cheddar cheese." },
];

export const supplies: Supply[] = [
  { id: "SUP001", productName: "Organic Fuji Apples", uniqueName: "Apples", quantityType: "box", quantity: 50, supplier: "Fresh Farms", date: "2023-10-01" },
  { id: "SUP002", productName: "Artisanal Whole Wheat Bread", uniqueName: "Bread", quantityType: "pcs", quantity: 100, supplier: "Bakery Co.", date: "2023-10-02" },
  { id: "SUP003", productName: "Unsweetened Almond Milk", uniqueName: "Almond Milk", quantityType: "ltr", quantity: 200, supplier: "Healthy Drinks Inc.", date: "2023-10-02" },
  { id: "SUP004", productName: "Boneless Chicken Breast", uniqueName: "Chicken", quantityType: "kg", quantity: 75, supplier: "Poultry Direct", date: "2023-10-03" },
];

export const purchases: Purchase[] = [
  { id: "PUR001", customerName: "John Doe", products: [{ name: "Organic Fuji Apples", quantity: 2, price: 2.99 }, { name: "Artisanal Whole Wheat Bread", quantity: 1, price: 4.50 }], total: 10.48, paymentStatus: "Paid", date: "2023-10-05" },
  { id: "PUR002", customerName: "Jane Smith", products: [{ name: "Unsweetened Almond Milk", quantity: 2, price: 3.75 }], total: 7.50, paymentStatus: "Paid", date: "2023-10-06" },
  { id: "PUR003", customerName: "Bob Johnson", products: [{ name: "Boneless Chicken Breast", quantity: 1.5, price: 9.99 }, { name: "Sharp Cheddar Cheese Block", quantity: 1, price: 5.25 }], total: 20.24, paymentStatus: "Pending", date: "2023-10-07" },
  { id: "PUR004", customerName: "Alice Williams", products: [{ name: "Organic Fuji Apples", quantity: 5, price: 2.99 }], total: 14.95, paymentStatus: "Pending", date: "2023-10-08" },
  { id: "PUR005", customerName: "Customer User", products: [{ name: "Artisanal Whole Wheat Bread", quantity: 2, price: 4.50 }], total: 9.00, paymentStatus: "Pending", date: "2023-10-09" },
];

export const invoices: Invoice[] = [
  { id: "INV001", purchaseId: "PUR001", customerName: "John Doe", amount: 10.48, status: "Paid", dueDate: "2023-10-20", issueDate: "2023-10-05" },
  { id: "INV002", purchaseId: "PUR002", customerName: "Jane Smith", amount: 7.50, status: "Paid", dueDate: "2023-10-21", issueDate: "2023-10-06" },
  { id: "INV003", purchaseId: "PUR003", customerName: "Bob Johnson", amount: 20.24, status: "Unpaid", dueDate: "2023-10-22", issueDate: "2023-10-07" },
  { id: "INV004", purchaseId: "PUR004", customerName: "Alice Williams", amount: 15.60, status: "Overdue", dueDate: "2023-09-30", issueDate: "2023-09-15" },
];
