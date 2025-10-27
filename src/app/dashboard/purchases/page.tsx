
"use client";

import { useState } from "react";
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
  DialogDescription,
  DialogFooter,
} from "@/components/ui/dialog";
import { MoreHorizontal, PlusCircle } from "lucide-react";
import { purchases as initialPurchases } from "@/lib/data";
import { Badge } from "@/components/ui/badge";
import type { Purchase } from "@/lib/types";
import { PurchaseForm } from "./purchase-form";
import { Separator } from "@/components/ui/separator";

export default function PurchasesPage() {
  const [purchases, setPurchases] = useState<Purchase[]>(initialPurchases);
  const [isFormOpen, setIsFormOpen] = useState(false);
  const [isDetailsOpen, setIsDetailsOpen] = useState(false);
  const [isReceiptOpen, setIsReceiptOpen] = useState(false);
  const [selectedPurchase, setSelectedPurchase] = useState<Purchase | null>(null);

  const handleCreateNew = () => {
    setSelectedPurchase(null);
    setIsFormOpen(true);
  }

  const handleEditPurchase = (purchase: Purchase) => {
    setSelectedPurchase(purchase);
    setIsDetailsOpen(false);
    setIsFormOpen(true);
  };

  const handleFormSubmit = (purchaseValues: Purchase) => {
    if (selectedPurchase) {
      // Update existing purchase
      setPurchases(
        purchases.map((p) => (p.id === selectedPurchase.id ? purchaseValues : p))
      );
    } else {
      // Add new purchase
      setPurchases([purchaseValues, ...purchases]);
    }
    setIsFormOpen(false);
    setSelectedPurchase(null);
  };

  const handleMarkAsPaid = (purchaseId: string) => {
    setPurchases(
      purchases.map((p) =>
        p.id === purchaseId ? { ...p, paymentStatus: "Paid" } : p
      )
    );
  };

  const handleViewDetails = (purchase: Purchase) => {
    setSelectedPurchase(purchase);
    setIsDetailsOpen(true);
  };

  const handleViewReceipt = (purchase: Purchase) => {
    setSelectedPurchase(purchase);
    setIsReceiptOpen(true);
  };

  return (
    <div className="flex flex-col gap-8">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-headline font-bold tracking-tight">
            Purchases
          </h1>
          <p className="text-muted-foreground">
            Manage customer purchases and orders.
          </p>
        </div>
        <Button onClick={handleCreateNew}>
          <PlusCircle className="mr-2 h-4 w-4" /> New Purchase
        </Button>
      </div>
      <Card>
        <CardHeader>
          <CardTitle>Purchase History</CardTitle>
          <CardDescription>
            A list of all purchases made by customers.
          </CardDescription>
        </CardHeader>
        <CardContent className="pt-0">
          <div className="overflow-x-auto">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Customer</TableHead>
                  <TableHead>Status</TableHead>
                  <TableHead>Date</TableHead>
                  <TableHead className="text-right">Total</TableHead>
                  <TableHead>
                    <span className="sr-only">Actions</span>
                  </TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {purchases.map((purchase) => (
                  <TableRow key={purchase.id}>
                    <TableCell className="font-medium">
                      {purchase.customerName}
                    </TableCell>
                    <TableCell>
                      <Badge
                        variant={
                          purchase.paymentStatus === "Paid"
                            ? "default"
                            : "secondary"
                        }
                        className={
                          purchase.paymentStatus === "Paid"
                            ? "bg-green-500/20 text-green-700 hover:bg-green-500/30"
                            : "bg-yellow-500/20 text-yellow-700 hover:bg-yellow-500/30"
                        }
                      >
                        {purchase.paymentStatus}
                      </Badge>
                    </TableCell>
                    <TableCell>
                      {new Date(purchase.date).toLocaleDateString()}
                    </TableCell>
                    <TableCell className="text-right">
                      ${purchase.total.toFixed(2)}
                    </TableCell>
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
                            <DropdownMenuItem onSelect={() => handleViewDetails(purchase)}>View Details</DropdownMenuItem>
                            <DropdownMenuItem onSelect={() => handleViewReceipt(purchase)}>View Receipt</DropdownMenuItem>
                            {purchase.paymentStatus !== "Paid" && (
                                <DropdownMenuItem onSelect={() => handleMarkAsPaid(purchase.id)}>Mark as Paid</DropdownMenuItem>
                            )}
                          </DropdownMenuContent>
                        </DropdownMenu>
                      </div>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </div>
        </CardContent>
      </Card>

      <Dialog open={isFormOpen} onOpenChange={setIsFormOpen}>
        <DialogContent className="sm:max-w-3xl">
          <DialogHeader>
            <DialogTitle>{selectedPurchase ? 'Edit Purchase' : 'Create New Purchase'}</DialogTitle>
          </DialogHeader>
          <PurchaseForm
            initialData={selectedPurchase}
            onSubmit={handleFormSubmit}
            onCancel={() => setIsFormOpen(false)}
          />
        </DialogContent>
      </Dialog>

      <Dialog open={isDetailsOpen} onOpenChange={setIsDetailsOpen}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Purchase Details</DialogTitle>
            <DialogDescription>
              Details for purchase ID: {selectedPurchase?.id}
            </DialogDescription>
          </DialogHeader>
          {selectedPurchase && (
            <div className="space-y-4">
              <div><strong>Customer:</strong> {selectedPurchase.customerName}</div>
              <div><strong>Date:</strong> {new Date(selectedPurchase.date).toLocaleDateString()}</div>
              <div><strong>Status:</strong> {selectedPurchase.paymentStatus}</div>
              <Separator />
              <h4 className="font-semibold">Products</h4>
              <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Product</TableHead>
                        <TableHead>Quantity</TableHead>
                        <TableHead className="text-right">Price</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {selectedPurchase.products.map((p, i) => (
                        <TableRow key={i}>
                            <TableCell>{p.name}</TableCell>
                            <TableCell>{p.quantity}</TableCell>
                            <TableCell className="text-right">${p.price.toFixed(2)}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
              </Table>
              <Separator />
              <div className="text-right font-bold text-lg">
                Total: ${selectedPurchase.total.toFixed(2)}
              </div>
            </div>
          )}
          <DialogFooter>
            <Button variant="outline" onClick={() => setIsDetailsOpen(false)}>Close</Button>
            <Button onClick={() => handleEditPurchase(selectedPurchase!)}>Edit</Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>
      
      <Dialog open={isReceiptOpen} onOpenChange={setIsReceiptOpen}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Receipt</DialogTitle>
          </DialogHeader>
          {selectedPurchase && (
            <div className="space-y-6 text-sm">
                <div className="text-center">
                    <h3 className="font-bold text-lg font-headline">SalesHostel Digital</h3>
                    <p className="text-muted-foreground">123 Market St, San Francisco, CA</p>
                </div>
                <Separator />
                <div className="grid grid-cols-2 gap-2">
                    <div><strong>Receipt For:</strong> {selectedPurchase.customerName}</div>
                    <div className="text-right"><strong>Date:</strong> {new Date(selectedPurchase.date).toLocaleDateString()}</div>
                    <div><strong>Receipt ID:</strong> {selectedPurchase.id}</div>
                </div>
                <Separator />
                <div className="space-y-2">
                    {selectedPurchase.products.map((item, index) => (
                        <div key={index} className="flex justify-between">
                            <span>{item.quantity}x {item.name}</span>
                            <span>${(item.quantity * item.price).toFixed(2)}</span>
                        </div>
                    ))}
                </div>
                <Separator />
                <div className="flex justify-between font-bold text-base">
                    <span>Total</span>
                    <span>${selectedPurchase.total.toFixed(2)}</span>
                </div>
                 <Separator />
                 <div className="text-center text-muted-foreground">
                    <p>Thank you for your purchase!</p>
                 </div>
            </div>
          )}
           <DialogFooter>
                <Button onClick={() => setIsReceiptOpen(false)}>Close</Button>
                <Button onClick={() => window.print()}>Print</Button>
            </DialogFooter>
        </DialogContent>
      </Dialog>

    </div>
  );
}
