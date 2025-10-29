
"use client";

import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { Button } from "@/components/ui/button";
import {
  Form,
  FormControl,
  FormDescription,
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
import { Textarea } from "@/components/ui/textarea";
import type { Product } from "@/lib/types";

const formSchema = z.object({
  name: z.string().min(2, "Name must be at least 2 characters."),
  uniqueName: z.string().min(1, "Unique name is required."),
  group: z.string().min(2, "Group must be at least 2 characters."),
  costPrice: z.coerce.number().positive("Cost price must be a positive number."),
  sellingPrice: z.coerce.number().positive("Selling price must be a positive number."),
  quantityAvailable: z.coerce.number().min(0, "Quantity cannot be negative.").default(0),
  quantityUnit: z.enum(["pcs", "kg", "ltr", "box"]),
  imageUrl: z.string().optional(),
  tags: z.string().min(1, "Please add at least one tag."),
  description: z.string(),
});

type ProductFormValues = z.infer<typeof formSchema>;

interface ProductFormProps {
  initialData?: Product | null;
  onSubmit: (values: Product) => void;
  onCancel: () => void;
}

export function ProductForm({
  initialData,
  onSubmit,
  onCancel,
}: ProductFormProps) {
  const form = useForm<ProductFormValues>({
    resolver: zodResolver(formSchema),
    defaultValues: initialData
      ? {
          ...initialData,
          tags: initialData.tags.join(", "),
        }
      : {
          name: "",
          uniqueName: "",
          group: "",
          costPrice: 0,
          sellingPrice: 0,
          quantityAvailable: 0,
          quantityUnit: "pcs",
          imageUrl: "",
          tags: "",
          description: "",
        },
  });

  const handleSubmit = (values: ProductFormValues) => {
    const productData: Product = {
      id: initialData?.id || `PROD${Date.now()}`,
      ...values,
      imageUrl: values.imageUrl || "",
      tags: values.tags.split(",").map((tag) => tag.trim()),
    };
    onSubmit(productData);
  };
  
  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      const reader = new FileReader();
      reader.onloadend = () => {
        form.setValue("imageUrl", reader.result as string);
      };
      reader.readAsDataURL(file);
    }
  };


  return (
    <Form {...form}>
      <form onSubmit={form.handleSubmit(handleSubmit)} className="space-y-4">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <FormField
            control={form.control}
            name="name"
            render={({ field }) => (
                <FormItem>
                <FormLabel>Product Name</FormLabel>
                <FormControl>
                    <Input placeholder="e.g., Bag of Rice" {...field} />
                </FormControl>
                <FormMessage />
                </FormItem>
            )}
            />
            <FormField
            control={form.control}
            name="uniqueName"
            render={({ field }) => (
                <FormItem>
                <FormLabel>Unique Name</FormLabel>
                <FormControl>
                    <Input placeholder="e.g., Rice" {...field} />
                </FormControl>
                <FormMessage />
                </FormItem>
            )}
            />
        </div>
        <FormField
          control={form.control}
          name="group"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Group</FormLabel>
              <FormControl>
                <Input placeholder="e.g., Grains" {...field} />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />
        <div className="grid grid-cols-2 gap-4">
            <FormField
            control={form.control}
            name="quantityAvailable"
            render={({ field }) => (
                <FormItem>
                <FormLabel>Quantity Available</FormLabel>
                <FormControl>
                    <Input type="number" {...field} />
                </FormControl>
                <FormMessage />
                </FormItem>
            )}
            />
            <FormField
              control={form.control}
              name="quantityUnit"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Unit</FormLabel>
                  <Select onValueChange={field.onChange} defaultValue={field.value}>
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
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <FormField
            control={form.control}
            name="costPrice"
            render={({ field }) => (
                <FormItem>
                <FormLabel>Cost Price</FormLabel>
                <FormControl>
                    <Input type="number" step="0.01" {...field} />
                </FormControl>
                <FormMessage />
                </FormItem>
            )}
            />
            <FormField
            control={form.control}
            name="sellingPrice"
            render={({ field }) => (
                <FormItem>
                <FormLabel>Selling Price</FormLabel>
                <FormControl>
                    <Input type="number" step="0.01" {...field} />
                </FormControl>
                <FormMessage />
                </FormItem>
            )}
            />
        </div>
         <FormField
          control={form.control}
          name="imageUrl"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Product Image</FormLabel>
              <FormControl>
                <Input type="file" accept="image/*" onChange={handleImageChange} />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />
        {form.watch("imageUrl") && (
          <div className="flex justify-center">
            <img src={form.watch("imageUrl")} alt="Product preview" className="h-24 w-24 object-cover rounded-md" />
          </div>
        )}
        <FormField
            control={form.control}
            name="tags"
            render={({ field }) => (
                <FormItem>
                <FormLabel>Tags</FormLabel>
                <FormControl>
                    <Input placeholder="e.g., organic, fruit, fresh" {...field} />
                </FormControl>
                <FormDescription>
                    Comma-separated list of tags.
                </FormDescription>
                <FormMessage />
                </FormItem>
            )}
            />
        <FormField
          control={form.control}
          name="description"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Description</FormLabel>
              <FormControl>
                <Textarea
                  placeholder="A short description of the product."
                  {...field}
                />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />
        <div className="flex justify-end gap-4">
          <Button type="button" variant="outline" onClick={onCancel}>
            Cancel
          </Button>
          <Button type="submit">{initialData ? "Save Changes" : "Add Product"}</Button>
        </div>
      </form>
    </Form>
  );
}
