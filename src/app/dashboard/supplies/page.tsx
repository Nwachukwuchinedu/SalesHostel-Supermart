
"use client";

import { useState, useMemo, useEffect } from "react";
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
  DialogDescription,
  DialogFooter,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { MoreHorizontal, PlusCircle, Search } from "lucide-react";
import type { Supply, SupplySummary } from "@/lib/types";
import { SupplyForm } from "./supply-form";
import { Separator } from "@/components/ui/separator";
import { useAuth } from "@/contexts/auth-context";
import { SupplyService } from "@/services/supply-service";
import { useToast } from "@/hooks/use-toast";
import { Badge } from "@/components/ui/badge";

export default function SuppliesPage() {
  const [supplies, setSupplies] = useState<SupplySummary[]>([]);
  const { user } = useAuth();
  const { toast } = useToast();
  const [loading, setLoading] = useState(true);
  const [isFormOpen, setIsFormOpen] = useState(false);
  const [selectedSupply, setSelectedSupply] = useState<Supply | null>(null);
  const [isAlertOpen, setIsAlertOpen] = useState(false);
  const [supplyToDelete, setSupplyToDelete] = useState<string | null>(null);
  const [isDetailsOpen, setIsDetailsOpen] = useState(false);
  const [searchTerm, setSearchTerm] = useState("");
  const [dateFilter, setDateFilter] = useState({ from: "", to: "" });

  useEffect(() => {
    const fetchSupplies = async () => {
      try {
        setLoading(true);
        const response = await SupplyService.getAllSupplies();
        setSupplies(response.data.map((s: any) => ({...s, id: s._id})));
      } catch (error) {
        toast({
          title: "Error",
          description: "Failed to fetch supplies.",
          variant: "destructive",
        });
      } finally {
        setLoading(false);
      }
    };
    fetchSupplies();
  }, [toast]);
  
  const canManageSupplies = user?.role === 'Admin' || user?.role === 'Staff';

  const handleAddSupply = () => {
    setSelectedSupply(null);
    setIsFormOpen(true);
  };
  
  const handleEditSupply = async (supplyId: string) => {
    try {
        const res = await SupplyService.getSupplyById(supplyId);
        setSelectedSupply({...res.data, id: res.data._id});
        setIsDetailsOpen(false);
        setIsFormOpen(true);
    } catch(err) {
        toast({ title: "Error", description: "Failed to fetch supply details.", variant: "destructive" });
    }
  };

  const handleViewDetails = async (supplyId: string) => {
    try {
        const res = await SupplyService.getSupplyById(supplyId);
        setSelectedSupply({...res.data, id: res.data._id});
        setIsDetailsOpen(true);
    } catch(err) {
        toast({ title: "Error", description: "Failed to fetch supply details.", variant: "destructive" });
    }
  };

  const handleDeleteClick = (supplyId: string) => {
    setSupplyToDelete(supplyId);
    setIsAlertOpen(true);
  }

  const handleDeleteConfirm = async () => {
    if (supplyToDelete) {
        try {
            await SupplyService.deleteSupply(supplyToDelete);
            setSupplies(supplies.filter((s) => s.id !== supplyToDelete));
            toast({ title: "Success", description: "Supply record deleted."});
        } catch (error) {
            toast({ title: "Error", description: "Failed to delete supply.", variant: "destructive" });
        }
    }
    setIsAlertOpen(false);
    setSupplyToDelete(null);
  }

  const handleFormSubmit = async () => {
    setIsFormOpen(false);
    setSelectedSupply(null);
    setLoading(true);
    try {
        const response = await SupplyService.getAllSupplies();
        setSupplies(response.data.map((s: any) => ({...s, id: s._id})));
    } catch (error) {
        toast({ title: "Error", description: "Failed to refresh supplies.", variant: "destructive"})
    } finally {
        setLoading(false);
    }
  };

  const filteredSupplies = useMemo(() => {
    return supplies.filter(supply => {
        const searchTermLower = searchTerm.toLowerCase();
        const matchesSearch = searchTerm ? 
            supply.supplyId.toLowerCase().includes(searchTermLower) || 
            (supply.supplierName && supply.supplierName.toLowerCase().includes(searchTermLower))
            : true;

        const fromDate = dateFilter.from ? new Date(dateFilter.from) : null;
        const toDate = dateFilter.to ? new Date(dateFilter.to) : null;
        const supplyDate = new Date(supply.updatedAt);
        
        if(fromDate) fromDate.setHours(0,0,0,0);
        if(toDate) toDate.setHours(23,59,59,999);

        const matchesDate = 
            (!fromDate || supplyDate >= fromDate) &&
            (!toDate || supplyDate <= toDate);

        return matchesSearch && matchesDate;
    })
  }, [supplies, searchTerm, dateFilter]);
  
  if (user === null || loading) {
      return <div>Loading...</div>
  }

  return (
    <div className="flex flex-col gap-8 min-w-0">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-headline font-bold tracking-tight">
            Supplies
          </h1>
          <p className="text-muted-foreground">Track incoming product supplies.</p>
        </div>
        {(canManageSupplies || user?.role === 'Supplier') && (
            <Button onClick={handleAddSupply}>
                <PlusCircle className="mr-2 h-4 w-4" /> Add Supply
            </Button>
        )}
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
                placeholder="Search by ID, supplier..."
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
                    <TableHead>Status</TableHead>
                    <TableHead>Date</TableHead>
                    <TableHead className="text-right">Total Amount</TableHead>
                    <TableHead>
                    <span className="sr-only">Actions</span>
                    </TableHead>
                </TableRow>
                </TableHeader>
                <TableBody>
                {filteredSupplies.map((supply) => (
                    <TableRow key={supply.id}>
                    <TableCell className="font-medium">
                        {supply.supplyId}
                    </TableCell>
                    <TableCell>{supply.supplierName || "N/A"}</TableCell>
                    <TableCell>
                        <Badge variant={supply.paymentStatus === 'Paid' ? 'default' : 'secondary'}
                            className={
                                supply.paymentStatus === 'Paid' ? 'bg-green-500/20 text-green-700 hover:bg-green-500/30' :
                                supply.paymentStatus === 'Pending' ? 'bg-yellow-500/20 text-yellow-700 hover:bg-yellow-500/30' :
                                'bg-gray-500/20 text-gray-700 hover:bg-gray-500/30'
                            }>
                            {supply.paymentStatus}
                        </Badge>
                    </TableCell>
                    <TableCell>{new Date(supply.updatedAt).toLocaleDateString()}</TableCell>
                    <TableCell className="text-right">
                        ₦{(supply.totalAmount || 0).toFixed(2)}
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
                            <DropdownMenuItem onSelect={() => handleViewDetails(supply.id)}>View Details</DropdownMenuItem>
                            {(canManageSupplies || user?._id === supply.supplier?._id) && (
                                <DropdownMenuItem onSelect={() => handleEditSupply(supply.id)}>Edit</DropdownMenuItem>
                            )}
                            {canManageSupplies && (
                                <DropdownMenuItem onSelect={() => handleDeleteClick(supply.id)} className="text-red-600">Delete</DropdownMenuItem>
                            )}
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
              Details for supply ID: {selectedSupply?.supplyId}
            </DialogDescription>
          </DialogHeader>
          {selectedSupply && (
            <div className="space-y-4">
              <div><strong>Supplier:</strong> {selectedSupply.supplier?.name || (selectedSupply as any).supplierName || 'N/A'}</div>
              <div><strong>Date:</strong> {new Date(selectedSupply.date).toLocaleDateString()}</div>
              <div><strong>Status:</strong> {selectedSupply.paymentStatus}</div>
              <Separator />
              <h4 className="font-semibold">Products Supplied</h4>
              <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Product</TableHead>
                        <TableHead>Quantity</TableHead>
                        <TableHead className="text-right">Cost</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {selectedSupply.products.map((p, i) => (
                        <TableRow key={i}>
                            <TableCell>{p.productName}</TableCell>
                            <TableCell>{p.quantity} {p.quantityType}</TableCell>
                            <TableCell className="text-right">₦{p.totalCost?.toFixed(2) || 'N/A'}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
              </Table>
              <Separator />
              <div className="text-right font-bold text-lg">
                Total Amount: ₦{(selectedSupply.totalAmount || 0).toFixed(2)}
              </div>
            </div>
          )}
          <DialogFooter>
            <Button variant="outline" onClick={() => setIsDetailsOpen(false)}>Close</Button>
            {(canManageSupplies || user?._id === selectedSupply?.supplier?._id) && selectedSupply && (
              <Button onClick={() => handleEditSupply(selectedSupply!.id)}>Edit</Button>
            )}
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
