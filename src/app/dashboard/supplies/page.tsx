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
import { supplies as initialSupplies } from "@/lib/data";
import type { Supply } from "@/lib/types";
import { SupplyForm } from "./supply-form";

export default function SuppliesPage() {
  const [supplies, setSupplies] = useState<Supply[]>(initialSupplies);
  const [isFormOpen, setIsFormOpen] = useState(false);
  const [selectedSupply, setSelectedSupply] = useState<Supply | null>(null);

  const handleAddSupply = () => {
    setSelectedSupply(null);
    setIsFormOpen(true);
  };

  const handleFormSubmit = (values: Omit<Supply, 'id' | 'uniqueName'>) => {
    const newSupply: Supply = {
        id: `SUP${Date.now()}`,
        uniqueName: values.productName.toLowerCase().replace(/\s+/g, "-"),
        ...values
    }
    setSupplies([...supplies, newSupply]);
    setIsFormOpen(false);
  };

  return (
    <div className="flex flex-col gap-8">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-headline font-bold tracking-tight">
            Supplies
          </h1>
          <p className="text-muted-foreground">Track incoming product supplies.</p>
        </div>
        <Button onClick={handleAddSupply}>
          <PlusCircle className="mr-2 h-4 w-4" /> Add Supply
        </Button>
      </div>
      <Card>
        <CardHeader>
          <CardTitle>Supply Records</CardTitle>
          <CardDescription>
            A log of all supplies received from suppliers.
          </CardDescription>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Product Name</TableHead>
                <TableHead>Supplier</TableHead>
                <TableHead>Date</TableHead>
                <TableHead className="text-right">Quantity</TableHead>
                <TableHead>
                  <span className="sr-only">Actions</span>
                </TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {supplies.map((supply) => (
                <TableRow key={supply.id}>
                  <TableCell className="font-medium">
                    {supply.productName}
                  </TableCell>
                  <TableCell>{supply.supplier}</TableCell>
                  <TableCell>{new Date(supply.date).toLocaleDateString()}</TableCell>
                  <TableCell className="text-right">
                    {supply.quantity} {supply.quantityType}
                  </TableCell>
                  <TableCell>
                    <div className="flex justify-end">
                      <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                          <Button aria-haspopup="true" size="icon" variant="ghost">
                            <MoreHorizontal className="h-4 w-4" />
                            <span className="sr-only">Toggle menu</span>
                          </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                          <DropdownMenuLabel>Actions</DropdownMenuLabel>
                          <DropdownMenuItem>Edit</DropdownMenuItem>
                          <DropdownMenuItem>Delete</DropdownMenuItem>
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
        <DialogContent className="sm:max-w-md">
          <DialogHeader>
            <DialogTitle>
              {selectedSupply ? "Edit Supply" : "Add New Supply"}
            </DialogTitle>
          </DialogHeader>
          <SupplyForm
            onSubmit={handleFormSubmit}
            onCancel={() => setIsFormOpen(false)}
          />
        </DialogContent>
      </Dialog>
    </div>
  );
}
