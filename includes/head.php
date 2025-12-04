<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <?php
    $pageTitle = isset($pageTitle) ? $pageTitle . ' | Shop12mart' : 'Shop12mart - Your Daily Essentials Delivered';
    $pageDescription = isset($pageDescription) ? $pageDescription : 'Shop for groceries, household items, and daily essentials at Shop12mart. Fast delivery, quality products, and secure payments.';
    $pageUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $pageImage = "https://$_SERVER[HTTP_HOST]/assets/images/og-image.png";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <link rel="canonical" href="<?php echo htmlspecialchars($pageUrl); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($pageUrl); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($pageImage); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo htmlspecialchars($pageUrl); ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="twitter:image" content="<?php echo htmlspecialchars($pageImage); ?>">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Shop12mart",
      "url": "https://shop12mart.com/",
      "logo": "https://shop12mart.com/assets/images/favicon.svg",
      "sameAs": [
        "https://www.facebook.com/shop12mart",
        "https://twitter.com/shop12mart",
        "https://www.instagram.com/shop12mart"
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+234-800-123-4567",
        "contactType": "customer service",
        "areaServed": "NG",
        "availableLanguage": "en"
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "Shop12mart",
      "url": "https://shop12mart.com/",
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
