
"use client";

import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import {
  Carousel,
  CarouselContent,
  CarouselItem,
} from "@/components/ui/carousel";
import { placeHolderImages } from "@/lib/placeholder-images";
import { cn } from "@/lib/utils";
import Autoplay from "embla-carousel-autoplay";
import {
  BarChart,
  Box,
  Cpu,
  ShoppingCart,
  Truck,
  ArrowRight,
} from "lucide-react";
import Image from "next/image";
import Link from "next/link";
import { useRef } from "react";
import { Product, Group, UniqueName } from "@/lib/types";

// Mock data as we don't have endpoints for this on landing page
const products: Partial<Product>[] = [
  {
    id: "1",
    name: "Organic Fuji Apples",
    sellingPrice: 2.99,
    imageUrl:
      "https://images.unsplash.com/photo-1579613832125-5d34a13ffe2a?q=80&w=2070&auto=format&fit=crop",
  },
  {
    id: "2",
    name: "Artisanal Sourdough",
    sellingPrice: 5.5,
    imageUrl:
      "https://images.unsplash.com/photo-1589981525979-683c313316d3?q=80&w=2070&auto=format&fit=crop",
  },
  {
    id: "3",
    name: "Fresh Almond Milk",
    sellingPrice: 3.75,
    imageUrl:
      "https://images.unsplash.com/photo-1620189507195-68309c04c4d8?q=80&w=2070&auto=format&fit=crop",
  },
  {
    id: "4",
    name: "Chicken Breast",
    sellingPrice: 9.99,
    imageUrl:
      "https://images.unsplash.com/photo-1604503468734-b爬j3c8b4e78?q=80&w=1974&auto=format&fit=crop",
  },
];

const categories = [
  { name: "Fruits", icon: "🍎" },
  { name: "Bakery", icon: "🍞" },
  { name: "Beverages", icon: "🥤" },
  { name: "Meat", icon: "🥩" },
  { name: "Dairy", icon: "🧀" },
  { name: "Vegetables", icon: "🥦" },
  { name: "Snacks", icon: "🍿" },
  { name: "Seafood", icon: "🦐" },
];

const features = [
  {
    icon: Box,
    title: "Effortless Inventory Management",
    description:
      "Keep track of your stock levels in real-time. Add new products, manage categories, and never run out of your best-sellers.",
  },
  {
    icon: ShoppingCart,
    title: "Streamlined Purchase Tracking",
    description:
      "Record every sale with our intuitive point-of-sale interface. View purchase history, manage orders, and print receipts with ease.",
  },
  {
    icon: Truck,
    title: "Simplified Supply Chain",
    description:
      "Log incoming supplies from your vendors. Keep an eye on costs and ensure your inventory is always up-to-date.",
  },
  {
    icon: Cpu,
    title: "AI-Powered Reporting",
    description:
      "Generate insightful sales summaries and financial reports with the power of AI. Make data-driven decisions to grow your business.",
  },
];

