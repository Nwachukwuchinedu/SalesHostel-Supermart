<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO Meta Tags -->
    <title>SalesHostel - Modern Inventory & Sales Management for Retail</title>
    <meta name="description" content="Over 500 businesses use SalesHostel to track sales, manage suppliers, and grow with real-time insights. The all-in-one platform for modern retail.">
    <meta name="keywords" content="inventory management, retail pos, sales tracking, supplier management, business analytics, retail software">
    <meta name="author" content="SalesHostel Digital">
    <link rel="canonical" href="https://shop12mart.com" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://shop12mart.com/">
    <meta property="og:title" content="SalesHostel - Modern Inventory & Sales Management for Retail">
    <meta property="og:description" content="Over 500 businesses use SalesHostel to track sales, manage suppliers, and grow with real-time insights. The all-in-one platform for modern retail.">
    <meta property="og:image" content="https://shop12mart.com/assets/images/og-image.jpg">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://shop12mart.com/">
    <meta property="twitter:title" content="SalesHostel - Modern Inventory & Sales Management for Retail">
    <meta property="twitter:description" content="Over 500 businesses use SalesHostel to track sales, manage suppliers, and grow with real-time insights. The all-in-one platform for modern retail.">
    <meta property="twitter:image" content="https://shop12mart.com/assets/images/og-image.jpg">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "SalesHostel Digital",
      "url": "https://shop12mart.com",
      "logo": "https://shop12mart.com/assets/images/logo.png",
      "description": "SalesHostel is a technology company providing modern inventory and sales management solutions for retail businesses.",
      "foundingDate": "2023",
      "founders": [
        {
          "@type": "Person",
          "name": "Chinedu Nwachukwu"
        }
      ],
      "sameAs": [
        "https://www.facebook.com/saleshostel",
        "https://twitter.com/saleshostel",
        "https://www.linkedin.com/company/saleshostel"
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+234-800-SALESHOSTEL",
        "contactType": "customer service"
      }
    }
    </script>
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "SalesHostel",
      "url": "https://shop12mart.com",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://shop12mart.com/search?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        body: ['"PT Sans"', 'sans-serif'],
                        headline: ['"Playfair Display"', 'serif'],
                        code: ['monospace'],
                    },
                    colors: {
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        card: {
                            DEFAULT: 'hsl(var(--card))',
                            foreground: 'hsl(var(--card-foreground))',
                        },
                        popover: {
                            DEFAULT: 'hsl(var(--popover))',
                            foreground: 'hsl(var(--popover-foreground))',
                        },
                        primary: {
                            DEFAULT: 'hsl(var(--primary))',
                            foreground: 'hsl(var(--primary-foreground))',
                        },
                        secondary: {
                            DEFAULT: 'hsl(var(--secondary))',
                            foreground: 'hsl(var(--secondary-foreground))',
                        },
                        muted: {
                            DEFAULT: 'hsl(var(--muted))',
                            foreground: 'hsl(var(--muted-foreground))',
                        },
                        accent: {
                            DEFAULT: 'hsl(var(--accent))',
                            foreground: 'hsl(var(--accent-foreground))',
                        },
                        destructive: {
                            DEFAULT: 'hsl(var(--destructive))',
                            foreground: 'hsl(var(--destructive-foreground))',
                        },
                        border: 'hsl(var(--border))',
                        input: 'hsl(var(--input))',
                        ring: 'hsl(var(--ring))',
                        chart: {
                            '1': 'hsl(var(--chart-1))',
                            '2': 'hsl(var(--chart-2))',
                            '3': 'hsl(var(--chart-3))',
                            '4': 'hsl(var(--chart-4))',
                            '5': 'hsl(var(--chart-5))',
                        },
                    },
                    borderRadius: {
                        lg: 'var(--radius)',
                        md: 'calc(var(--radius) - 2px)',
                        sm: 'calc(var(--radius) - 4px)',
                    },
                    keyframes: {
                        'accordion-down': {
                            from: { height: '0' },
                            to: { height: 'var(--radix-accordion-content-height)' },
                        },
                        'accordion-up': {
                            from: { height: 'var(--radix-accordion-content-height)' },
                            to: { height: '0' },
                        },
                    },
                    animation: {
                        'accordion-down': 'accordion-down 0.2s ease-out',
                        'accordion-up': 'accordion-up 0.2s ease-out',
                    },
                },
            },
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- GSAP for Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script>
        window.env = {
            API_BASE_URL: "<?php 
                $url = getenv('API_BASE_URL');
                if (!$url && file_exists(__DIR__ . '/../.htaccess')) {
                    $htaccess = file_get_contents(__DIR__ . '/../.htaccess');
                    if (preg_match('/SetEnv\s+API_BASE_URL\s+[\'"]?([^\'"\s]+)[\'"]?/', $htaccess, $matches)) {
                        $url = $matches[1];
                    }
                }
                echo $url; 
            ?>"
        };
    </script>
</head>
<body class="font-body antialiased min-h-screen bg-background font-sans text-foreground">
