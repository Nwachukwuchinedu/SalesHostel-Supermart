
"use client";

import { zodResolver } from "@hookform/resolvers/zod";
import { useForm, useFieldArray, Controller } from "react-hook-form";
import { z } from "zod";
import { Button } from "@/components/ui/button";
import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import type { Supply, User, Product } from "@/lib/types";
import { PlusCircle, Trash2 } from "lucide-react";
import { useEffect, useMemo, useState } from "react";
import { ScrollArea } from "@/components/ui/scroll-area";
import { useAuth } from "@/contexts/auth-context";
import { ProductService } from "@/services/product-service";
import { SupplyService } from "@/services/supply-service";
import { useToast } from "@/hooks/use-toast";
import { Textarea } from "@/components/ui/textarea";

const supplyProductSchema = z.object({
  product: z.string().min(1, "Please select a product."),
  quantity: z.coerce.number().min(1, "Quantity must be at least 1."),
  quantityType: z.enum(["pcs", "kg", "ltr", "box"]),
  totalCost: z.coerce.number().optional(),
});

const formSchema = z.object({
  supplierRef: z.string().optional(),
  date: z.string().min(1, "Please select a date."),
  notes: z.string().optional(),
  paymentStatus: z.enum(['Pending', 'Paid', 'Partial', 'Overdue']).default('Pending'),
  products: z.array(supplyProductSchema).min(1, "Please add at least one product."),
});

type SupplyFormValues = z.infer<typeof formSchema>;

interface SupplyFormProps {
  initialData?: Supply | null;
  onSubmit: () => void;
  onCancel: () => void;
}

