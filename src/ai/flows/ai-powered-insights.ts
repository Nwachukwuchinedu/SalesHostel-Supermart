
'use server';

/**
 * @fileOverview Generates AI-powered financial insights from sales data.
 *
 * - generateFinancialInsights - A function that generates financial insights based on sales data.
 * - FinancialInsightsInput - The input type for the generateFinancialInsights function.
 * - FinancialInsightsOutput - The return type for the generateFinancialInsights function.
 */

import {ai} from '@/ai/genkit';
import {z} from 'genkit';

const FinancialInsightsInputSchema = z.object({
  totalProducts: z.number().describe('Total number of products.'),
  totalSupplies: z.number().describe('Total number of supplies.'),
  totalPurchases: z.number().describe('Total number of purchases.'),
  totalSales: z.number().describe('Total sales amount.'),
  dateRange: z.string().optional().describe('The date range for the report.'),
  statusFilter: z.string().optional().describe('The status filter applied to the report.'),
  reportType: z.string().describe("The type of report: general, customer, supplier, or staff."),
  filterValue: z.string().optional().describe("The specific value for the filter (e.g., customer name, supplier name).")
});
export type FinancialInsightsInput = z.infer<typeof FinancialInsightsInputSchema>;

const FinancialInsightsOutputSchema = z.object({
  insights: z.string().describe('AI-generated financial insights and potential issues.'),
});
export type FinancialInsightsOutput = z.infer<typeof FinancialInsightsOutputSchema>;

export async function generateFinancialInsights(input: FinancialInsightsInput): Promise<FinancialInsightsOutput> {
  return generateFinancialInsightsFlow(input);
}

const prompt = ai.definePrompt({
  name: 'financialInsightsPrompt',
  input: {schema: FinancialInsightsInputSchema},
  output: {schema: FinancialInsightsOutputSchema},
  prompt: `You are a financial analyst providing insights from a sales report.
  Analyze the following data and highlight important trends and potential issues.

  Report Type: {{{reportType}}}
  {{#if filterValue}}
  Filter: {{{filterValue}}}
  {{/if}}
  Total Products: {{{totalProducts}}}
  Total Supplies: {{{totalSupplies}}}
  Total Purchases: {{{totalPurchases}}}
  Total Sales: {{{totalSales}}}
  Date Range: {{{dateRange}}}
  Status Filter: {{{statusFilter}}}

  Provide a summary of the insights, highlighting key trends, potential issues, and opportunities for improvement. Tailor the insights based on the report type and filter provided.`,
});

const generateFinancialInsightsFlow = ai.defineFlow(
  {
    name: 'generateFinancialInsightsFlow',
    inputSchema: FinancialInsightsInputSchema,
    outputSchema: FinancialInsightsOutputSchema,
  },
  async input => {
    const {output} = await prompt(input);
    return output!;
  }
);
