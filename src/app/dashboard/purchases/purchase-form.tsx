
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
import { products } from "@/lib/data";
import type { Purchase } from "@/lib/types";
import { PlusCircle, Trash2 } from "lucide-react";
import { useEffect, useMemo } from "react";
import { ScrollArea } from "@/components/ui/scroll-area";

const productSchema = z.object({
  productId: z.string().min(1, "Please select a product."),
  quantity: z.coerce.number().min(1, "Quantity must be at least 1."),
});

const formSchema = z.object({
  customerName: z.string().min(2, "Customer name is required."),
  paymentStatus: z.enum(["Paid", "Pending"]),
  date: z.string().min(1, "Please select a date."),
  products: z.array(productSchema).min(1, "Please add at least one product."),
});

type PurchaseFormValues = z.infer<typeof formSchema>;

interface PurchaseFormProps {
  initialData?: Purchase | null;
  onSubmit: (values: Purchase) => void;
  onCancel: () => void;
}

export function PurchaseForm({ initialData, onSubmit, onCancel }: PurchaseFormProps) {
    const defaultValues = useMemo(() => {
        if (initialData) {
            const productIds = initialData.products.map(p => {
                const product = products.find(prod => prod.name === p.name);
                return { productId: product?.id || "", quantity: p.quantity };
            });
            return {
                ...initialData,
                date: new Date(initialData.date).toISOString().split('T')[0],
                products: productIds.length > 0 ? productIds : [{ productId: "", quantity: 1 }],
            };
        }
        return {
            customerName: "",
            paymentStatus: "Pending" as "Paid" | "Pending",
            date: new Date().toISOString().split("T")[0],
            products: [{ productId: "", quantity: 1 }],
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

  const watchedProducts = form.watch("products");

  const calculateTotal = () => {
    return watchedProducts.reduce((total, item) => {
      const product = products.find((p) => p.id === item.productId);
      if (product) {
        return total + product.price * item.quantity;
      }
      return total;
    }, 0);
  };
  
  const handleSubmit = (values: PurchaseFormValues) => {
    const total = calculateTotal();
    const purchaseData: Purchase = {
      id: initialData?.id || `PUR${Date.now()}`,
      ...values,
      products: values.products.map(item => {
        const product = products.find(p => p.id === item.productId)!;
        return {
            name: product.name,
            quantity: item.quantity,
            price: product.price
        }
      }),
      total,
    };
    onSubmit(purchaseData);
  };

  return (
    <Form {...form}>
      <form onSubmit={form.handleSubmit(handleSubmit)} className="space-y-4">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <FormField
            control={form.control}
            name="customerName"
            render={({ field }) => (
                <FormItem>
                <FormLabel>Customer Name</FormLabel>
                <FormControl>
                    <Input placeholder="John Doe" {...field} />
                </FormControl>
                <FormMessage />
                </FormItem>
            )}
            />
            <FormField
            control={form.control}
            name="paymentStatus"
            render={({ field }) => (
                <FormItem>
                <FormLabel>Payment Status</FormLabel>
                <Select onValueChange={field.onChange} defaultValue={field.value}>
                    <FormControl>
                    <SelectTrigger>
                        <SelectValue placeholder="Select status" />
                    </SelectTrigger>
                    </FormControl>
                    <SelectContent>
                    <SelectItem value="Pending">Pending</SelectItem>
                    <SelectItem value="Paid">Paid</SelectItem>
                    </SelectContent>
                </Select>
                <FormMessage />
                </FormItem>
            )}
            />
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
          <ScrollArea className="h-40 rounded-md border mt-2">
            <div className="p-4 space-y-4">
                {fields.map((field, index) => (
                <div key={field.id} className="flex items-end gap-2 p-2 border rounded-lg">
                    <Controller
                    control={form.control}
                    name={`products.${index}.productId`}
                    render={({ field: controllerField }) => (
                        <FormItem className="flex-1">
                            {index === 0 && <FormLabel className="hidden">Product</FormLabel>}
                        <Select onValueChange={controllerField.onChange} value={controllerField.value}>
                            <FormControl>
                            <SelectTrigger>
                                <SelectValue placeholder="Select a product" />
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
                        {index === 0 && <FormLabel className="hidden">Quantity</FormLabel>}
                        <FormControl>
                            <Input type="number" min="1" className="w-20" {...controllerField} />
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
            </div>
          </ScrollArea>
          <Button
            type="button"
            variant="outline"
            size="sm"
            className="mt-2"
            onClick={() => append({ productId: "", quantity: 1 })}
          >
            <PlusCircle className="mr-2 h-4 w-4" />
            Add Product
          </Button>
        </div>
        
        <div className="flex justify-between items-center pt-4 border-t">
            <div className="text-lg font-semibold">
                Total: ${calculateTotal().toFixed(2)}
            </div>
            <div className="flex justify-end gap-4">
            <Button type="button" variant="outline" onClick={onCancel}>
                Cancel
            </Button>
            <Button type="submit">{initialData ? "Save Changes" : "Create Purchase"}</Button>
            </div>
        </div>
      </form>
    </Form>
  );
}