export function SupplyForm({ initialData, onSubmit, onCancel }: SupplyFormProps) {
  const { user } = useAuth();
  const { toast } = useToast();
  const [suppliers, setSuppliers] = useState<{_id: string; name: string}[]>([]);
  const [products, setProducts] = useState<Product[]>([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        if (user?.role === 'Admin' || user?.role === 'Staff') {
          const supplierRes = await SupplyService.getAllSupplierNames();
          setSuppliers(supplierRes.data);
        }
        const productRes = await ProductService.getAllProducts({ limit: 1000 });
        setProducts(productRes.data.map((p: any) => ({...p, id: p._id})));
      } catch (error) {
        toast({ title: "Error", description: "Failed to fetch suppliers or products.", variant: "destructive" });
      }
    };
    fetchData();
  }, [user?.role, toast]);
  
  const defaultValues = useMemo(() => {
    if (initialData) {
      return {
        supplierRef: initialData.supplier?._id,
        date: new Date(initialData.date).toISOString().split("T")[0],
        notes: initialData.notes || "",
        paymentStatus: initialData.paymentStatus,
        products: initialData.products.length > 0 ? initialData.products.map(p => ({
          product: p.product,
          quantity: p.quantity,
          quantityType: p.quantityType,
          totalCost: p.totalCost
        })) : [{ product: "", quantity: 1, quantityType: "pcs" as const }],
      };
    }
    return {
      supplierRef: user?.role === 'Supplier' ? user._id : "",
      date: new Date().toISOString().split("T")[0],
      notes: "",
      paymentStatus: 'Pending' as const,
      products: [{ product: "", quantity: 1, quantityType: "pcs" as const, totalCost: 0 }],
    };
  }, [initialData, user]);

  const form = useForm<SupplyFormValues>({
    resolver: zodResolver(formSchema),
    defaultValues,
  });

  useEffect(() => {
    form.reset(defaultValues);
  }, [defaultValues, form]);

  const { fields, append, remove } = useFieldArray({
    control: form.control,
    name: "products",
  });
  
  const handleSubmit = async (values: SupplyFormValues) => {
     try {
        const payload: any = { ...values };
        if (user?.role === 'Supplier') {
            payload.supplierRef = user._id;
        }

        if (initialData) {
            await SupplyService.updateSupply(initialData.id, payload);
            toast({ title: "Success", description: "Supply record updated." });
        } else {
            await SupplyService.createSupply(payload);
            toast({ title: "Success", description: "Supply record created." });
        }
        onSubmit();
     } catch (error: any) {
        toast({ title: "Error", description: error.message || "An error occurred.", variant: "destructive" });
     }
  };

  const watchedProducts = form.watch('products');
  
  return (
    <Form {...form}>
      <form onSubmit={form.handleSubmit(handleSubmit)} className="space-y-4">
        <ScrollArea className="h-[60vh]">
        <div className="p-4 space-y-4">

        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            {(user?.role === 'Admin' || user?.role === 'Staff') && (
                 <FormField
                    control={form.control}
                    name="supplierRef"
                    render={({ field }) => (
                        <FormItem>
                        <FormLabel>Supplier</FormLabel>
                        <Select onValueChange={field.onChange} value={field.value} defaultValue={field.value}>
                            <FormControl>
                            <SelectTrigger>
                                <SelectValue placeholder="Select a supplier" />
                            </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                            {suppliers.map(s => <SelectItem key={s._id} value={s._id}>{s.name}</SelectItem>)}
                            </SelectContent>
                        </Select>
                        <FormMessage />
                        </FormItem>
                    )}
                 />
            )}
            <FormField
            control={form.control}
            name="date"
            render={({ field }) => (
                <FormItem>
                <FormLabel>Date</FormLabel>
                <FormControl>
                    <Input type="date" {...field} />
                </FormControl>
                <FormMessage />
                </FormItem>
            )}
            />
        </div>

        <div>
          <FormLabel>Products</FormLabel>
          <div className="p-4 space-y-4 border rounded-md mt-2">
            {fields.map((field, index) => (
            <div key={field.id} className="grid grid-cols-[1fr_auto_auto_auto_auto] items-end gap-2 p-2 border rounded-lg">
                <Controller
                control={form.control}
                name={`products.${index}.product`}
                render={({ field: controllerField }) => (
                    <FormItem>
                    <Select onValueChange={controllerField.onChange} value={controllerField.value}>
                        <FormControl>
                        <SelectTrigger>
                            <SelectValue placeholder="Select product" />
                        </SelectTrigger>
                        </FormControl>
                        <SelectContent>
                        {products.map((product) => (
                            <SelectItem key={product.id} value={product.id}>
                            {product.name}
                            </SelectItem>
                        ))}
                        </SelectContent>
                    </Select>
                    <FormMessage />
                    </FormItem>
                )}
                />
                <Controller
                control={form.control}
                name={`products.${index}.quantity`}
                render={({ field: controllerField }) => (
                    <FormItem>
                    <FormControl>
                        <Input type="number" min="1" className="w-20" {...controllerField} placeholder="Qty" />
                    </FormControl>
                    <FormMessage />
                    </FormItem>
                )}
                />
                <Controller
                control={form.control}
                name={`products.${index}.quantityType`}
                render={({ field: controllerField }) => (
                    <FormItem>
                    <Select onValueChange={controllerField.onChange} value={controllerField.value}>
                        <FormControl>
                        <SelectTrigger className="w-24">
                            <SelectValue placeholder="Unit" />
                        </SelectTrigger>
                        </FormControl>
                        <SelectContent>
                        <SelectItem value="pcs">pcs</SelectItem>
                        <SelectItem value="kg">kg</SelectItem>
                        <SelectItem value="ltr">ltr</SelectItem>
                        <SelectItem value="box">box</SelectItem>
                        </SelectContent>
                    </Select>
                    <FormMessage />
                    </FormItem>
                )}
                />
                 <Controller
                control={form.control}
                name={`products.${index}.totalCost`}
                render={({ field: controllerField }) => (
                    <FormItem>
                    <FormControl>
                        <Input type="number" min="0" step="0.01" className="w-24" {...controllerField} placeholder="Cost" />
                    </FormControl>
                    <FormMessage />
                    </FormItem>
                )}
                />
                <Button type="button" variant="destructive" size="icon" onClick={() => remove(index)}>
                    <Trash2 className="h-4 w-4" />
                </Button>
            </div>
            ))}
            {form.formState.errors.products && !form.formState.errors.products.root && (
                <p className="text-sm font-medium text-destructive">
                    {form.formState.errors.products.message}
                </p>
            )}
             <Button
                type="button"
                variant="outline"
                size="sm"
                className="mt-2"
                onClick={() => append({ product: "", quantity: 1, quantityType: "pcs", totalCost: 0 })}
            >
                <PlusCircle className="mr-2 h-4 w-4" />
                Add Product
            </Button>
          </div>
        </div>
        
        <FormField
            control={form.control}
            name="notes"
            render={({ field }) => (
                <FormItem>
                    <FormLabel>Notes</FormLabel>
                    <FormControl>
                        <Textarea placeholder="Add any relevant notes for this supply..." {...field} />
                    </FormControl>
                    <FormMessage />
                </FormItem>
            )}
        />
        </div>
        </ScrollArea>
        
        <div className="flex justify-between items-center pt-4 border-t px-4">
            <div className="text-lg font-semibold">
                Backend will calculate total cost.
            </div>
            <div className="flex justify-end gap-4">
            <Button type="button" variant="outline" onClick={onCancel}>
                Cancel
            </Button>
            <Button type="submit">{initialData ? "Save Changes" : "Create Supply"}</Button>
            </div>
        </div>
      </form>
    </Form>
  );
}
