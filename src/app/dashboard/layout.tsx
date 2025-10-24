import { SidebarProvider, Sidebar, SidebarInset, SidebarTrigger } from "@/components/ui/sidebar";
import { SidebarNav } from "@/components/layout/sidebar-nav";
import { UserNav } from "@/components/layout/user-nav";
import { Toaster } from "@/components/ui/toaster";

export default function DashboardLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <SidebarProvider>
      <Sidebar collapsible="icon">
        <SidebarNav />
      </Sidebar>
      <SidebarInset>
        <div className="flex h-full flex-col">
            <header className="flex h-16 items-center justify-between border-b bg-card px-4 md:px-6 flex-shrink-0">
                <SidebarTrigger className="md:hidden" />
                <div className="ml-auto">
                    <UserNav />
                </div>
            </header>
            <main className="flex-1 overflow-y-auto p-4 md:p-8">
            {children}
            </main>
        </div>
      </SidebarInset>
    </SidebarProvider>
  );
}
