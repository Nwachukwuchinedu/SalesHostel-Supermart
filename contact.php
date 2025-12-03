<?php include 'includes/header.php'; ?>

<div class="flex flex-col min-h-screen relative overflow-hidden">
    <div class="bg-grid-uneven fixed inset-0 pointer-events-none"></div>
    <main class="flex-1 relative z-10 container mx-auto px-4 py-24">
        <div class="max-w-3xl mx-auto space-y-8">
            <h1 class="text-4xl font-headline font-bold">Contact Us</h1>
            <p class="text-lg text-muted-foreground">
                We're happy to help! Need a quick answer? Enter your question below or reach out to our support team.
            </p>
            
            <div class="glass-card p-8 rounded-xl mt-8">
                <form class="space-y-6">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Name</label>
                            <input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring" placeholder="Your name">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Email</label>
                            <input type="email" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring" placeholder="name@example.com">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Message</label>
                        <textarea class="flex min-h-[120px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring" placeholder="How can we help you?"></textarea>
                    </div>
                    <button type="submit" class="inline-flex h-10 items-center justify-center rounded-md bg-primary px-8 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90">
                        Send Message
                    </button>
                </form>
            </div>
            
            <div class="grid gap-6 md:grid-cols-3 mt-12 text-center">
                <div>
                    <h3 class="font-bold">Email</h3>
                    <p class="text-sm text-muted-foreground">support@saleshostel.com</p>
                </div>
                <div>
                    <h3 class="font-bold">Phone</h3>
                    <p class="text-sm text-muted-foreground">+234 800 SALESHOSTEL</p>
                </div>
                <div>
                    <h3 class="font-bold">Office</h3>
                    <p class="text-sm text-muted-foreground">Lagos, Nigeria</p>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
