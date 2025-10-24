"use client";

import { useState, useEffect, useMemo } from "react";
import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
  } from "@/components/ui/alert-dialog"
import { Input } from "@/components/ui/input";
import { MoreHorizontal, PlusCircle, Search } from "lucide-react";
import { products as initialProducts } from "@/lib/data";
import { ProductForm } from "./product-form";
import type { Product, UserRole } from "@/lib/types";

export default function ProductsPage() {
  const [products, setProducts] = useState<Product[]>(initialProducts);
  const [userRole, setUserRole] = useState<UserRole | null>(null);
  const [searchTerm, setSearchTerm] = useState("");
  const [isFormOpen, setIsFormOpen] = useState(false);
  const [isAlertOpen, setIsAlertOpen] = useState(false);
  const [selectedProduct, setSelectedProduct] = useState<Product | null>(null);
  const [productToDelete, setProductToDelete] = useState<string | null>(null);

  useEffect(() => {
    // In a real app, you would fetch user role from your auth context
    const role = localStorage.getItem("userRole") as UserRole;
    setUserRole(role || "Customer");
  }, []);

  const canManageProducts = userRole === "Admin";

  const handleAddProduct = () => {
    setSelectedProduct(null);
    setIsFormOpen(true);
  };

  const handleEditProduct = (product: Product) => {
    setSelectedProduct(product);
    setIsFormOpen(true);
  };

  const handleDeleteClick = (productId: string) => {
    setProductToDelete(productId);
    setIsAlertOpen(true);
  }

  const handleDeleteConfirm = () => {
    if (productToDelete) {
        setProducts(products.filter((p) => p.id !== productToDelete));
    }
    setIsAlertOpen(false);
    setProductToDelete(null);
  }

  const handleFormSubmit = (values: Product) => {
    if (selectedProduct) {
      // Update existing product
      setProducts(
        products.map((p) => (p.id === selectedProduct.id ? values : p))
      );
    } else {
      // Add new product
      setProducts([...products, values]);
    }
    setIsFormOpen(false);
    setSelectedProduct(null);
  };

  const filteredProducts = useMemo(() => {
    if (!searchTerm) return products;
    return products.filter(
      (product) =>
        product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
        product.group.toLowerCase().includes(searchTerm.toLowerCase()) ||
        product.tags.some((tag) =>
          tag.toLowerCase().includes(searchTerm.toLowerCase())
        )
    );
  }, [products, searchTerm]);

  if (userRole === null) {
      return <div>Loading...</div>
  }

  return (
    <div className="flex flex-col gap-8">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-headline font-bold tracking-tight">
            Products
          </h1>
          <p className="text-muted-foreground">Manage your product inventory.</p>
        </div>
        {canManageProducts && (
          <Button onClick={handleAddProduct}>
            <PlusCircle className="mr-2 h-4 w-4" /> Add Product
          </Button>
        )}
      </div>

      <Card>
        <CardHeader>
          <CardTitle>Product List</CardTitle>
          <CardDescription>
            A list of all products in your store.
          </CardDescription>
          <div className="relative mt-4">
            <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
            <Input
              type="search"
              placeholder="Search by name, group, or tag..."
              className="w-full rounded-lg bg-background pl-8"
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
            />
          </div>
        </CardHeader>
        <CardContent>
          <div className="relative w-full overflow-auto max-h-[60vh]">
            <Table>
                <TableHeader>
                <TableRow>
                    <TableHead>Name</TableHead>
                    <TableHead>Group</TableHead>
                    <TableHead>Price</TableHead>
                    {canManageProducts && (
                    <TableHead>
                        <span className="sr-only">Actions</span>
                    </TableHead>
                    )}
                </TableRow>
                </TableHeader>
                <TableBody>
                {filteredProducts.map((product) => (
                    <TableRow key={product.id}>
                    <TableCell className="font-medium">{product.name}</TableCell>
                    <TableCell>{product.group}</TableCell>
                    <TableCell>${product.price.toFixed(2)}</TableCell>
                    {canManageProducts && (
                        <TableCell>
                        <div className="flex justify-end">
                            <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button
                                aria-haspopup="true"
                                size="icon"
                                variant="ghost"
                                >
                                <MoreHorizontal className="h-4 w-4" />
                                <span className="sr-only">Toggle menu</span>
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuLabel>Actions</DropdownMenuLabel>
                                <DropdownMenuItem
                                onSelect={() => handleEditProduct(product)}
                                >
                                Edit
                                </DropdownMenuItem>
                                <DropdownMenuItem onSelect={() => handleDeleteClick(product.id)}>
                                Delete
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                            </DropdownMenu>
                        </div>
                        </TableCell>
                    )}
                    </TableRow>
                ))}
                </TableBody>
            </Table>
          </div>
        </CardContent>
      </Card>

      <Dialog open={isFormOpen} onOpenChange={setIsFormOpen}>
        <DialogContent className="sm:max-w-md">
          <DialogHeader>
            <DialogTitle>
              {selectedProduct ? "Edit Product" : "Add New Product"}
            </DialogTitle>
          </DialogHeader>
          <ProductForm
            initialData={selectedProduct}
            onSubmit={handleFormSubmit}
            onCancel={() => setIsFormOpen(false)}
          />
        </DialogContent>
      </Dialog>

      <AlertDialog open={isAlertOpen} onOpenChange={setIsAlertOpen}>
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                <AlertDialogDescription>
                    This action cannot be undone. This will permanently delete this product.
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>
                <AlertDialogAction onClick={handleDeleteConfirm}>Continue</AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>
    </div>
  );
}
