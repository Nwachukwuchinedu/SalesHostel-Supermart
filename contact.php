<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>

<main class="flex-1 pt-16">
    <section class="w-full py-12 md:py-24 lg:py-32">
        <div class="container px-4 md:px-6">
            <div class="grid gap-10 lg:grid-cols-2">
                <div class="space-y-4">
                    <h1 class="text-3xl font-bold tracking-tighter sm:text-5xl">Contact Us</h1>
                    <p class="max-w-[600px] text-muted-foreground md:text-xl/relaxed">
                        Have a question or need assistance? We're here to help. Reach out to us via phone, email, or visit our store.
                    </p>
                    
                    <div class="space-y-4 mt-8">
                        <div class="flex items-center gap-4">
                            <div class="bg-primary/10 p-3 rounded-lg text-primary">
                                <i data-lucide="map-pin" class="h-6 w-6"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold">Visit Us</h3>
                                <p class="text-sm text-muted-foreground">123 Market Road, Lagos, Nigeria</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="bg-primary/10 p-3 rounded-lg text-primary">
                                <i data-lucide="phone" class="h-6 w-6"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold">Call Us</h3>
                                <p class="text-sm text-muted-foreground">+234 800 123 4567</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="bg-primary/10 p-3 rounded-lg text-primary">
                                <i data-lucide="mail" class="h-6 w-6"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold">Email Us</h3>
                                <p class="text-sm text-muted-foreground">support@saleshostel.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="glass-card p-8 rounded-xl">
                    <form class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-medium" for="first-name">First name</label>
                                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="first-name" placeholder="Enter your first name" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium" for="last-name">Last name</label>
                                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="last-name" placeholder="Enter your last name" required>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium" for="email">Email</label>
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="email" placeholder="Enter your email" type="email" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium" for="message">Message</label>
                            <textarea class="flex min-h-[120px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="message" placeholder="Enter your message" required></textarea>
                        </div>
                        <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full" type="submit">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
