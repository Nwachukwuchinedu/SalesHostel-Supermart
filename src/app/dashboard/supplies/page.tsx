

"use client";

import { useState, useMemo } from "react";
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
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from "@/components/ui/alert-dialog";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogDescription
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { MoreHorizontal, PlusCircle, Search } from "lucide-react";
import { supplies as initialSupplies } from "@/lib/data";
import type { Supply } from "@/lib/types";
import { SupplyForm } from "./supply-form";
import { Separator } from "@/components/ui/separator";

export default function SuppliesPage() {
  const [supplies, setSupplies] = useState<Supply[]>(initialSupplies);
  const [isFormOpen, setIsFormOpen] = useState(false);
  const [selectedSupply, setSelectedSupply] = useState<Supply | null>(null);
  const [isAlertOpen, setIsAlertOpen] = useState(false);
  const [supplyToDelete, setSupplyToDelete] = useState<string | null>(null);
  const [isDetailsOpen, setIsDetailsOpen] = useState(false);
  const [searchTerm, setSearchTerm] = useState("");
  const [dateFilter, setDateFilter] = useState({ from: "", to: "" });

  const handleAddSupply = () => {
    setSelectedSupply(null);
    setIsFormOpen(true);
  };
  
  const handleEditSupply = (supply: Supply) => {
    setSelectedSupply(supply);
    setIsDetailsOpen(false);
    setIsFormOpen(true);
  };

  const handleViewDetails = (supply: Supply) => {
    setSelectedSupply(supply);
    setIsDetailsOpen(true);
  };

  const handleDeleteClick = (supplyId: string) => {
    setSupplyToDelete(supplyId);
    setIsAlertOpen(true);
  }

  const handleDeleteConfirm = () => {
    if (supplyToDelete) {
        setSupplies(supplies.filter((s) => s.id !== supplyToDelete));
    }
    setIsAlertOpen(false);
    setSupplyToDelete(null);
  }

  const handleFormSubmit = (values: Supply) => {
    if(selectedSupply && supplies.find(s => s.id === values.id)) {
        // Update existing supply
        setSupplies(supplies.map(s => s.id === values.id ? values : s))
    } else {
        // Add new supply
        setSupplies([values, ...supplies]);
    }
    setIsFormOpen(false);
    setSelectedSupply(null);
  };

  const filteredSupplies = useMemo(() => {
    return supplies.filter(supply => {
        const searchTermLower = searchTerm.toLowerCase();
        const matchesSearch = searchTerm ? 
            supply.id.toLowerCase().includes(searchTermLower) || 
            supply.supplier.toLowerCase().includes(searchTermLower) ||
            supply.products.some(p => p.productName.toLowerCase().includes(searchTermLower))
            : true;

        const fromDate = dateFilter.from ? new Date(dateFilter.from) : null;
        const toDate = dateFilter.to ? new Date(dateFilter.to) : null;
        const supplyDate = new Date(supply.date);
        
        if(fromDate) fromDate.setHours(0,0,0,0);
        if(toDate) toDate.setHours(23,59,59,999);

        const matchesDate = 
            (!fromDate || supplyDate >= fromDate) &&
            (!toDate || supplyDate <= toDate);

        return matchesSearch && matchesDate;
    })
  }, [supplies, searchTerm, dateFilter]);

  return (
    <div className="flex flex-col gap-8 min-w-0">
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
          <div className="grid md:grid-cols-3 gap-4 mt-4">
            <div className="relative">
                <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                <Input
                type="search"
                placeholder="Search by ID, supplier, product..."
                className="w-full rounded-lg bg-background pl-8"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                />
            </div>
            <Input 
                type="date"
                value={dateFilter.from}
                onChange={e => setDateFilter(prev => ({ ...prev, from: e.target.value }))}
                placeholder="From Date"
            />
            <Input 
                type="date"
                value={dateFilter.to}
                onChange={e => setDateFilter(prev => ({ ...prev, to: e.target.value }))}
                placeholder="To Date"
            />
          </div>
        </CardHeader>
        <CardContent className="pt-0">
            <Table>
                <TableHeader>
                <TableRow>
                    <TableHead>Supply ID</TableHead>
                    <TableHead>Supplier</TableHead>
                    <TableHead>Date</TableHead>
                    <TableHead className="text-right">Total Items</TableHead>
                    <TableHead>
                    <span className="sr-only">Actions</span>
                    </TableHead>
                </TableRow>
                </TableHeader>
                <TableBody>
                {filteredSupplies.map((supply) => (
                    <TableRow key={supply.id}>
                    <TableCell className="font-medium">
                        {supply.id}
                    </TableCell>
                    <TableCell>{supply.supplier}</TableCell>
                    <TableCell>{new Date(supply.date).toLocaleDateString()}</TableCell>
                    <TableCell className="text-right">
                        {supply.totalItems}
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
                            <DropdownMenuItem onSelect={() => handleViewDetails(supply)}>View Details</DropdownMenuItem>
                            <DropdownMenuItem onSelect={() => handleEditSupply(supply)}>Edit</DropdownMenuItem>
                            <DropdownMenuItem onSelect={() => handleDeleteClick(supply.id)} className="text-red-600">Delete</DropdownMenuItem>
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
        <DialogContent className="sm:max-w-3xl max-w-[calc(100vw-2rem)]">
          <DialogHeader>
            <DialogTitle>
              {selectedSupply ? "Edit Supply" : "Add New Supply"}
            </DialogTitle>
          </DialogHeader>
          <SupplyForm
            initialData={selectedSupply}
            onSubmit={handleFormSubmit}
            onCancel={() => setIsFormOpen(false)}
          />
        </DialogContent>
      </Dialog>
      
      <Dialog open={isDetailsOpen} onOpenChange={setIsDetailsOpen}>
        <DialogContent className="max-w-[calc(100vw-2rem)]">
          <DialogHeader>
            <DialogTitle>Supply Details</DialogTitle>
            <DialogDescription>
              Details for supply ID: {selectedSupply?.id}
            </DialogDescription>
          </DialogHeader>
          {selectedSupply && (
            <div className="space-y-4">
              <div><strong>Supplier:</strong> {selectedSupply.supplier}</div>
              <div><strong>Date:</strong> {new Date(selectedSupply.date).toLocaleDateString()}</div>
              <Separator />
              <h4 className="font-semibold">Products Supplied</h4>
              <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Product</TableHead>
                        <TableHead className="text-right">Quantity</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {selectedSupply.products.map((p, i) => (
                        <TableRow key={i}>
                            <TableCell>{p.productName}</TableCell>
                            <TableCell className="text-right">{p.quantity} {p.quantityType}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
              </Table>
              <Separator />
              <div className="text-right font-bold text-lg">
                Total Items: {selectedSupply.totalItems}
              </div>
            </div>
          )}
          <DialogFooter>
            <Button variant="outline" onClick={() => setIsDetailsOpen(false)}>Close</Button>
            <Button onClick={() => handleEditSupply(selectedSupply!)}>Edit</Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>

      <AlertDialog open={isAlertOpen} onOpenChange={setIsAlertOpen}>
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                <AlertDialogDescription>
                    This action cannot be undone. This will permanently delete this supply record.
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

    
