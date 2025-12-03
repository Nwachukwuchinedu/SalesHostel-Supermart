<?php 
$pageTitle = "About Us";
$pageDescription = "Learn about Shop12mart, our mission to provide quality products, and the team dedicated to serving you.";
include 'includes/head.php'; 
?>
<?php include 'includes/header.php'; ?>

<main class="flex-1 pt-16">
    <!-- Hero Section -->
    <section class="w-full py-12 md:py-24 lg:py-32 bg-muted/20">
        <div class="container px-4 md:px-6">
            <div class="flex flex-col items-center justify-center space-y-4 text-center">
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold tracking-tighter sm:text-5xl">About Us</h1>
                    <p class="max-w-[900px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                        We are dedicated to providing the best shopping experience for our community.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="w-full py-12 md:py-24 lg:py-32">
        <div class="container px-4 md:px-6">
            <div class="grid gap-10 sm:px-10 md:gap-16 md:grid-cols-2">
                <div class="space-y-4">
                    <div class="inline-block rounded-lg bg-muted px-3 py-1 text-sm">Our Mission</div>
                    <h2 class="lg:leading-tighter text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl xl:text-[3.4rem] 2xl:text-[3.75rem]">
                        Quality Products, Delivered with Care
                    </h2>
                    <p class="mx-auto max-w-[700px] text-muted-foreground md:text-xl/relaxed">
                        At Shop12mart, we believe that everyone deserves access to fresh, high-quality products without the hassle. Our mission is to bridge the gap between local suppliers and your doorstep, ensuring you get the best value for your money.
                    </p>
                </div>
                <div class="flex flex-col items-start space-y-4">
                    <div class="inline-block rounded-lg bg-muted px-3 py-1 text-sm">Our Values</div>
                    <p class="mx-auto max-w-[700px] text-muted-foreground md:text-xl/relaxed">
                        <ul class="grid gap-6">
                            <li class="flex items-center gap-4">
                                <div class="bg-primary/10 p-2 rounded-full text-primary">
                                    <i data-lucide="check" class="h-6 w-6"></i>
                                </div>
                                <span class="font-medium">Customer Satisfaction First</span>
                            </li>
                            <li class="flex items-center gap-4">
                                <div class="bg-primary/10 p-2 rounded-full text-primary">
                                    <i data-lucide="check" class="h-6 w-6"></i>
                                </div>
                                <span class="font-medium">Integrity & Transparency</span>
                            </li>
                            <li class="flex items-center gap-4">
                                <div class="bg-primary/10 p-2 rounded-full text-primary">
                                    <i data-lucide="check" class="h-6 w-6"></i>
                                </div>
                                <span class="font-medium">Community Support</span>
                            </li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="w-full py-12 md:py-24 lg:py-32 bg-muted/20">
        <div class="container px-4 md:px-6">
            <div class="flex flex-col items-center justify-center space-y-4 text-center mb-12">
                <div class="space-y-2">
                    <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl">Meet Our Team</h2>
                    <p class="max-w-[900px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                        The people working hard to serve you better.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex flex-col items-center space-y-4">
                    <div class="h-32 w-32 rounded-full bg-muted flex items-center justify-center overflow-hidden">
                        <i data-lucide="user" class="h-16 w-16 text-muted-foreground"></i>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold">Chinedu Nwachukwu</h3>
                        <p class="text-sm text-muted-foreground">Founder & CEO</p>
                    </div>
                </div>
                <div class="flex flex-col items-center space-y-4">
                    <div class="h-32 w-32 rounded-full bg-muted flex items-center justify-center overflow-hidden">
                        <i data-lucide="user" class="h-16 w-16 text-muted-foreground"></i>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold">Sarah Johnson</h3>
                        <p class="text-sm text-muted-foreground">Head of Operations</p>
                    </div>
                </div>
                <div class="flex flex-col items-center space-y-4">
                    <div class="h-32 w-32 rounded-full bg-muted flex items-center justify-center overflow-hidden">
                        <i data-lucide="user" class="h-16 w-16 text-muted-foreground"></i>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold">David Okon</h3>
                        <p class="text-sm text-muted-foreground">Customer Success Lead</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
