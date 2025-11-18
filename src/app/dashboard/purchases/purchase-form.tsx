
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
import type { Purchase, Product, User } from "@/lib/types";
import { PlusCircle, Trash2 } from "lucide-react";
import { useEffect, useMemo, useState } from "react";
import { ScrollArea } from "@/components/ui/scroll-area";
import { PurchaseService } from "@/services/purchase-service";
import { ProductService } from "@/services/product-service";
import { UserService } from "@/services/user-service";
import { useToast } from "@/hooks/use-toast";
import { Textarea } from "@/components/ui/textarea";

const productSchema = z.object({
  product: z.string().min(1, "Please select a product."),
  quantity: z.coerce.number().min(1, "Quantity must be at least 1."),
  quantityUnit: z.enum(["pcs", "kg", "ltr", "box"]),
});

const formSchema = z.object({
  customer: z.string().min(1, "Customer is required."),
  products: z.array(productSchema).min(1, "Please add at least one product."),
  pickUpFee: z.coerce.number().optional(),
  paymentMethod: z.enum(["Cash", "Card", "Transfer", "Check", "Other"]).optional(),
  paymentStatus: z.enum(["Paid", "Pending", "Cancelled", "Refunded", "Partial"]).default("Pending"),
  deliveryStatus: z.enum(['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled']).default('Pending'),
  paymentReference: z.string().optional(),
  notes: z.string().optional(),
});

type PurchaseFormValues = z.infer<typeof formSchema>;

interface PurchaseFormProps {
  initialData?: Purchase | null;
  onSubmit: () => void;
  onCancel: () => void;
}

