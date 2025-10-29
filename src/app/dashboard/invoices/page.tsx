
"use client";

import { useState, useEffect } from "react";
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
  DialogFooter,
  DialogDescription,
} from "@/components/ui/dialog";
import { MoreHorizontal, PlusCircle } from "lucide-react";
import { invoices as initialInvoices, purchases } from "@/lib/data";
import { Badge } from "@/components/ui/badge";
import type { Invoice, UserRole, Purchase } from "@/lib/types";
import { InvoiceForm } from "./invoice-form";
import { Separator } from "@/components/ui/separator";

export default function InvoicesPage() {
  const [invoices, setInvoices] = useState<Invoice[]>(initialInvoices);
  const [userRole, setUserRole] = useState<UserRole | null>(null);
  const [userName, setUserName] = useState<string | null>(null);
  const [isFormOpen, setIsFormOpen] = useState(false);
  const [selectedInvoice, setSelectedInvoice] = useState<Invoice | null>(null);
  const [isDetailsOpen, setIsDetailsOpen] = useState(false);
  const [isReceiptOpen, setIsReceiptOpen] = useState(false);

  useEffect(() => {
    const role = localStorage.getItem("userRole") as UserRole;
    const name = localStorage.getItem("userName");
    setUserRole(role || "Customer");
    setUserName(name || "Customer User");
  }, []);

  const canManageInvoices = userRole === "Admin" || userRole === "Staff";

  const handleCreateInvoice = () => {
    setSelectedInvoice(null);
    setIsFormOpen(true);
  };

  const handleEditInvoice = (invoice: Invoice) => {
    setSelectedInvoice(invoice);
    setIsDetailsOpen(false);
    setIsFormOpen(true);
  };

  const handleFormSubmit = (invoice: Invoice) => {
    if (selectedInvoice && invoices.find(i => i.id === invoice.id)) {
      setInvoices(invoices.map((i) => (i.id === invoice.id ? invoice : i)));
    } else {
      setInvoices([invoice, ...invoices]);
    }
    setIsFormOpen(false);
    setSelectedInvoice(null);
  };
  
  const handleMarkAsPaid = (invoiceId: string) => {
    setInvoices(invoices.map(i => i.id === invoiceId ? {...i, status: 'Paid'} : i));
  }
  
  const handleMarkAsUnpaid = (invoiceId: string) => {
    setInvoices(invoices.map(i => i.id === invoiceId ? {...i, status: 'Unpaid'} : i));
  }

  const handleViewDetails = (invoice: Invoice) => {
    const purchase = purchases.find(p => p.id === invoice.purchaseId);
    setSelectedInvoice({...invoice, purchase});
    setIsDetailsOpen(true);
  }

  const handleViewReceipt = (invoice: Invoice) => {
     const purchase = purchases.find(p => p.id === invoice.purchaseId);
    setSelectedInvoice({...invoice, purchase});
    setIsReceiptOpen(true);
  }

  const filteredInvoices =
    userRole === "Customer"
      ? invoices.filter((invoice) => invoice.customerName === userName)
      : invoices;

  if (userRole === null) {
    return <div>Loading...</div>;
  }

  return (
    <div className="flex flex-col gap-8 min-w-0">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-headline font-bold tracking-tight">
            Invoices
          </h1>
          <p className="text-muted-foreground">Manage and track invoices.</p>
        </div>
        {canManageInvoices && (
          <Button onClick={handleCreateInvoice}>
            <PlusCircle className="mr-2 h-4 w-4" /> Create Invoice
          </Button>
        )}
      </div>
      <Card>
        <CardHeader>
          <CardTitle>Invoice List</CardTitle>
          <CardDescription>
            A list of all {canManageInvoices ? "" : "your"} generated invoices.
          </CardDescription>
        </CardHeader>
        <CardContent className="pt-0">
          <div className="overflow-auto max-h-[60vh]">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Invoice ID</TableHead>
                  {canManageInvoices && <TableHead>Customer</TableHead>}
                  <TableHead>Status</TableHead>
                  <TableHead>Issue Date</TableHead>
                  <TableHead>Due Date</TableHead>
                  <TableHead className="text-right">Amount</TableHead>
                  <TableHead>
                    <span className="sr-only">Actions</span>
                  </TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {filteredInvoices.map((invoice) => (
                  <TableRow key={invoice.id}>
                    <TableCell className="font-medium">{invoice.id}</TableCell>
                    {canManageInvoices && (
                      <TableCell>{invoice.customerName}</TableCell>
                    )}
                    <TableCell>
                      <Badge
                        variant={
                          invoice.status === "Paid"
                            ? "default"
                            : invoice.status === "Unpaid"
                            ? "secondary"
                            : "destructive"
                        }
                        className={
                          invoice.status === "Paid"
                            ? "bg-green-500/20 text-green-700 hover:bg-green-500/30"
                            : invoice.status === "Unpaid"
                            ? "bg-yellow-500/20 text-yellow-700 hover:bg-yellow-500/30"
                            : "bg-red-500/20 text-red-700 hover:bg-red-500/30"
                        }
                      >
                        {invoice.status}
                      </Badge>
                    </TableCell>
                    <TableCell>
                      {new Date(invoice.issueDate).toLocaleDateString()}
                    </TableCell>
                    <TableCell>
                      {new Date(invoice.dueDate).toLocaleDateString()}
                    </TableCell>
                    <TableCell className="text-right">
                      ${invoice.amount.toFixed(2)}
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
                            <DropdownMenuItem onSelect={() => handleViewDetails(invoice)}>View Invoice</DropdownMenuItem>
                             <DropdownMenuItem onSelect={() => handleViewReceipt(invoice)}>View Receipt</DropdownMenuItem>
                            {canManageInvoices && (
                              invoice.status === 'Paid' ? (
                                <DropdownMenuItem onSelect={() => handleMarkAsUnpaid(invoice.id)}>Mark as Unpaid</DropdownMenuItem>
                              ) : (
                                <DropdownMenuItem onSelect={() => handleMarkAsPaid(invoice.id)}>Mark as Paid</DropdownMenuItem>
                              )
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
        <DialogContent className="max-w-[calc(100vw-2rem)]">
          <DialogHeader>
            <DialogTitle>
              {selectedInvoice ? "Edit Invoice" : "Create Invoice"}
            </DialogTitle>
          </DialogHeader>
          <InvoiceForm
            initialData={selectedInvoice}
            onSubmit={handleFormSubmit}
            onCancel={() => setIsFormOpen(false)}
          />
        </DialogContent>
      </Dialog>

      <Dialog open={isDetailsOpen} onOpenChange={setIsDetailsOpen}>
        <DialogContent className="max-w-[calc(100vw-2rem)]">
            <DialogHeader>
                <DialogTitle>Invoice Details</DialogTitle>
                <DialogDescription>
                    Details for invoice ID: {selectedInvoice?.id}
                </DialogDescription>
            </DialogHeader>
            {selectedInvoice && (
                 <div className="space-y-4 text-sm">
                    <div className="grid grid-cols-2">
                        <div><strong>Customer:</strong> {selectedInvoice.customerName}</div>
                        <div className="text-right"><strong>Issue Date:</strong> {new Date(selectedInvoice.issueDate).toLocaleDateString()}</div>
                    </div>
                    <div className="grid grid-cols-2">
                        <div><strong>Status:</strong> {selectedInvoice.status}</div>
                        <div className="text-right"><strong>Due Date:</strong> {new Date(selectedInvoice.dueDate).toLocaleDateString()}</div>
                    </div>
                    <Separator />
                    <h4 className="font-semibold">Billed Items</h4>
                    {selectedInvoice.purchase ? (
                        <>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Product</TableHead>
                                    <TableHead>Quantity</TableHead>
                                    <TableHead className="text-right">Price</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {selectedInvoice.purchase.products.map((p, i) => (
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
                            Total: ${selectedInvoice.amount.toFixed(2)}
                        </div>
                        </>
                    ) : (
                        <p>Purchase details not available.</p>
                    )}
                 </div>
            )}
             <DialogFooter>
                <Button variant="outline" onClick={() => setIsDetailsOpen(false)}>Close</Button>
                {canManageInvoices && (
                  <Button onClick={() => handleEditInvoice(selectedInvoice!)}>Edit</Button>
                )}
            </DialogFooter>
        </DialogContent>
      </Dialog>
      
      <Dialog open={isReceiptOpen} onOpenChange={setIsReceiptOpen}>
        <DialogContent className="max-w-[calc(100vw-2rem)]">
          <DialogHeader>
            <DialogTitle>Receipt</DialogTitle>
          </DialogHeader>
          {selectedInvoice?.purchase && (
            <div className="space-y-6 text-sm">
                <div className="text-center">
                    <h3 className="font-bold text-lg font-headline">SalesHostel Digital</h3>
                    <p className="text-muted-foreground">123 Market St, San Francisco, CA</p>
                </div>
                <Separator />
                <div className="grid grid-cols-2 gap-2">
                    <div><strong>Receipt For:</strong> {selectedInvoice.customerName}</div>
                    <div className="text-right"><strong>Date:</strong> {new Date(selectedInvoice.purchase.date).toLocaleDateString()}</div>
                    <div><strong>Receipt ID:</strong> {selectedInvoice.purchase.id}</div>
                </div>
                <Separator />
                <div className="space-y-2">
                    {selectedInvoice.purchase.products.map((item, index) => (
                        <div key={index} className="flex justify-between">
                            <span>{item.quantity}x {item.name}</span>
                            <span>${(item.quantity * item.price).toFixed(2)}</span>
                        </div>
                    ))}
                </div>
                <Separator />
                <div className="flex justify-between font-bold text-base">
                    <span>Total</span>
                    <span>${selectedInvoice.purchase.total.toFixed(2)}</span>
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

    

    