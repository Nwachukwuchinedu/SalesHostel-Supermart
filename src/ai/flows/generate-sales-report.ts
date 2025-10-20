'use server';

/**
 * @fileOverview This file defines a Genkit flow for generating sales reports.
 *
 * The flow takes a date range as input and returns a summary of sales data,
 * product performance, and purchase trends.
 *
 * @requires genkit
 * @requires z
 *
 * @exports generateSalesReport - The main function to trigger the sales report generation flow.
 * @exports GenerateSalesReportInput - The input type for the generateSalesReport function.
 * @exports GenerateSalesReportOutput - The output type for the generateSalesReport function.
 */

import {ai} from '@/ai/genkit';
import {z} from 'genkit';

const GenerateSalesReportInputSchema = z.object({
  startDate: z
    .string()
    .describe('The start date for the report (YYYY-MM-DD).'),
  endDate: z.string().describe('The end date for the report (YYYY-MM-DD).'),
});

export type GenerateSalesReportInput = z.infer<typeof GenerateSalesReportInputSchema>;

const GenerateSalesReportOutputSchema = z.object({
  reportSummary: z
    .string()
    .describe('A summary of the sales report including total sales, product performance, and purchase trends.'),
});

export type GenerateSalesReportOutput = z.infer<typeof GenerateSalesReportOutputSchema>;

export async function generateSalesReport(
  input: GenerateSalesReportInput
): Promise<GenerateSalesReportOutput> {
  return generateSalesReportFlow(input);
}

const generateSalesReportPrompt = ai.definePrompt({
  name: 'generateSalesReportPrompt',
  input: {schema: GenerateSalesReportInputSchema},
  output: {schema: GenerateSalesReportOutputSchema},
  prompt: `You are a financial analyst tasked with generating a sales report.

  Summarize the total sales, product performance, and purchase trends between {{startDate}} and {{endDate}}.
  Provide insights into the best-selling products, overall revenue, and any notable purchase patterns during this period.
  Consider all available sales data to generate a comprehensive and easy-to-understand report.`,
});

const generateSalesReportFlow = ai.defineFlow(
  {
    name: 'generateSalesReportFlow',
    inputSchema: GenerateSalesReportInputSchema,
    outputSchema: GenerateSalesReportOutputSchema,
  },
  async input => {
    const {output} = await generateSalesReportPrompt(input);
    return output!;
  }
);