export function PurchaseForm({ initialData, onSubmit, onCancel }: PurchaseFormProps) {
    const { toast } = useToast();
    const [products, setProducts] = useState<Product[]>([]);
    const [customers, setCustomers] = useState<Pick<User, '_id' | 'name'>[]>([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const [productRes, customerRes] = await Promise.all([
                    ProductService.getAllProducts(),
                    UserService.getAllCustomerNames(),
                ]);
                setProducts(productRes.data.map((p: any) => ({...p, id: p._id})));
                setCustomers(customerRes.data);
            } catch (error) {
                toast({ title: "Error", description: "Failed to fetch products or customers.", variant: "destructive" });
            }
        };
        fetchData();
    }, [toast]);
    
    const defaultValues = useMemo(() => {
        if (initialData) {
            return {
                ...initialData,
                customer: initialData.customer._id,
                products: initialData.products.length > 0 ? initialData.products.map(p => ({
                    product: p.product,
                    quantity: p.quantity,
                    quantityUnit: p.quantityUnit,
                })) : [{ product: "", quantity: 1, quantityUnit: "pcs" as const }],
            };
        }
        return {
            customer: "",
            products: [{ product: "", quantity: 1, quantityUnit: "pcs" as const }],
            paymentStatus: "Pending" as const,
            deliveryStatus: "Pending" as const,
        };
    }, [initialData]);

  const form = useForm<PurchaseFormValues>({
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
  
  const handleSubmit = async (values: PurchaseFormValues) => {
    try {
        if (initialData) {
            await PurchaseService.updatePurchase(initialData.id, values);
            toast({ title: "Success", description: "Purchase updated successfully." });
        } else {
            await PurchaseService.createPurchase(values);
            toast({ title: "Success", description: "Purchase created successfully." });
        }
        onSubmit();
    } catch (error: any) {
        toast({ title: "Error", description: error.message, variant: "destructive" });
    }
  };

  return (
    <Form {...form}>
      <form onSubmit={form.handleSubmit(handleSubmit)} className="space-y-4">
        <ScrollArea className="h-[70vh]">
            <div className="p-4 space-y-6">
                <FormField
                    control={form.control}
                    name="customer"
                    render={({ field }) => (
                        <FormItem>
                        <FormLabel>Customer</FormLabel>
                        <Select onValueChange={field.onChange} value={field.value}>
                            <FormControl>
                            <SelectTrigger>
                                <SelectValue placeholder="Select a customer" />
                            </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                            {customers.map((c) => (
                                <SelectItem key={c._id} value={c._id}>
                                {c.name}
                                </SelectItem>
                            ))}
                            </SelectContent>
                        </Select>
                        <FormMessage />
                        </FormItem>
                    )}
                />

                <div>
                <FormLabel>Products</FormLabel>
                <div className="p-4 space-y-4 border rounded-md mt-2">
                    {fields.map((field, index) => (
                    <div key={field.id} className="grid grid-cols-[1fr_auto_auto_auto] items-end gap-2">
                        <Controller
                            control={form.control}
                            name={`products.${index}.product`}
                            render={({ field: controllerField }) => (
                                <FormItem>
                                <Select onValueChange={controllerField.onChange} value={controllerField.value}>
                                    <FormControl>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select a product" />
                                    </SelectTrigger>
                                    </FormControl>
                                    <SelectContent>
                                    {products.map((p) => (
                                        <SelectItem key={p._id} value={p._id} disabled={p.quantityAvailable === 0}>
                                        {p.name} ({p.quantityAvailable} in stock)
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
                                    <Input type="number" min="1" className="w-20" {...controllerField} placeholder="Qty"/>
                                </FormControl>
                                <FormMessage />
                                </FormItem>
                            )}
                        />
                        <Controller
                            control={form.control}
                            name={`products.${index}.quantityUnit`}
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
                        <Button type="button" variant="destructive" size="icon" onClick={() => remove(index)}>
                            <Trash2 className="h-4 w-4" />
                        </Button>
                    </div>
                    ))}
                     <Button
                        type="button"
                        variant="outline"
                        size="sm"
                        className="mt-2"
                        onClick={() => append({ product: "", quantity: 1, quantityUnit: "pcs" })}
                    >
                        <PlusCircle className="mr-2 h-4 w-4" />
                        Add Product
                    </Button>
                    {form.formState.errors.products && !form.formState.errors.products.root && (
                        <p className="text-sm font-medium text-destructive">
                            {form.formState.errors.products.message}
                        </p>
                    )}
                </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <FormField
                        control={form.control}
                        name="paymentStatus"
                        render={({ field }) => (
                            <FormItem>
                            <FormLabel>Payment Status</FormLabel>
                            <Select onValueChange={field.onChange} value={field.value}>
                                <FormControl>
                                <SelectTrigger><SelectValue /></SelectTrigger>
                                </FormControl>
                                <SelectContent>
                                    <SelectItem value="Pending">Pending</SelectItem>
                                    <SelectItem value="Paid">Paid</SelectItem>
                                    <SelectItem value="Partial">Partial</SelectItem>
                                    <SelectItem value="Cancelled">Cancelled</SelectItem>
                                    <SelectItem value="Refunded">Refunded</SelectItem>
                                </SelectContent>
                            </Select>
                            <FormMessage />
                            </FormItem>
                        )}
                    />
                    <FormField
                        control={form.control}
                        name="deliveryStatus"
                        render={({ field }) => (
                            <FormItem>
                            <FormLabel>Delivery Status</FormLabel>
                            <Select onValueChange={field.onChange} value={field.value}>
                                <FormControl>
                                <SelectTrigger><SelectValue /></SelectTrigger>
                                </FormControl>
                                <SelectContent>
                                    <SelectItem value="Pending">Pending</SelectItem>
                                    <SelectItem value="Processing">Processing</SelectItem>
                                    <SelectItem value="Shipped">Shipped</SelectItem>
                                    <SelectItem value="Delivered">Delivered</SelectItem>
                                    <SelectItem value="Cancelled">Cancelled</SelectItem>
                                </SelectContent>
                            </Select>
                            <FormMessage />
                            </FormItem>
                        )}
                    />
                </div>
                <FormField
                    control={form.control}
                    name="notes"
                    render={({ field }) => (
                        <FormItem>
                            <FormLabel>Notes</FormLabel>
                            <FormControl>
                                <Textarea placeholder="Add any notes for this purchase..." {...field} />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    )}
                />
            </div>
        </ScrollArea>
        <div className="flex justify-end gap-4 pt-4 border-t px-4">
            <Button type="button" variant="outline" onClick={onCancel}>
                Cancel
            </Button>
            <Button type="submit">{initialData ? "Save Changes" : "Create Purchase"}</Button>
        </div>
      </form>
    </Form>
  );
}

