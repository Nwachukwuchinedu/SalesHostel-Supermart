<?php include 'includes/header.php'; ?>

<?php
// Mock Data
$products = [
    [
        "id" => "1",
        "name" => "Organic Fuji Apples",
        "sellingPrice" => 2.99,
        "imageUrl" => "https://images.unsplash.com/photo-1579613832125-5d34a13ffe2a?q=80&w=2070&auto=format&fit=crop",
    ],
    [
        "id" => "2",
        "name" => "Artisanal Sourdough",
        "sellingPrice" => 5.5,
        "imageUrl" => "https://images.unsplash.com/photo-1589981525979-683c313316d3?q=80&w=2070&auto=format&fit=crop",
    ],
    [
        "id" => "3",
        "name" => "Fresh Almond Milk",
        "sellingPrice" => 3.75,
        "imageUrl" => "https://images.unsplash.com/photo-1620189507195-68309c04c4d8?q=80&w=2070&auto=format&fit=crop",
    ],
    [
        "id" => "4",
        "name" => "Chicken Breast",
        "sellingPrice" => 9.99,
        "imageUrl" => "https://images.unsplash.com/photo-1604503468734-b3c8b4e78?q=80&w=1974&auto=format&fit=crop",
    ],
];

$categories = [
    ["name" => "Fruits", "icon" => "🍎"],
    ["name" => "Bakery", "icon" => "🍞"],
    ["name" => "Beverages", "icon" => "🥤"],
    ["name" => "Meat", "icon" => "🥩"],
    ["name" => "Dairy", "icon" => "🧀"],
    ["name" => "Vegetables", "icon" => "🥦"],
    ["name" => "Snacks", "icon" => "🍿"],
    ["name" => "Seafood", "icon" => "🦐"],
];

$features = [
    [
        "icon" => "search",
        "title" => "Wide Product Selection",
        "description" => "Browse our extensive catalog of high-quality products. From fresh produce to household essentials, find everything you need in one place.",
    ],
    [
        "icon" => "wallet",
        "title" => "Simple & Secure Checkout",
        "description" => "Enjoy a seamless shopping experience with our easy-to-use and secure checkout process. Your order is just a few clicks away.",
    ],
    [
        "icon" => "truck",
        "title" => "Fast, Reliable Delivery",
        "description" => "Get your favorite products delivered right to your doorstep. We ensure your order arrives fresh and on time, every time.",
    ],
    [
        "icon" => "shield-check",
        "title" => "Quality You Can Trust",
        "description" => "We partner with the best suppliers to bring you fresh, high-quality products. Your satisfaction is our top priority.",
    ],
];
?>

