import { NextResponse } from 'next/server'
import type { NextRequest } from 'next/server'
 
export function middleware(request: NextRequest) {
  // Client-side checks in AuthProvider are more effective for this auth strategy.
  // This middleware is now a placeholder.
  return NextResponse.next();
}
 
export const config = {
  // We are removing route protection from middleware for now.
  // The AuthProvider will handle client-side routing protection.
  matcher: [],
}
