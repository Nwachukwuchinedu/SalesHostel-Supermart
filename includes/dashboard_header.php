<header class="flex h-16 items-center gap-4 border-b bg-card px-6 md:ml-64">
    <button id="open-sidebar" class="md:hidden">
        <i data-lucide="menu" class="h-5 w-5"></i>
        <span class="sr-only">Toggle navigation menu</span>
    </button>
    <div class="w-full flex-1">
        <form>
            <div class="relative">
                <i data-lucide="search" class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"></i>
                <input
                    type="search"
                    placeholder="Search products..."
                    class="w-full bg-background appearance-none pl-8 shadow-none md:w-2/3 lg:w-1/3 flex h-9 rounded-md border border-input px-3 py-1 text-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                />
            </div>
        </form>
    </div>
    <div class="flex items-center gap-4">
        <button class="relative h-8 w-8 rounded-full overflow-hidden border bg-muted hover:bg-muted/80">
            <img src="https://ui.shadcn.com/avatars/01.png" alt="User" class="h-full w-full object-cover" />
        </button>
    </div>
</header>
