
"use client";

import { usePathname } from "next/navigation";
import Link from "next/link";
import { Building, Twitter, Facebook, Linkedin } from "lucide-react";

export function Footer() {
    const pathname = usePathname();

    if (pathname.startsWith('/dashboard') || pathname.startsWith('/login') || pathname.startsWith('/signup')) {
        return null;
    }

    return (
        <footer className="bg-card/50 border-t">
            <div className="container mx-auto py-12 px-4 md:px-6">
                <div className="grid gap-8 md:grid-cols-4">
                    <div className="space-y-4 md:col-span-2">
                        <Link href="/" className="flex items-center gap-2">
                            <Building className="h-6 w-6 text-primary" />
                            <span className="font-headline text-lg font-semibold">
                                SalesHostel Digital
                            </span>
                        </Link>
                        <p className="text-sm text-muted-foreground max-w-sm">
                            The all-in-one solution for managing your inventory, sales, and supplies with powerful AI-driven insights.
                        </p>
                    </div>
                    <div>
                        <h4 className="font-semibold mb-4">Quick Links</h4>
                        <ul className="space-y-2">
                            <li><Link href="#features" className="text-sm text-muted-foreground hover:text-foreground">Features</Link></li>
                            <li><Link href="#products" className="text-sm text-muted-foreground hover:text-foreground">Products</Link></li>
                            <li><Link href="/signup" className="text-sm text-muted-foreground hover:text-foreground">Sign Up</Link></li>
                            <li><Link href="/login" className="text-sm text-muted-foreground hover:text-foreground">Login</Link></li>
                        </ul>
                    </div>
                    <div>
                        <h4 className="font-semibold mb-4">Follow Us</h4>
                        <div className="flex items-center gap-4">
                            <Link href="#" className="text-muted-foreground hover:text-foreground"><Twitter className="h-5 w-5"/></Link>
                            <Link href="#" className="text-muted-foreground hover:text-foreground"><Facebook className="h-5 w-5"/></Link>
                            <Link href="#" className="text-muted-foreground hover:text-foreground"><Linkedin className="h-5 w-5"/></Link>
                        </div>
                    </div>
                </div>
                <div className="mt-8 pt-8 border-t text-center text-sm text-muted-foreground">
                    <p>&copy; {new Date().getFullYear()} SalesHostel Digital. All rights reserved.</p>
                </div>
            </div>
        </footer>
    );
}
