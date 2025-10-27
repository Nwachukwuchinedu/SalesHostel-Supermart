
"use client";

import { useActionState } from "react";
import { useFormStatus } from "react-dom";
import { generateReportAction, type ReportState } from "./actions";
import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Wand, Bot } from "lucide-react";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { users } from "@/lib/data";
import { useState } from "react";

function SubmitButton() {
  const { pending } = useFormStatus();
  return (
    <Button type="submit" disabled={pending}>
      {pending ? "Generating..." : "Generate Report"}
    </Button>
  );
}

export default function ReportsPage() {
  const initialState: ReportState = {};
  const [state, formAction] = useActionState(generateReportAction, initialState);
  const [reportType, setReportType] = useState<string>("general");

  const today = new Date().toISOString().split("T")[0];

  const customers = users.filter((u) => u.role === "Customer");
  const suppliers = users.filter((u) => u.role === "Supplier");
  const staff = users.filter((u) => u.role === "Staff");

  return (
    <div className="flex flex-col gap-8">
      <div>
        <h1 className="text-3xl font-headline font-bold tracking-tight">
          Reports
        </h1>
        <p className="text-muted-foreground">
          Generate summaries and AI-powered insights.
        </p>
      </div>

      <Card>
        <form action={formAction}>
          <CardHeader>
            <CardTitle>Generate a New Report</CardTitle>
            <CardDescription>
              Select a date range and filters to generate a sales report and get AI-powered
              insights.
            </CardDescription>
          </CardHeader>
          <CardContent className="grid gap-6 md:grid-cols-2">
            <div className="grid gap-2">
              <Label htmlFor="start-date">Start Date</Label>
              <Input id="start-date" name="startDate" type="date" defaultValue="2023-01-01" />
              {state.fields?.startDate && (
                  <p className="text-sm text-destructive">{state.fields.startDate}</p>
              )}
            </div>
            <div className="grid gap-2">
              <Label htmlFor="end-date">End Date</Label>
              <Input id="end-date" name="endDate" type="date" defaultValue={today} />
              {state.fields?.endDate && (
                  <p className="text-sm text-destructive">{state.fields.endDate}</p>
              )}
            </div>
            <div className="grid gap-2">
                <Label htmlFor="reportType">Report Type</Label>
                <Select name="reportType" defaultValue="general" onValueChange={setReportType}>
                    <SelectTrigger id="reportType">
                        <SelectValue placeholder="Select report type" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem value="general">General</SelectItem>
                        <SelectItem value="customer">By Customer</SelectItem>
                        <SelectItem value="supplier">By Supplier</SelectItem>
                        <SelectItem value="staff">By Staff</SelectItem>
                    </SelectContent>
                </Select>
            </div>
            {reportType === 'customer' && (
                <div className="grid gap-2">
                    <Label htmlFor="customer">Customer</Label>
                    <Select name="filterValue">
                        <SelectTrigger id="customer">
                            <SelectValue placeholder="Select a customer" />
                        </SelectTrigger>
                        <SelectContent>
                            {customers.map(c => <SelectItem key={c.id} value={c.name}>{c.name}</SelectItem>)}
                        </SelectContent>
                    </Select>
                </div>
            )}
            {reportType === 'supplier' && (
                <div className="grid gap-2">
                    <Label htmlFor="supplier">Supplier</Label>
                    <Select name="filterValue">
                        <SelectTrigger id="supplier">
                            <SelectValue placeholder="Select a supplier" />
                        </SelectTrigger>
                        <SelectContent>
                            {suppliers.map(s => <SelectItem key={s.id} value={s.name}>{s.name}</SelectItem>)}
                        </SelectContent>
                    </Select>
                </div>
            )}
            {reportType === 'staff' && (
                <div className="grid gap-2">
                    <Label htmlFor="staff">Staff</Label>
                    <Select name="filterValue">
                        <SelectTrigger id="staff">
                            <SelectValue placeholder="Select a staff member" />
                        </SelectTrigger>
                        <SelectContent>
                            {staff.map(s => <SelectItem key={s.id} value={s.name}>{s.name}</SelectItem>)}
                        </SelectContent>
                    </Select>
                </div>
            )}
          </CardContent>
          <CardFooter className="border-t px-6 py-4">
            <SubmitButton />
          </CardFooter>
        </form>
      </Card>

      {state.error && <p className="text-destructive">{state.error}</p>}
      
      <div className="grid gap-8 lg:grid-cols-2">
        {state.salesReport && (
          <Card>
            <CardHeader className="flex flex-row items-center gap-2">
              <Wand className="h-6 w-6 text-primary" />
              <CardTitle>Sales Report Summary</CardTitle>
            </CardHeader>
            <CardContent>
              <p className="text-sm text-muted-foreground whitespace-pre-wrap">{state.salesReport}</p>
            </CardContent>
          </Card>
        )}
        {state.financialInsights && (
          <Card>
            <CardHeader className="flex flex-row items-center gap-2">
                <Bot className="h-6 w-6 text-accent"/>
              <CardTitle>AI-Powered Insights</CardTitle>
            </CardHeader>
            <CardContent>
              <p className="text-sm text-muted-foreground whitespace-pre-wrap">{state.financialInsights}</p>
            </CardContent>
          </Card>
        )}
      </div>
    </div>
  );
}
