"use client";

import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
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
import type { Supply } from "@/lib/types";
import { products } from "@/lib/data";
import { useEffect } from "react";

const formSchema = z.object({
  productName: z.string().min(1, "Please select a product."),
  supplier: z.string().min(2, "Supplier must be at least 2 characters."),
  quantity: z.coerce.number().positive("Quantity must be a positive number."),
  quantityType: z.enum(["pcs", "kg", "ltr", "box"]),
  date: z.string().min(1, "Please select a date."),
});

type SupplyFormValues = z.infer<typeof formSchema>;

interface SupplyFormProps {
  initialData?: Supply | null;
  onSubmit: (values: SupplyFormValues) => void;
  onCancel: () => void;
}

export function SupplyForm({
  initialData,
  onSubmit,
  onCancel,
}: SupplyFormProps) {
  const form = useForm<SupplyFormValues>({
    resolver: zodResolver(formSchema),
    defaultValues: initialData
      ? {
          ...initialData,
          date: new Date(initialData.date).toISOString().split('T')[0],
        }
      : {
          productName: "",
          supplier: "",
          quantity: 0,
          quantityType: "pcs",
          date: new Date().toISOString().split('T')[0],
        },
  });

  useEffect(() => {
    if (initialData) {
        form.reset({
            ...initialData,
            date: new Date(initialData.date).toISOString().split('T')[0],
        });
    } else {
        form.reset({
            productName: "",
            supplier: "",
            quantity: 0,
            quantityType: "pcs",
            date: new Date().toISOString().split('T')[0],
        })
    }
  }, [initialData, form.reset]);

  const handleSubmit = (values: SupplyFormValues) => {
    onSubmit(values);
  };

  return (
    <Form {...form}>
      <form onSubmit={form.handleSubmit(handleSubmit)} className="space-y-4">
        <FormField
          control={form.control}
          name="productName"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Product</FormLabel>
              <Select onValueChange={field.onChange} defaultValue={field.value} value={field.value}>
                <FormControl>
                  <SelectTrigger>
                    <SelectValue placeholder="Select a product" />
                  </SelectTrigger>
                </FormControl>
                <SelectContent>
                  {products.map((product) => (
                    <SelectItem key={product.id} value={product.name}>
                      {product.name}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
              <FormMessage />
            </FormItem>
          )}
        />
        <FormField
          control={form.control}
          name="supplier"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Supplier</FormLabel>
              <FormControl>
                <Input placeholder="e.g., Fresh Farms" {...field} />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />
        <div className="grid grid-cols-2 gap-4">
          <FormField
            control={form.control}
            name="quantity"
            render={({ field }) => (
              <FormItem>
                <FormLabel>Quantity</FormLabel>
                <FormControl>
                  <Input type="number" {...field} />
                </FormControl>
                <FormMessage />
              </FormItem>
            )}
          />
          <FormField
            control={form.control}
            name="quantityType"
            render={({ field }) => (
              <FormItem>
                <FormLabel>Unit</FormLabel>
                <Select
                  onValueChange={field.onChange}
                  defaultValue={field.value}
                  value={field.value}
                >
                  <FormControl>
                    <SelectTrigger>
                      <SelectValue placeholder="Select a unit" />
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
        </div>
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
        <div className="flex justify-end gap-4">
          <Button type="button" variant="outline" onClick={onCancel}>
            Cancel
          </Button>
          <Button type="submit">{initialData ? "Save Changes" : "Add Supply"}</Button>
        </div>
      </form>
    </Form>
  );
}
