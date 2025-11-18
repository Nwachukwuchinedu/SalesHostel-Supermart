import type { User, Product } from "./types";

export const users: User[] = [
  { id: "1", _id: "1", name: "Admin User", email: "admin@example.com", avatar: "1", role: "Admin" },
  { id: "2", _id: "2", name: "Staff User", email: "staff@example.com", avatar: "2", role: "Staff" },
  { id: "3", _id: "3", name: "Supplier User", email: "supplier@example.com", avatar: "3", role: "Supplier" },
  { id: "4", _id: "4", name: "Customer User", email: "customer@example.com", avatar: "4", role: "Customer" },
  { id: "5", _id: "5", name: "Fresh Farms", email: "contact@freshfarms.com", avatar: "3", role: "Supplier" },
  { id: "6", _id: "6", name: "Bakery Co.", email: "contact@bakeryco.com", avatar: "3", role: "Supplier" },
  { id: "7", _id: "7", name: "Healthy Drinks Inc.", email: "contact@healthydrinks.com", avatar: "3", role: "Supplier" },
  { id: "8", _id: "8", name: "Poultry Direct", email: "contact@poultrydirect.com", avatar: "3", role: "Supplier" },
];

export const initialUniqueNames: string[] = ["Apples", "Bread", "Almond Milk", "Chicken", "Cheddar"];
export const initialGroups: string[] = ["Fruits", "Bakery", "Beverages", "Meat", "Dairy"];


export const products: Product[] = [
  { id: "PROD001", _id: "PROD001", name: "Organic Fuji Apples", uniqueName: "Apples", group: "Fruits", costPrice: 1.50, sellingPrice: 2.99, quantityAvailable: 100, quantityUnit: "kg", tags: ["organic", "fruit", "fresh"], description: "Fresh and crispy Fuji apples, certified organic." },
  { id: "PROD002", _id: "PROD002", name: "Artisanal Whole Wheat Bread", uniqueName: "Bread", group: "Bakery", costPrice: 2.00, sellingPrice: 4.50, quantityAvailable: 50, quantityUnit: "pcs", tags: ["bakery", "bread", "healthy"], description: "A loaf of freshly baked whole wheat bread." },
  { id: "PROD003", _id: "PROD003", name: "Unsweetened Almond Milk", uniqueName: "Almond Milk", group: "Beverages", costPrice: 2.50, sellingPrice: 3.75, quantityAvailable: 75, quantityUnit: "ltr", tags: ["vegan", "dairy-free", "milk"], description: "Unsweetened almond milk, a great dairy alternative." },
  { id: "PROD004", _id: "PROD004", name: "Boneless Chicken Breast", uniqueName: "Chicken", group: "Meat", costPrice: 6.00, sellingPrice: 9.99, quantityAvailable: 30, quantityUnit: "kg", tags: ["meat", "poultry", "protein"], description: "Boneless, skinless chicken breast, sold by the pound." },
  { id: "PROD005", _id: "PROD005", name: "Sharp Cheddar Cheese Block", uniqueName: "Cheddar", group: "Dairy", costPrice: 3.00, sellingPrice: 5.25, quantityAvailable: 40, quantityUnit: "pcs", tags: ["dairy", "cheese"], description: "A block of sharp cheddar cheese." },
];
