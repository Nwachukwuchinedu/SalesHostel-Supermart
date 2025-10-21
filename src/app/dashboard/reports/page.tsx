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

  const today = new Date().toISOString().split("T")[0];

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
              Select a date range to generate a sales report and get AI-powered
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
