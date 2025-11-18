
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
  DropdownMenuSeparator,
} from "@/components/ui/dropdown-menu";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogDescription,
  DialogFooter,
} from "@/components/ui/dialog";
import { MoreHorizontal, PlusCircle, Search } from "lucide-react";
import { Badge } from "@/components/ui/badge";
import type { Purchase } from "@/lib/types";
import { PurchaseForm } from "./purchase-form";
import { Separator } from "@/components/ui/separator";
import { PurchaseService } from "@/services/purchase-service";
import { useToast } from "@/hooks/use-toast";
import { Input } from "@/components/ui/input";
import { useAuth } from "@/contexts/auth-context";

export default function PurchasesPage() {
  const [purchases, setPurchases] = useState<Purchase[]>([]);
  const [loading, setLoading] = useState(true);
  const { toast } = useToast();
  const { user } = useAuth();
  
  const [isFormOpen, setIsFormOpen] = useState(false);
  const [isDetailsOpen, setIsDetailsOpen] = useState(false);
  const [isReceiptOpen, setIsReceiptOpen] = useState(false);
  const [selectedPurchase, setSelectedPurchase] = useState<Purchase | null>(null);

  const [searchTerm, setSearchTerm] = useState("");
  const [filters, setFilters] = useState({ paymentStatus: "", deliveryStatus: "" });

  const fetchPurchases = async () => {
    try {
      setLoading(true);
      const params: any = { sort: '-createdAt' };
      if (searchTerm) params.search = searchTerm;
      if (filters.paymentStatus) params.paymentStatus = filters.paymentStatus;
      if (filters.deliveryStatus) params.deliveryStatus = filters.deliveryStatus;

      const response = await PurchaseService.getAllPurchases(params);
      setPurchases(response.data.map((p: any) => ({...p, id: p._id})));
    } catch (error) {
      toast({ title: "Error", description: "Failed to fetch purchases.", variant: "destructive" });
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchPurchases();
  }, [filters]);

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    fetchPurchases();
  }

  const handleCreateNew = () => {
    setSelectedPurchase(null);
    setIsFormOpen(true);
  }

  const handleEditPurchase = async (purchaseId: string) => {
    try {
        const res = await PurchaseService.getPurchaseById(purchaseId);
        setSelectedPurchase({...res.data, id: res.data._id});
        setIsDetailsOpen(false);
        setIsFormOpen(true);
    } catch(err) {
        toast({ title: "Error", description: "Failed to fetch purchase details.", variant: "destructive" });
    }
  };

  const handleFormSubmit = () => {
    setIsFormOpen(false);
    setSelectedPurchase(null);
    fetchPurchases(); // Refresh list after submit
  };

  const handleMarkAsPaid = async (purchaseId: string) => {
    try {
        await PurchaseService.markAsPaid(purchaseId);
        toast({ title: "Success", description: "Purchase marked as paid." });
        fetchPurchases();
    } catch(error) {
        toast({ title: "Error", description: "Failed to mark as paid.", variant: "destructive" });
    }
  };

  const handleDelete = async (purchaseId: string) => {
    try {
        await PurchaseService.deletePurchase(purchaseId);
        toast({ title: "Success", description: "Purchase deleted." });
        fetchPurchases();
    } catch (error) {
        toast({ title: "Error", description: "Failed to delete purchase.", variant: "destructive" });
    }
  }


  const handleViewDetails = async (purchaseId: string) => {
    try {
        const res = await PurchaseService.getPurchaseById(purchaseId);
        setSelectedPurchase({...res.data, id: res.data._id});
        setIsDetailsOpen(true);
    } catch (err) {
        toast({ title: "Error", description: "Failed to fetch purchase details.", variant: "destructive" });
    }
  };

  const handleViewReceipt = async (purchaseId: string) => {
    try {
        const res = await PurchaseService.getPurchaseById(purchaseId);
        setSelectedPurchase({...res.data, id: res.data._id});
        setIsReceiptOpen(true);
    } catch (err) {
        toast({ title: "Error", description: "Failed to fetch receipt details.", variant: "destructive" });
    }
  };
  
  if (loading && purchases.length === 0) {
      return <div>Loading...</div>
  }

  return (
    <div className="flex flex-col gap-8 min-w-0">
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
          <form onSubmit={handleSearch} className="flex gap-4 mt-4">
            <div className="relative flex-grow">
                <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                <Input
                type="search"
                placeholder="Search by customer, purchase #..."
                className="w-full rounded-lg bg-background pl-8"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                />
            </div>
            <Button type="submit">Search</Button>
          </form>
        </CardHeader>
        <CardContent className="pt-0">
          <div className="overflow-x-auto">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Purchase #</TableHead>
                  <TableHead>Customer</TableHead>
                  <TableHead>Payment</TableHead>
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
                    <TableCell className="font-medium">{purchase.purchaseNumber}</TableCell>
                    <TableCell>{purchase.customerName}</TableCell>
                    <TableCell>
                      <Badge variant={purchase.paymentStatus === "Paid" ? "default" : "secondary"}>
                        {purchase.paymentStatus}
                      </Badge>
                    </TableCell>
                    <TableCell>
                      {new Date(purchase.date).toLocaleDateString()}
                    </TableCell>
                    <TableCell className="text-right">
                      ₦{purchase.total.toFixed(2)}
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
                            <DropdownMenuItem onSelect={() => handleViewDetails(purchase.id)}>View Details</DropdownMenuItem>
                            <DropdownMenuItem onSelect={() => handleViewReceipt(purchase.id)}>View Receipt</DropdownMenuItem>
                            <DropdownMenuItem onSelect={() => handleEditPurchase(purchase.id)}>Edit</DropdownMenuItem>
                            <DropdownMenuSeparator />
                            {purchase.paymentStatus !== "Paid" && (
                                <DropdownMenuItem onSelect={() => handleMarkAsPaid(purchase.id)}>Mark as Paid</DropdownMenuItem>
                            )}
                             <DropdownMenuItem onSelect={() => handleDelete(purchase.id)} className="text-red-500">Delete</DropdownMenuItem>
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
        <DialogContent className="sm:max-w-3xl max-w-[calc(100vw-2rem)]">
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
        <DialogContent className="max-w-[calc(100vw-2rem)]">
          <DialogHeader>
            <DialogTitle>Purchase Details</DialogTitle>
            <DialogDescription>
              Details for purchase: {selectedPurchase?.purchaseNumber}
            </DialogDescription>
          </DialogHeader>
          {selectedPurchase && (
            <div className="space-y-4">
              <div><strong>Customer:</strong> {selectedPurchase.customer?.name || selectedPurchase.customerName}</div>
              <div><strong>Date:</strong> {new Date(selectedPurchase.createdAt || selectedPurchase.date).toLocaleDateString()}</div>
              <div><strong>Payment Status:</strong> {selectedPurchase.paymentStatus}</div>
              <div><strong>Delivery Status:</strong> {selectedPurchase.deliveryStatus}</div>
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
                            <TableCell>{p.quantity} {p.quantityUnit}</TableCell>
                            <TableCell className="text-right">₦{p.price.toFixed(2)}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
              </Table>
              <Separator />
              <div className="text-right font-bold text-lg">
                Total: ₦{selectedPurchase.total.toFixed(2)}
              </div>
            </div>
          )}
          <DialogFooter>
            <Button variant="outline" onClick={() => setIsDetailsOpen(false)}>Close</Button>
            {selectedPurchase && <Button onClick={() => handleEditPurchase(selectedPurchase.id)}>Edit</Button>}
          </DialogFooter>
        </DialogContent>
      </Dialog>
      
      <Dialog open={isReceiptOpen} onOpenChange={setIsReceiptOpen}>
        <DialogContent className="max-w-sm">
          <DialogHeader>
            <DialogTitle className="text-center font-headline text-2xl">SalesHostel Digital</DialogTitle>
             <DialogDescription className="text-center">Official Receipt</DialogDescription>
          </DialogHeader>
          {selectedPurchase && (
            <div className="space-y-4 text-sm">
                <Separator />
                <div className="grid grid-cols-2 gap-2">
                    <div><strong>Customer:</strong></div>
                    <div>{selectedPurchase.customer?.name || selectedPurchase.customerName}</div>
                    <div><strong>Date:</strong></div>
                    <div>{new Date(selectedPurchase.createdAt || selectedPurchase.date).toLocaleDateString()}</div>
                    <div><strong>Purchase #:</strong></div>
                    <div>{selectedPurchase.purchaseNumber}</div>
                </div>
                <Separator />
                <div className="space-y-2">
                    {selectedPurchase.products.map((item, index) => (
                        <div key={index} className="flex justify-between">
                            <span>{item.quantity}x {item.name}</span>
                            <span>₦{(item.quantity * item.price).toFixed(2)}</span>
                        </div>
                    ))}
                </div>
                <Separator />
                <div className="flex justify-between font-bold text-base">
                    <span>Total</span>
                    <span>₦{selectedPurchase.total.toFixed(2)}</span>
                </div>
                 <Separator />
                 <div className="text-center text-muted-foreground text-xs">
                    <p>Thank you for your purchase!</p>
                 </div>
            </div>
          )}
           <DialogFooter className="mt-4">
                <Button variant="outline" onClick={() => setIsReceiptOpen(false)}>Close</Button>
                <Button onClick={() => window.print()}>Print</Button>
            </DialogFooter>
        </DialogContent>
      </Dialog>

    </div>
  );

    

    