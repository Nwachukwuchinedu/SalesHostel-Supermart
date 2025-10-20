"use server";

import { generateFinancialInsights } from "@/ai/flows/ai-powered-insights";
import { generateSalesReport } from "@/ai/flows/generate-sales-report";
import { z } from "zod";

export interface ReportState {
  salesReport?: string;
  financialInsights?: string;
  error?: string;
  fields?: Record<string, string>;
  issues?: string[];
}

const ReportSchema = z.object({
  startDate: z.string().min(1, { message: "Start date is required" }),
  endDate: z.string().min(1, { message: "End date is required" }),
});

export async function generateReportAction(
  prevState: ReportState,
  formData: FormData
): Promise<ReportState> {
  const validatedFields = ReportSchema.safeParse({
    startDate: formData.get("startDate"),
    endDate: formData.get("endDate"),
  });

  if (!validatedFields.success) {
    return {
      error: "Invalid form data.",
      fields: {
        startDate: validatedFields.error.flatten().fieldErrors.startDate?.join(", ") || "",
        endDate: validatedFields.error.flatten().fieldErrors.endDate?.join(", ") || "",
      },
    };
  }

  const { startDate, endDate } = validatedFields.data;

  try {
    const [salesReportResult, insightsResult] = await Promise.all([
      generateSalesReport({ startDate, endDate }),
      generateFinancialInsights({
        // These are mock values for the demo
        totalProducts: 345,
        totalSupplies: 4,
        totalPurchases: 2350,
        totalSales: 45231.89,
        dateRange: `${startDate} to ${endDate}`,
        statusFilter: "All",
      }),
    ]);

    return {
      salesReport: salesReportResult.reportSummary,
      financialInsights: insightsResult.insights,
    };
  } catch (error) {
    console.error(error);
    return {
      error: "Failed to generate report. Please try again.",
    };
  }
}