<div class="flex flex-col min-h-screen bg-background">
    <main class="flex-1">
        <!-- Hero Section -->
        <section class="w-full py-20 md:py-32 lg:py-40 bg-card/50">
            <div class="container mx-auto px-4 md:px-6">
                <div class="grid gap-6 lg:grid-cols-2 lg:gap-12">
                    <div class="flex flex-col justify-center space-y-4">
                        <div class="space-y-2">
                            <h1 class="text-4xl font-headline font-bold tracking-tighter sm:text-5xl md:text-6xl text-primary">
                                Your Favorite Goods, Delivered Fast
                            </h1>
                            <p class="max-w-[600px] text-muted-foreground md:text-xl">
                                SalesHostel Digital makes it easier than ever to shop for groceries and essentials. Quality products, seamless ordering, and quick delivery.
                            </p>
                        </div>
                        <div class="flex flex-col gap-2 min-[400px]:flex-row">
                            <a href="signup.php" class="inline-flex h-10 items-center justify-center rounded-md bg-primary px-8 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50">
                                Start Shopping
                            </a>
                            <a href="#features" class="inline-flex h-10 items-center justify-center rounded-md border border-input bg-background px-8 text-sm font-medium shadow-sm transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50">
                                Learn More
                            </a>
                        </div>
                    </div>
                    <img
                        src="https://picsum.photos/seed/5/600/400"
                        width="600"
                        height="400"
                        alt="Hero"
                        class="mx-auto aspect-video overflow-hidden rounded-xl object-cover sm:w-full lg:order-last"
                    />
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="w-full py-12 md:py-20 bg-background">
            <div class="container mx-auto px-4 md:px-6">
                <h2 class="text-3xl font-headline font-bold tracking-tight text-center mb-12">
                    Endless Categories
                </h2>
                <!-- Simple Horizontal Scroll Carousel -->
                <div class="w-full overflow-x-auto pb-4 hide-scrollbar">
                    <div class="flex gap-4">
                        <?php foreach ($categories as $category): ?>
                            <div class="flex-none w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8">
                                <div class="p-1">
                                    <div class="rounded-xl border bg-card text-card-foreground shadow hover:shadow-lg transition-shadow duration-300">
                                        <div class="flex flex-col items-center justify-center aspect-square p-4">
                                            <div class="text-4xl mb-2"><?php echo $category['icon']; ?></div>
                                            <p class="text-sm font-medium text-center">
                                                <?php echo $category['name']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products Section -->
        <section id="products" class="w-full py-12 md:py-20 bg-card/50">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex flex-col items-center justify-center space-y-4 text-center">
                    <div class="space-y-2">
                        <h2 class="text-3xl font-headline font-bold tracking-tight sm:text-4xl">
                            Featured Products
                        </h2>
                        <p class="max-w-[900px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                            Discover a selection of our finest products, all available for quick and easy purchase.
                        </p>
                    </div>
                </div>
                <div class="mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 pt-12">
                    <?php foreach ($products as $product): ?>
                        <div class="rounded-xl border bg-card text-card-foreground shadow overflow-hidden transition-transform duration-300 ease-in-out hover:-translate-y-2 hover:shadow-xl">
                            <img
                                src="<?php echo $product['imageUrl']; ?>"
                                alt="<?php echo $product['name']; ?>"
                                width="400"
                                height="300"
                                class="object-cover w-full h-48"
                            />
                            <div class="p-4">
                                <h3 class="text-lg font-bold"><?php echo $product['name']; ?></h3>
                                <p class="text-2xl font-headline text-primary">
                                    ₦<?php echo number_format($product['sellingPrice'], 2); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="w-full py-12 md:py-24 lg:py-32">
            <div class="container mx-auto space-y-12 px-4 md:px-6">
                <div class="flex flex-col items-center justify-center space-y-4 text-center">
                    <div class="space-y-2">
                        <h2 class="text-3xl font-headline font-bold tracking-tighter sm:text-5xl">
                            Why Shop With SalesHostel Digital?
                        </h2>
                        <p class="max-w-[900px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                            We provide a seamless and enjoyable shopping experience from start to finish.
                        </p>
                    </div>
                </div>
                <div class="mx-auto grid items-start gap-8 sm:max-w-4xl sm:grid-cols-2 md:gap-12 lg:max-w-5xl lg:grid-cols-2">
                    <?php foreach ($features as $feature): ?>
                        <div class="flex gap-4 items-start">
                            <div class="bg-primary/10 text-primary p-3 rounded-full">
                                <i data-lucide="<?php echo $feature['icon']; ?>" class="h-6 w-6"></i>
                            </div>
                            <div class="grid gap-1">
                                <h3 class="text-lg font-bold"><?php echo $feature['title']; ?></h3>
                                <p class="text-sm text-muted-foreground">
                                    <?php echo $feature['description']; ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="w-full py-12 md:py-24 lg:py-32 bg-primary text-primary-foreground">
            <div class="container mx-auto grid items-center justify-center gap-4 px-4 text-center md:px-6">
                <div class="space-y-3">
                    <h2 class="text-3xl font-headline font-bold tracking-tighter md:text-4xl/tight">
                        Ready to Start Shopping?
                    </h2>
                    <p class="mx-auto max-w-[600px] text-primary-foreground/80 md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                        Sign up today and get access to fresh products and amazing deals.
                    </p>
                </div>
                <div class="mx-auto w-full max-w-sm space-y-2">
                    <a href="signup.php" class="inline-flex h-12 items-center justify-center rounded-md bg-background px-8 text-lg font-medium text-primary shadow-lg transition-colors hover:bg-background/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                        Sign Up for Free
                    </a>
                </div>
            </div>
        </section>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
