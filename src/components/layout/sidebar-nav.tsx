"use client";

import {
  SidebarContent,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuItem,
  SidebarMenuButton,
  SidebarFooter,
} from "@/components/ui/sidebar";
import {
  LayoutDashboard,
  Box,
  Truck,
  ShoppingCart,
  FileText,
  BarChart,
  Building,
  LogOut,
  Settings,
} from "lucide-react";
import Link from "next/link";
import { usePathname, useRouter } from "next/navigation";
import { useEffect, useState } from "react";
import type { UserRole, User } from "@/lib/types";

const allLinks = [
  { href: "/dashboard", label: "Dashboard", icon: LayoutDashboard, roles: ["Admin", "Staff"] },
  { href: "/dashboard/products", label: "Products", icon: Box, roles: ["Admin", "Staff", "Customer"] },
  { href: "/dashboard/supplies", label: "Supplies", icon: Truck, roles: ["Admin", "Supplier"] },
  { href: "/dashboard/purchases", label: "Purchases", icon: ShoppingCart, roles: ["Admin", "Staff", "Customer"] },
  { href: "/dashboard/invoices", label: "Invoices", icon: FileText, roles: ["Admin", "Staff", "Customer"] },
  { href: "/dashboard/reports", label: "Reports", icon: BarChart, roles: ["Admin"] },
];

export function SidebarNav() {
  const pathname = usePathname();
  const router = useRouter();
  const [user, setUser] = useState<User | null>(null);

  useEffect(() => {
    const userData = localStorage.getItem("user");
    if (userData) {
      setUser(JSON.parse(userData));
    }
  }, []);

  const handleLogout = () => {
    localStorage.removeItem("user");
    router.push("/login");
  };

  const availableLinks = allLinks.filter(link => user?.role && link.roles.includes(user.role));

  return (
    <>
      <SidebarHeader>
        <div className="flex items-center gap-2 p-2">
          <Building className="size-8 text-primary" />
          <h1 className="text-xl font-headline font-semibold">
            SalesHostel
          </h1>
        </div>
      </SidebarHeader>
      <SidebarContent>
        <SidebarMenu>
          {availableLinks.map((link) => (
            <SidebarMenuItem key={link.href}>
              <Link href={link.href}>
                <SidebarMenuButton
                  isActive={pathname === link.href}
                  tooltip={link.label}
                >
                  <link.icon />
                  <span>{link.label}</span>
                </SidebarMenuButton>
              </Link>
            </SidebarMenuItem>
          ))}
        </SidebarMenu>
      </SidebarContent>
      <SidebarFooter>
        <SidebarMenu>
            <SidebarMenuItem>
                <Link href="#">
                    <SidebarMenuButton tooltip="Settings">
                        <Settings/>
                        <span>Settings</span>
                    </SidebarMenuButton>
                </Link>
            </SidebarMenuItem>
            <SidebarMenuItem>
                <SidebarMenuButton tooltip="Logout" onClick={handleLogout}>
                    <LogOut/>
                    <span>Logout</span>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
      </SidebarFooter>
    </>
  );
}
