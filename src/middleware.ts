import { NextResponse } from 'next/server'
import type { NextRequest } from 'next/server'
 
export function middleware(request: NextRequest) {
  // Middleware is not ideal for localStorage-based auth.
  // Client-side checks in a layout or context provider are more effective.
  // This middleware is now a placeholder.
  return NextResponse.next();
}
 
export const config = {
  // We are removing route protection from middleware for now.
  // Client-side routing protection will be handled by the AuthProvider.
  matcher: [],
}
