
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
} from "@/components/ui/dialog";
import { MoreHorizontal, PlusCircle } from "lucide-react";
import { purchases as initialPurchases } from "@/lib/data";
import { Badge } from "@/components/ui/badge";
import type { Purchase } from "@/lib/types";
import { PurchaseForm } from "./purchase-form";

export default function PurchasesPage() {
  const [purchases, setPurchases] = useState<Purchase[]>(initialPurchases);
  const [isFormOpen, setIsFormOpen] = useState(false);

  const handleFormSubmit = (newPurchase: Purchase) => {
    setPurchases([newPurchase, ...purchases]);
    setIsFormOpen(false);
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
        <Button onClick={() => setIsFormOpen(true)}>
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
        <CardContent>
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
                            <DropdownMenuItem>View Details</DropdownMenuItem>
                            <DropdownMenuItem>View Receipt</DropdownMenuItem>
                            <DropdownMenuItem>Mark as Paid</DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                        </div>
                    </TableCell>
                    </TableRow>
                ))}
                </TableBody>
            </Table>
        </CardContent>
      </Card>

      <Dialog open={isFormOpen} onOpenChange={setIsFormOpen}>
        <DialogContent className="sm:max-w-3xl">
          <DialogHeader>
            <DialogTitle>Create New Purchase</DialogTitle>
          </DialogHeader>
          <PurchaseForm
            onSubmit={handleFormSubmit}
            onCancel={() => setIsFormOpen(false)}
          />
        </DialogContent>
      </Dialog>
    </div>
  );
}
