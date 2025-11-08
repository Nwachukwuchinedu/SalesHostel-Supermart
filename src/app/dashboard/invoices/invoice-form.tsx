
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
import type { Invoice, Purchase } from "@/lib/types";
import { purchases } from "@/lib/data";
import { useEffect, useMemo } from "react";

const formSchema = z.object({
  purchaseId: z.string().min(1, "Please select a purchase."),
  dueDate: z.string().min(1, "Please select a due date."),
  status: z.enum(["Paid", "Unpaid", "Overdue"]),
});

type InvoiceFormValues = z.infer<typeof formSchema>;

interface InvoiceFormProps {
  initialData?: Invoice | null;
  onSubmit: (values: Invoice) => void;
  onCancel: () => void;
}

export function InvoiceForm({
  initialData,
  onSubmit,
  onCancel,
}: InvoiceFormProps) {

  const unpaidPurchases = useMemo(() => {
    return purchases.filter(p => p.paymentStatus === 'Pending');
  }, [])

  const form = useForm<InvoiceFormValues>({
    resolver: zodResolver(formSchema),
    defaultValues: initialData
      ? {
          ...initialData,
          dueDate: new Date(initialData.dueDate).toISOString().split("T")[0],
        }
      : {
          purchaseId: "",
          dueDate: "",
          status: "Unpaid",
        },
  });

  const watchPurchaseId = form.watch("purchaseId");
  const selectedPurchase = useMemo(() => {
    return purchases.find(p => p.id === watchPurchaseId);
  }, [watchPurchaseId]);


  const handleSubmit = (values: InvoiceFormValues) => {
    if (!selectedPurchase) return;
    
    const invoiceData: Invoice = {
      id: initialData?.id || `INV${Date.now()}`,
      purchaseId: selectedPurchase.id,
      customerName: selectedPurchase.customerName,
      amount: selectedPurchase.total,
      issueDate: new Date().toISOString(),
      ...values,
      purchase: selectedPurchase
    };
    onSubmit(invoiceData);
  };

  return (
    <Form {...form}>
      <form onSubmit={form.handleSubmit(handleSubmit)} className="space-y-4">
        <FormField
          control={form.control}
          name="purchaseId"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Purchase Order</FormLabel>
              <Select onValueChange={field.onChange} defaultValue={field.value}>
                <FormControl>
                  <SelectTrigger>
                    <SelectValue placeholder="Select a purchase to invoice" />
                  </SelectTrigger>
                </FormControl>
                <SelectContent>
                  {unpaidPurchases.map((purchase) => (
                    <SelectItem key={purchase.id} value={purchase.id}>
                      {purchase.id} - {purchase.customerName} (₦{purchase.total.toFixed(2)})
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
              <FormMessage />
            </FormItem>
          )}
        />
        {selectedPurchase && (
            <div className="space-y-2 rounded-md border p-2 text-sm">
                <p><strong>Customer:</strong> {selectedPurchase.customerName}</p>
                <p><strong>Amount:</strong> ₦{selectedPurchase.total.toFixed(2)}</p>
                <p><strong>Date:</strong> {new Date(selectedPurchase.date).toLocaleDateString()}</p>
            </div>
        )}
        <FormField
          control={form.control}
          name="dueDate"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Due Date</FormLabel>
              <FormControl>
                <Input type="date" {...field} />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />
        <FormField
            control={form.control}
            name="status"
            render={({ field }) => (
                <FormItem>
                <FormLabel>Status</FormLabel>
                <Select onValueChange={field.onChange} defaultValue={field.value}>
                    <FormControl>
                    <SelectTrigger>
                        <SelectValue placeholder="Select status" />
                    </SelectTrigger>
                    </FormControl>
                    <SelectContent>
                        <SelectItem value="Unpaid">Unpaid</SelectItem>
                        <SelectItem value="Paid">Paid</SelectItem>
                        <SelectItem value="Overdue">Overdue</SelectItem>
                    </SelectContent>
                </Select>
                <FormMessage />
                </FormItem>
            )}
            />
        <div className="flex justify-end gap-4">
          <Button type="button" variant="outline" onClick={onCancel}>
            Cancel
          </Button>
          <Button type="submit">{initialData ? "Save Changes" : "Create Invoice"}</Button>
        </div>
      </form>
    </Form>
  );
}
