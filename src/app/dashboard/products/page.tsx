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
  DialogFooter,
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
import { MoreHorizontal, PlusCircle, Search, Tags, Text, Trash2, Edit } from "lucide-react";
import { ProductForm } from "./product-form";
import type { Product, UserRole, Group, UniqueName } from "@/lib/types";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { ScrollArea } from "@/components/ui/scroll-area";
import { Label } from "@/components/ui/label";
import { useAuth } from "@/contexts/auth-context";
import { ProductService } from "@/services/product-service";
import { GroupService } from "@/services/group-service";
import { UniqueNameService } from "@/services/unique-name-service";
import { useToast } from "@/hooks/use-toast";


export default function ProductsPage() {
  const [products, setProducts] = useState<Product[]>([]);
  const { user } = useAuth();
  const { toast } = useToast();
  const [searchTerm, setSearchTerm] = useState("");
  const [isFormOpen, setIsFormOpen] = useState(false);
  const [selectedProduct, setSelectedProduct] = useState<Product | null>(null);
  
  const [groups, setGroups] = useState<Group[]>([]);
  const [uniqueNames, setUniqueNames] = useState<UniqueName[]>([]);
  const [newGroup, setNewGroup] = useState("");
  const [newUniqueName, setNewUniqueName] = useState("");

  const [isDeleteAlertOpen, setIsDeleteAlertOpen] = useState(false);
  const [itemToDelete, setItemToDelete] = useState<{ type: 'group' | 'uniqueName' | 'product'; id: string, value: string } | null>(null);

  const [isEditModalOpen, setIsEditModalOpen] = useState(false);
  const [itemToEdit, setItemToEdit] = useState<{ type: 'group' | 'uniqueName'; id: string, value: string } | null>(null);
  const [editValue, setEditValue] = useState("");
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        const [productsData, groupsData, uniqueNamesData] = await Promise.all([
          ProductService.getAllProducts(),
          GroupService.getAllGroups(),
          UniqueNameService.getAllUniqueNames(),
        ]);
        setProducts(productsData.data.map((p: any) => ({...p, id: p._id})));
        setGroups(groupsData.data.map((g: any) => ({...g, id: g._id})));
        setUniqueNames(uniqueNamesData.data.map((u: any) => ({...u, id: u._id})));
      } catch (error) {
        toast({
            title: "Error",
            description: "Failed to fetch data. Please try again.",
            variant: "destructive",
        })
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, [toast]);

  const canManageProducts = user?.role === "Admin";

  const handleAddProduct = () => {
    setSelectedProduct(null);
    setIsFormOpen(true);
  };

  const handleEditProduct = (product: Product) => {
    setSelectedProduct(product);
    setIsFormOpen(true);
  };

  const handleDeleteProductClick = (productId: string) => {
    const product = products.find(p => p.id === productId);
    if(product) {
      setItemToDelete({ type: 'product', id: productId, value: product.name });
      setIsDeleteAlertOpen(true);
    }
  }

  const handleFormSubmit = async (values: Omit<Product, 'id' | '_id'>) => {
    try {
      if (selectedProduct) {
        const updatedProduct = await ProductService.updateProduct(selectedProduct.id, values);
        setProducts(
          products.map((p) => (p.id === selectedProduct.id ? {...updatedProduct.data, id: updatedProduct.data._id} : p))
        );
        toast({ title: "Success", description: "Product updated successfully." });
      } else {
        const newProduct = await ProductService.createProduct(values);
        setProducts([{...newProduct.data, id: newProduct.data._id}, ...products]);
        toast({ title: "Success", description: "Product created successfully." });
      }
      setIsFormOpen(false);
      setSelectedProduct(null);
    } catch(error) {
      toast({ title: "Error", description: `Failed to ${selectedProduct ? 'update' : 'create'} product.`, variant: "destructive" });
    }
  };

  const filteredProducts = useMemo(() => {
    if (!searchTerm) return products;
    return products.filter(
      (product) =>
        product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
        product.uniqueName.toLowerCase().includes(searchTerm.toLowerCase()) ||
        product.group.toLowerCase().includes(searchTerm.toLowerCase()) ||
        product.tags.some((tag) =>
          tag.toLowerCase().includes(searchTerm.toLowerCase())
        )
    );
  }, [products, searchTerm]);

  const handleAddNewGroup = async (e: React.FormEvent) => {
    e.preventDefault();
    if (newGroup && !groups.find(g => g.name === newGroup)) {
      try {
        const newGroupData = await GroupService.createGroup({ name: newGroup });
        setGroups([...groups, {...newGroupData.data, id: newGroupData.data._id}]);
        setNewGroup("");
        toast({ title: "Success", description: "Group added successfully." });
      } catch (error) {
        toast({ title: "Error", description: "Failed to add group.", variant: "destructive" });
      }
    }
  }

  const handleAddNewUniqueName = async (e: React.FormEvent) => {
    e.preventDefault();
    if (newUniqueName && !uniqueNames.find(u => u.name === newUniqueName)) {
      try {
        const newUniqueNameData = await UniqueNameService.createUniqueName({ name: newUniqueName });
        setUniqueNames([...uniqueNames, {...newUniqueNameData.data, id: newUniqueNameData.data._id}]);
        setNewUniqueName("");
        toast({ title: "Success", description: "Unique name added successfully." });
      } catch (error) {
         toast({ title: "Error", description: "Failed to add unique name.", variant: "destructive" });
      }
    }
  }

  const handleDeleteItemClick = (type: 'group' | 'uniqueName', id: string, value: string) => {
    setItemToDelete({ type, id, value });
    setIsDeleteAlertOpen(true);
  };
  
  const handleDeleteConfirm = async () => {
    if (!itemToDelete) return;
  
    const { type, id } = itemToDelete;
    
    try {
        if (type === 'group') {
            await GroupService.deleteGroup(id);
            setGroups(groups.filter(g => g.id !== id));
            setProducts(products.filter(p => p.group !== itemToDelete.value));
            toast({ title: "Success", description: "Group deleted successfully." });
        } else if (type === 'uniqueName') {
            await UniqueNameService.deleteUniqueName(id);
            setUniqueNames(uniqueNames.filter(u => u.id !== id));
            setProducts(products.filter(p => p.uniqueName !== itemToDelete.value));
            toast({ title: "Success", description: "Unique name deleted successfully." });
        } else if (type === 'product') {
            await ProductService.deleteProduct(id);
            setProducts(products.filter(p => p.id !== id));
            toast({ title: "Success", description: "Product deleted successfully." });
        }
    } catch(error) {
        toast({ title: "Error", description: `Failed to delete ${type}.`, variant: "destructive" });
    }
  
    setIsDeleteAlertOpen(false);
    setItemToDelete(null);
  };
  
  const handleEditItemClick = (type: 'group' | 'uniqueName', id: string, value: string) => {
    setItemToEdit({ type, id, value });
    setEditValue(value);
    setIsEditModalOpen(true);
  };

  const handleEditConfirm = async () => {
    if (!itemToEdit || !editValue) return;

    const { type, id, value: oldValue } = itemToEdit;

    try {
        if (type === 'group') {
            const updatedGroup = await GroupService.updateGroup(id, { name: editValue });
            setGroups(groups.map(g => g.id === id ? {...updatedGroup.data, id: updatedGroup.data._id } : g));
            setProducts(products.map(p => p.group === oldValue ? { ...p, group: editValue } : p));
            toast({ title: "Success", description: "Group updated successfully." });
        } else if (type === 'uniqueName') {
            const updatedUniqueName = await UniqueNameService.updateUniqueName(id, { name: editValue });
            setUniqueNames(uniqueNames.map(u => u.id === id ? {...updatedUniqueName.data, id: updatedUniqueName.data._id} : u));
            setProducts(products.map(p => p.uniqueName === oldValue ? { ...p, uniqueName: editValue } : p));
            toast({ title: "Success", description: "Unique name updated successfully." });
        }
    } catch(error) {
         toast({ title: "Error", description: `Failed to update ${type}.`, variant: "destructive" });
    }
    
    setIsEditModalOpen(false);
    setItemToEdit(null);
    setEditValue("");
  };

  if (user === null || loading) {
      return <div>Loading...</div>
  }

  return (
    <div className="flex flex-col gap-8 min-w-0">
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
        <CardContent className="pt-0">
            <div className="overflow-x-auto">
                <Table>
                    <TableHeader>
                    <TableRow>
                        <TableHead className="w-[80px]">Image</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Group</TableHead>
                        <TableHead>Stock</TableHead>
                        <TableHead className="text-right">Price</TableHead>
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
                        <TableCell>
                            <Avatar className="h-9 w-9">
                                <AvatarImage src={product.imageUrl || product.images?.[0]} alt={product.name}/>
                                <AvatarFallback>{product.name.charAt(0)}</AvatarFallback>
                            </Avatar>
                        </TableCell>
                        <TableCell className="font-medium">{product.name}</TableCell>
                        <TableCell>{product.group}</TableCell>
                        <TableCell>{product.quantityAvailable} {product.quantityUnit}</TableCell>
                        <TableCell className="text-right">₦{product.sellingPrice.toFixed(2)}</TableCell>
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
                                    <DropdownMenuItem onSelect={() => handleDeleteProductClick(product.id)}>
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
      
      {canManageProducts && (
        <div className="grid md:grid-cols-2 gap-8">
            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><Text className="h-5 w-5" /> Unique Names</CardTitle>
                    <CardDescription>Manage the unique names for product selection.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form onSubmit={handleAddNewUniqueName} className="flex gap-2 mb-4">
                        <Input 
                            value={newUniqueName}
                            onChange={(e) => setNewUniqueName(e.target.value)}
                            placeholder="Add new unique name"
                        />
                        <Button type="submit">Add</Button>
                    </form>
                    <ScrollArea className="h-40">
                        <div className="flex flex-col gap-2">
                            {uniqueNames.map(name => (
                                <div key={name.id} className="flex items-center justify-between p-2 rounded-md border group">
                                    <span>{name.name}</span>
                                    <DropdownMenu>
                                        <DropdownMenuTrigger asChild>
                                            <Button variant="ghost" size="icon" className="h-6 w-6 opacity-0 group-hover:opacity-100">
                                                <MoreHorizontal className="h-4 w-4" />
                                            </Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent>
                                            <DropdownMenuItem onSelect={() => handleEditItemClick('uniqueName', name.id, name.name)}>
                                                <Edit className="mr-2 h-4 w-4" /> Edit
                                            </DropdownMenuItem>
                                            <DropdownMenuItem onSelect={() => handleDeleteItemClick('uniqueName', name.id, name.name)} className="text-red-600">
                                                <Trash2 className="mr-2 h-4 w-4" /> Delete
                                            </DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </div>
                            ))}
                        </div>
                    </ScrollArea>
                </CardContent>
            </Card>
            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><Tags className="h-5 w-5" /> Groups</CardTitle>
                    <CardDescription>Manage the groups for product categorization.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form onSubmit={handleAddNewGroup} className="flex gap-2 mb-4">
                        <Input 
                            value={newGroup}
                            onChange={(e) => setNewGroup(e.target.value)}
                            placeholder="Add new group"
                        />
                        <Button type="submit">Add</Button>
                    </form>
                    <ScrollArea className="h-40">
                        <div className="flex flex-col gap-2">
                            {groups.map(group => (
                                 <div key={group.id} className="flex items-center justify-between p-2 rounded-md border group">
                                    <span>{group.name}</span>
                                    <DropdownMenu>
                                        <DropdownMenuTrigger asChild>
                                            <Button variant="ghost" size="icon" className="h-6 w-6 opacity-0 group-hover:opacity-100">
                                                <MoreHorizontal className="h-4 w-4" />
                                            </Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent>
                                            <DropdownMenuItem onSelect={() => handleEditItemClick('group', group.id, group.name)}>
                                                <Edit className="mr-2 h-4 w-4" /> Edit
                                            </DropdownMenuItem>
                                            <DropdownMenuItem onSelect={() => handleDeleteItemClick('group', group.id, group.name)} className="text-red-600">
                                                <Trash2 className="mr-2 h-4 w-4" /> Delete
                                            </DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </div>
                            ))}
                        </div>
                    </ScrollArea>
                </CardContent>
            </Card>
        </div>
      )}


      <Dialog open={isFormOpen} onOpenChange={setIsFormOpen}>
        <DialogContent className="sm:max-w-lg max-w-[calc(100vw-2rem)]">
          <DialogHeader>
            <DialogTitle>
              {selectedProduct ? "Edit Product" : "Add New Product"}
            </DialogTitle>
          </DialogHeader>
          <ScrollArea className="max-h-[70vh]">
            <div className="p-6">
              <ProductForm
                initialData={selectedProduct}
                onSubmit={handleFormSubmit}
                onCancel={() => setIsFormOpen(false)}
                groups={groups.map(g => g.name)}
                uniqueNames={uniqueNames.map(u => u.name)}
              />
            </div>
          </ScrollArea>
        </DialogContent>
      </Dialog>
      
      <Dialog open={isEditModalOpen} onOpenChange={setIsEditModalOpen}>
        <DialogContent className="sm:max-w-md">
            <DialogHeader>
                <DialogTitle>Edit {itemToEdit?.type === 'group' ? 'Group' : 'Unique Name'}</DialogTitle>
            </DialogHeader>
            <div className="grid gap-4 py-4">
                <div className="grid grid-cols-4 items-center gap-4">
                    <Label htmlFor="edit-value" className="text-right">Name</Label>
                    <Input id="edit-value" value={editValue} onChange={(e) => setEditValue(e.target.value)} className="col-span-3" />
                </div>
            </div>
            <DialogFooter>
                <Button variant="outline" onClick={() => setIsEditModalOpen(false)}>Cancel</Button>
                <Button onClick={handleEditConfirm}>Save Changes</Button>
            </DialogFooter>
        </DialogContent>
      </Dialog>

      <AlertDialog open={isDeleteAlertOpen} onOpenChange={setIsDeleteAlertOpen}>
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                <AlertDialogDescription>
                  {itemToDelete?.type === 'product'
                    ? 'This action cannot be undone. This will permanently delete this product.'
                    : `This action cannot be undone. This will permanently delete the ${itemToDelete?.type} "${itemToDelete?.value}" and all products associated with it.`
                  }
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
