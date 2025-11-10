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
import { useAuth } from "@/contexts/auth-context";

const allLinks = [
  { href: "/dashboard", label: "Dashboard", icon: LayoutDashboard, roles: ["Admin", "Staff", "Supplier", "Customer"] },
  { href: "/dashboard/products", label: "Products", icon: Box, roles: ["Admin", "Staff", "Supplier"] },
  { href: "/dashboard/supplies", label: "Supplies", icon: Truck, roles: ["Admin", "Supplier"] },
  { href: "/dashboard/purchases", label: "Purchases", icon: ShoppingCart, roles: ["Admin", "Staff"] },
  { href: "/dashboard/reports", label: "Reports", icon: BarChart, roles: ["Admin"] },
];

export function SidebarNav() {
  const pathname = usePathname();
  const { user, logout } = useAuth();
  const router = useRouter();

  const handleLogout = () => {
    logout();
    router.push('/login');
  };

  if (!user) {
    return null; // or a loading state
  }
  
  const links = allLinks.filter(link => user && link.roles.includes(user.role));

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
