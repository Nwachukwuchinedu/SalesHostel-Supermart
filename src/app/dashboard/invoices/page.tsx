
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
import { Dialog, DialogContent, DialogHeader, DialogTitle } from "@/components/ui/dialog";
import { MoreHorizontal, PlusCircle } from "lucide-react";
import { invoices as initialInvoices } from "@/lib/data";
import { Badge } from "@/components/ui/badge";
import type { Invoice, UserRole } from "@/lib/types";
import { InvoiceForm } from "./invoice-form";

export default function InvoicesPage() {
  const [invoices, setInvoices] = useState<Invoice[]>(initialInvoices);
  const [userRole, setUserRole] = useState<UserRole | null>(null);
  const [userName, setUserName] = useState<string | null>(null);
  const [isFormOpen, setIsFormOpen] = useState(false);
  const [selectedInvoice, setSelectedInvoice] = useState<Invoice | null>(null);

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
  }

  const handleFormSubmit = (invoice: Invoice) => {
    if (selectedInvoice) {
      setInvoices(invoices.map(i => i.id === invoice.id ? invoice : i));
    } else {
      setInvoices([invoice, ...invoices]);
    }
    setIsFormOpen(false);
  }

  const filteredInvoices =
    userRole === "Customer"
      ? invoices.filter((invoice) => invoice.customerName === userName)
      : invoices;
  
  if (userRole === null) {
    return <div>Loading...</div>;
  }

  return (
    <div className="flex flex-col gap-8">
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
                    {canManageInvoices && <TableCell>{invoice.customerName}</TableCell>}
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
                            <DropdownMenuItem>View Invoice</DropdownMenuItem>
                            {canManageInvoices && (
                                <>
                                <DropdownMenuItem>Mark as Paid</DropdownMenuItem>
                                <DropdownMenuItem>Send Reminder</DropdownMenuItem>
                                </>
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
        <DialogContent>
            <DialogHeader>
                <DialogTitle>{selectedInvoice ? "Edit Invoice" : "Create Invoice"}</DialogTitle>
            </DialogHeader>
            <InvoiceForm
                initialData={selectedInvoice}
                onSubmit={handleFormSubmit}
                onCancel={() => setIsFormOpen(false)}
            />
        </DialogContent>
      </Dialog>
    </div>
  );
}