export default function LandingPage() {
  const plugin = useRef(Autoplay({ delay: 2000, stopOnInteraction: false }));

  return (
    <div className="flex flex-col min-h-screen bg-background">
      <main className="flex-1">
        {/* Hero Section */}
        <section className="w-full py-20 md:py-32 lg:py-40 bg-card/50">
          <div className="container mx-auto px-4 md:px-6">
            <div className="grid gap-6 lg:grid-cols-2 lg:gap-12">
              <div className="flex flex-col justify-center space-y-4">
                <div className="space-y-2">
                  <h1 className="text-4xl font-headline font-bold tracking-tighter sm:text-5xl md:text-6xl text-primary">
                    Streamline Your Business Operations
                  </h1>
                  <p className="max-w-[600px] text-muted-foreground md:text-xl">
                    SalesHostel Digital provides a complete suite of tools for
                    inventory management, sales tracking, and AI-powered
                    reporting to help you grow.
                  </p>
                </div>
                <div className="flex flex-col gap-2 min-[400px]:flex-row">
                  <Link
                    href="/signup"
                    className={cn(
                      "inline-flex h-10 items-center justify-center rounded-md bg-primary px-8 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
                    )}
                  >
                    Get Started
                  </Link>
                  <Link
                    href="#features"
                    className={cn(
                      "inline-flex h-10 items-center justify-center rounded-md border border-input bg-background px-8 text-sm font-medium shadow-sm transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
                    )}
                  >
                    Learn More
                  </Link>
                </div>
              </div>
              <Image
                src={placeHolderImages.find((img) => img.id === '5')?.imageUrl || "https://picsum.photos/seed/5/600/400"}
                width={600}
                height={400}
                alt="Hero"
                data-ai-hint="business dashboard"
                className="mx-auto aspect-video overflow-hidden rounded-xl object-cover sm:w-full lg:order-last"
              />
            </div>
          </div>
        </section>

        {/* Categories Section */}
        <section className="w-full py-12 md:py-20 bg-background">
          <div className="container mx-auto px-4 md:px-6">
            <h2 className="text-3xl font-headline font-bold tracking-tight text-center mb-12">
              Endless Categories
            </h2>
            <Carousel
              className="w-full"
              plugins={[plugin.current]}
              onMouseEnter={() => plugin.current.stop()}
              onMouseLeave={() => plugin.current.play()}
              opts={{
                align: "start",
                loop: true,
              }}
            >
              <CarouselContent className="-ml-4">
                {[...categories, ...categories].map((category, index) => (
                  <CarouselItem
                    key={index}
                    className="basis-1/2 sm:basis-1/3 md:basis-1/4 lg:basis-1/6 xl:basis-1/8 pl-4"
                  >
                    <div className="p-1">
                      <Card className="hover:shadow-lg transition-shadow duration-300">
                        <CardContent className="flex flex-col items-center justify-center aspect-square p-4">
                          <div className="text-4xl mb-2">{category.icon}</div>
                          <p className="text-sm font-medium text-center">
                            {category.name}
                          </p>
                        </CardContent>
                      </Card>
                    </div>
                  </CarouselItem>
                ))}
              </CarouselContent>
            </Carousel>
          </div>
        </section>

        {/* Featured Products Section */}
        <section
          id="products"
          className="w-full py-12 md:py-20 bg-card/50"
        >
          <div className="container mx-auto px-4 md:px-6">
            <div className="flex flex-col items-center justify-center space-y-4 text-center">
              <div className="space-y-2">
                <h2 className="text-3xl font-headline font-bold tracking-tight sm:text-4xl">
                  Featured Products
                </h2>
                <p className="max-w-[900px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                  Discover a selection of our finest products, managed
                  effortlessly with our inventory system.
                </p>
              </div>
            </div>
            <div className="mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 pt-12">
              {products.map((product) => (
                <Card
                  key={product.id}
                  className="overflow-hidden transition-transform duration-300 ease-in-out hover:-translate-y-2 hover:shadow-xl"
                >
                  <Image
                    src={product.imageUrl || "https://picsum.photos/seed/6/400/300"}
                    alt={product.name || "Product Image"}
                    width={400}
                    height={300}
                    data-ai-hint="product image"
                    className="object-cover w-full h-48"
                  />
                  <CardContent className="p-4">
                    <h3 className="text-lg font-bold">{product.name}</h3>
                    <p className="text-2xl font-headline text-primary">
                      ₦{product.sellingPrice?.toFixed(2)}
                    </p>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </section>

        {/* Features Section */}
        <section id="features" className="w-full py-12 md:py-24 lg:py-32">
          <div className="container mx-auto space-y-12 px-4 md:px-6">
            <div className="flex flex-col items-center justify-center space-y-4 text-center">
              <div className="space-y-2">
                <h2 className="text-3xl font-headline font-bold tracking-tighter sm:text-5xl">
                  Powerful Tools for Your Business
                </h2>
                <p className="max-w-[900px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                  Everything you need to manage your sales and inventory, all
                  in one place.
                </p>
              </div>
            </div>
            <div className="mx-auto grid items-start gap-8 sm:max-w-4xl sm:grid-cols-2 md:gap-12 lg:max-w-5xl lg:grid-cols-2">
              {features.map((feature, index) => (
                <div
                  key={index}
                  className="flex gap-4 items-start"
                >
                  <div className="bg-primary/10 text-primary p-3 rounded-full">
                    <feature.icon className="h-6 w-6" />
                  </div>
                  <div className="grid gap-1">
                    <h3 className="text-lg font-bold">{feature.title}</h3>
                    <p className="text-sm text-muted-foreground">
                      {feature.description}
                    </p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* CTA Section */}
        <section className="w-full py-12 md:py-24 lg:py-32 bg-primary text-primary-foreground">
          <div className="container mx-auto grid items-center justify-center gap-4 px-4 text-center md:px-6">
            <div className="space-y-3">
              <h2 className="text-3xl font-headline font-bold tracking-tighter md:text-4xl/tight">
                Ready to Take Control of Your Business?
              </h2>
              <p className="mx-auto max-w-[600px] text-primary-foreground/80 md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                Sign up today and start managing your sales and inventory like a
                pro.
              </p>
            </div>
            <div className="mx-auto w-full max-w-sm space-y-2">
              <Link
                href="/signup"
                className="inline-flex h-12 items-center justify-center rounded-md bg-background px-8 text-lg font-medium text-primary shadow-lg transition-colors hover:bg-background/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
              >
                Sign Up for Free
              </Link>
            </div>
          </div>
        </section>
      </main>
    </div>
  );
}
