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
import { usePathname } from "next/navigation";
import { useEffect, useState } from "react";
import type { UserRole } from "@/lib/types";

const allLinks = [
  { href: "/dashboard", label: "Dashboard", icon: LayoutDashboard, roles: ["Admin", "Staff", "Supplier", "Customer"] },
  { href: "/dashboard/products", label: "Products", icon: Box, roles: ["Admin", "Staff", "Supplier"] },
  { href: "/dashboard/supplies", label: "Supplies", icon: Truck, roles: ["Admin", "Supplier"] },
  { href: "/dashboard/purchases", label: "Purchases", icon: ShoppingCart, roles: ["Admin", "Staff"] },
  { href: "/dashboard/reports", label: "Reports", icon: BarChart, roles: ["Admin"] },
];

export function SidebarNav() {
  const pathname = usePathname();
  const [userRole, setUserRole] = useState<UserRole | null>(null);

  useEffect(() => {
    const role = localStorage.getItem("userRole") as UserRole;
    setUserRole(role || "Customer");
  }, []);

  const links = allLinks.filter(link => userRole && link.roles.includes(userRole));
  
  if (!userRole) {
    return null; // or a loading state
  }

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
          {links.map((link) => (
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
                <Link href="/login">
                    <SidebarMenuButton tooltip="Logout">
                        <LogOut/>
                        <span>Logout</span>
                    </SidebarMenuButton>
                </Link>
            </SidebarMenuItem>
        </SidebarMenu>
      </SidebarFooter>
    </>
  );
}
