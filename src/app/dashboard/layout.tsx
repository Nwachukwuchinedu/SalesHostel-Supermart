"use client";

import { useEffect } from "react";
import { useRouter } from "next/navigation";
import { useAuth } from "@/contexts/auth-context";
import { SidebarProvider, Sidebar, SidebarInset, SidebarTrigger } from "@/components/ui/sidebar";
import { SidebarNav } from "@/components/layout/sidebar-nav";
import { UserNav } from "@/components/layout/user-nav";

export default function DashboardLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const { user, loading } = useAuth();
  const router = useRouter();

  useEffect(() => {
    if (!loading && !user) {
      router.push("/login");
    }
  }, [user, loading, router]);

  if (loading || !user) {
    // You can show a loading spinner here
    return <div>Loading...</div>;
  }

  return (
    <SidebarProvider>
      <Sidebar collapsible="icon">
        <SidebarNav />
      </Sidebar>
      <SidebarInset>
        <div className="flex h-full flex-col overflow-hidden">
            <header className="flex h-16 items-center justify-between border-b bg-card px-4 md:px-6 flex-shrink-0">
                <SidebarTrigger className="md:hidden" />
                <div className="ml-auto">
                    <UserNav />
                </div>
            </header>
            <main className="flex-1 overflow-auto p-4 md:p-8 min-w-0">
            {children}
            </main>
        </div>
      </SidebarInset>
    </SidebarProvider>
  );
}
