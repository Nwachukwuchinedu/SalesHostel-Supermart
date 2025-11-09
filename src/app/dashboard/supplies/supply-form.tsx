

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
import { products, users } from "@/lib/data";
import type { Supply } from "@/lib/types";
import { PlusCircle, Trash2 } from "lucide-react";
import { useEffect, useMemo } from "react";
import { ScrollArea } from "@/components/ui/scroll-area";

const supplyProductSchema = z.object({
  productId: z.string().min(1, "Please select a product."),
  quantity: z.coerce.number().min(1, "Quantity must be at least 1."),
  quantityType: z.enum(["pcs", "kg", "ltr", "box"]),
});

const formSchema = z.object({
  supplier: z.string().min(2, "Supplier name is required."),
  date: z.string().min(1, "Please select a date."),
  products: z.array(supplyProductSchema).min(1, "Please add at least one product."),
});

type SupplyFormValues = z.infer<typeof formSchema>;

interface SupplyFormProps {
  initialData?: Supply | null;
  onSubmit: (values: Supply) => void;
  onCancel: () => void;
}

export function SupplyForm({ initialData, onSubmit, onCancel }: SupplyFormProps) {
  const suppliers = useMemo(() => users.filter(u => u.role === 'Supplier'), []);
  
  const defaultValues = useMemo(() => {
    if (initialData) {
      return {
        ...initialData,
        date: new Date(initialData.date).toISOString().split("T")[0],
        products: initialData.products.length > 0 ? initialData.products : [{ productId: "", quantity: 1, quantityType: "pcs" }],
      };
    }
    return {
      supplier: "",
      date: new Date().toISOString().split("T")[0],
      products: [{ productId: "", quantity: 1, quantityType: "pcs" }],
    };
  }, [initialData]);

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

  const watchedProducts = form.watch("products");

  const calculateTotalItems = () => {
    return watchedProducts.reduce((total, item) => total + (item.quantity || 0), 0);
  };
  
  const handleSubmit = (values: SupplyFormValues) => {
    const totalItems = calculateTotalItems();
    const supplyData: Supply = {
      id: initialData?.id || `SUP${Date.now()}`,
      ...values,
      products: values.products.map(item => {
        const product = products.find(p => p.id === item.productId)!;
        return {
            productId: product.id,
            productName: product.name,
            quantity: item.quantity,
            quantityType: item.quantityType
        }
      }),
      totalItems,
    };
    onSubmit(supplyData);
  };

  const selectedSupplier = form.watch("supplier");

  return (
    <Form {...form}>
      <form onSubmit={form.handleSubmit(handleSubmit)} className="space-y-4">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <FormField
            control={form.control}
            name="supplier"
            render={({ field }) => (
                <FormItem>
                <FormLabel>Supplier</FormLabel>
                 <Select onValueChange={field.onChange} defaultValue={field.value} value={field.value} disabled={!!selectedSupplier}>
                    <FormControl>
                    <SelectTrigger>
                        <SelectValue placeholder="Select a supplier" />
                    </SelectTrigger>
                    </FormControl>
                    <SelectContent>
                    {suppliers.map(s => <SelectItem key={s.id} value={s.name}>{s.name}</SelectItem>)}
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
                <div key={field.id} className="grid grid-cols-[1fr_auto_auto_auto] items-end gap-2 p-2 border rounded-lg">
                    <Controller
                    control={form.control}
                    name={`products.${index}.productId`}
                    render={({ field: controllerField }) => (
                        <FormItem className="flex-1">
                        <Select onValueChange={controllerField.onChange} value={controllerField.value}>
                            <FormControl>
                            <SelectTrigger>
                                <SelectValue placeholder="Select a product" />
                            </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                            {products.map((product) => (
                                <SelectItem key={product.id} value={product.id} disabled={product.quantityAvailable === 0}>
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
            onClick={() => append({ productId: "", quantity: 1, quantityType: "pcs" })}
            disabled={!selectedSupplier}
          >
            <PlusCircle className="mr-2 h-4 w-4" />
            Add Product
          </Button>
        </div>
        
        <div className="flex justify-between items-center pt-4 border-t">
            <div className="text-lg font-semibold">
                Total Items: {calculateTotalItems()}
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
