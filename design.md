# SalesHostel Digital - Design System & Architecture

## 1. Brand Identity & Global Aesthetics
**Core Vibe:** Modern, Professional, Efficient, and Trustworthy. A blend of "Fintech Clean" and "E-commerce Vibrant".
**Typography:** 
- **Headlines:** `Playfair Display` (Serif) - Adds a touch of premium/trust.
- **Body:** `PT Sans` (Sans-serif) - High readability for data-dense interfaces.
**Color Palette:**
- **Primary:** `hsl(var(--primary))` (Deep Blue/Indigo) - Trust & Stability.
- **Secondary:** `hsl(var(--secondary))` (Soft Teal/Cyan) - Growth & Activity.
- **Background:** `hsl(var(--background))` (Clean White/Light Gray).
- **Surface:** `hsl(var(--card))` (White with subtle borders).
**Visual Effects:**
- **Glassmorphism:** Used on modals, floating navbars, and toast notifications (`backdrop-filter: blur(12px)`).
- **Shadows:** Soft, diffused shadows (`box-shadow: 0 4px 20px -2px rgba(0,0,0,0.05)`).
- **Borders:** Subtle 1px borders (`border-color: hsl(var(--border))`).

---

## 2. Page Architecture & Flow

### A. Landing Page (`index.php`)
**Goal:** Convert visitors into users. Showcase features and trust.
**Layout:**
1.  **Navbar:** Sticky, glassmorphic. Logo left, Links center, "Login/Get Started" buttons right.
    *   *Animation:* Slides down from top on load.
2.  **Hero Section:**
    *   **Background:** Unequal and uneven faded global grid background with large, organic "holes" or voids to create depth and focus.
    *   **Left:** Large Headline ("Manage Your Inventory with Confidence"), Subtext, Dual CTA ("Start Free", "View Demo").
    *   **Right:** 3D Abstract Illustration or a floating UI mockup of the dashboard that tilts on mouse move.
    *   *Animation:* Text staggers in (fade-up). Hero image floats gently.
3.  **Features Section (Bento Grid):**
    *   Grid layout showcasing: "Real-time Tracking", "Sales Reports", "Supplier Management".
    *   *Interaction:* Cards scale up slightly (1.02x) and cast a deeper shadow on hover.
4.  **Stats/Social Proof:** Horizontal strip with animated counters (e.g., "10k+ Transactions Processed").
5.  **Footer:** Clean 4-column layout.

### B. Authentication (`login.php`, `signup.php`)
**Goal:** Frictionless entry.
**Layout:**
-   **Split Screen:**
    -   **Left (50%):** Branding, Testimonial quote, or abstract animated background pattern.
    -   **Right (50%):** The Form.
-   **Form Design:**
    -   Clean input fields with floating labels or subtle placeholder transitions.
    -   "Remember Me" and "Forgot Password" clearly visible.
    -   *Animation:* Form container slides in from the right. Input borders glow on focus.
    -   *Button:* Width-filling primary button with a loading spinner state on click.

### C. Dashboard Layout (Global)
**Goal:** Maximized workspace, easy navigation.
**Structure:**
1.  **Sidebar (Left):**
    -   Logo at top.
    -   Navigation Links (Dashboard, Products, Purchases, Supplies, Reports).
    -   Active state: Light background highlight + colored icon + right border strip.
    -   *Interaction:* Collapsible on mobile (hamburger menu).
2.  **Top Header:**
    -   Breadcrumbs (e.g., Home > Purchases).
    -   Global Search Bar (Cmd+K style).
    -   User Profile Dropdown & Notifications Bell.
3.  **Main Content Area:**
    -   Padding: `p-6` or `p-8`.
    -   Background: `bg-muted/40` to differentiate from white cards.

### D. Dashboard Overview (`dashboard/index.php`)
**Goal:** At-a-glance health check.
**Components:**
1.  **Welcome Banner:** "Good Morning, [User]". Date display.
2.  **KPI Cards (Grid):**
    -   Total Revenue, Sales Count, Low Stock Items, Pending Orders.
    -   *Visual:* Icons with soft colored backgrounds (e.g., Green bg for Money icon).
    -   *Animation:* Numbers count up from 0 to final value on load.
3.  **Charts Section:**
    -   **Main Chart:** Monthly Revenue (Bar/Line).
    -   *Animation:* Bars grow from bottom up. Tooltips fade in on hover.
4.  **Recent Activity Table:**
    -   Simplified table showing last 5 transactions.
    -   *Interaction:* Rows highlight on hover. "View All" link.

### E. Purchases Page (`dashboard/purchases.php`)
**Goal:** Record and manage sales/outbound stock.
**Layout:**
1.  **Header:** Title "Purchases" + "New Purchase" Button (Primary).
2.  **Filter Bar:** Search input, Date Range Picker, Status Dropdown (Paid/Pending).
3.  **Data Table:**
    -   Columns: ID, Customer, Date, Items, Total, Status, Actions.
    -   **Status Badges:** Pill-shaped, colored backgrounds (Green=Paid, Yellow=Pending, Red=Cancelled).
    -   *Animation:* Table rows fade in sequentially (staggered).
4.  **"New Purchase" Modal:**
    -   **Customer Selection:** Searchable dropdown (Select2 style).
    -   **Product Rows:** Dynamic list. "Add Item" button adds a new row with animation.
    -   **Live Totals:** Subtotal/Total updates instantly as quantity changes.
    -   *Transition:* Modal scales in from center with a backdrop blur.

### F. Supplies Page (`dashboard/supplies.php`)
**Goal:** Manage inbound stock/inventory.
**Layout:**
-   Similar structure to Purchases.
-   **Key Difference:** Focus on "Supplier" instead of "Customer".
-   **Visual Cue:** Use a distinct accent color for Supply-related actions (e.g., Teal/Cyan) to differentiate from Sales (Blue/Indigo).

### G. Products Page (`dashboard/products.php`)
**Goal:** Inventory management.
**Layout:**
1.  **Grid vs List View:** Toggle button.
    -   **List:** Standard table for editing data.
    -   **Grid:** Card view showing Product Image, Name, Stock Level, Price.
2.  **Stock Indicators:**
    -   Progress bar showing stock level relative to max capacity.
    -   Red highlight if stock < threshold.
3.  **Add/Edit Drawer:**
    -   Instead of a modal, a side drawer slides in from the right for editing product details.
    -   *Animation:* `transform: translateX(0)` slide-in effect.

### H. Reports Page (`dashboard/reports.php`)
**Goal:** Deep dive into data.
**Layout:**
1.  **Tab Navigation:** Sales Report | Inventory Report | Profit/Loss.
2.  **Interactive Charts:**
    -   Doughnut chart for "Top Selling Categories".
    -   Area chart for "Revenue Trends".
3.  **Export Actions:** Buttons to Download PDF/CSV with hover lift effect.

---

## 3. Animation & Transition Guidelines
**Philosophy:** Motion should be purposeful, not distracting.
**Library:** **Framer Motion** (via CDN/ES Modules for React parts) or **Motion One** / **GSAP** for vanilla PHP integration to achieve "Framer-like" quality.
1.  **Page Transitions:**
    -   Content fades in (`opacity: 0` -> `1`) and slides up slightly (`translateY(10px)` -> `0`) on navigation.
2.  **Micro-interactions:**
    -   **Buttons:** Scale down (`0.98`) on click.
    -   **Inputs:** Border color transition (`0.2s ease`).
    -   **Dropdowns:** Fade and scale in from top-left.
3.  **Loading States:**
    -   Use **Skeleton Loaders** (shimmer effect) instead of spinning wheels for data tables and cards.

## 4. Technical Implementation Notes
-   **CSS Framework:** Tailwind CSS (via CDN for simplicity in PHP, or built assets).
-   **Icons:** Lucide Icons (consistent stroke width).
-   **Charts:** Chart.js (responsive, animated).
-   **Animation Engine:** **Framer Motion** (if React components are used) or **GSAP/Motion One** (for vanilla JS) to replicate Framer Motion physics.
-   **Modals/Interactions:** Vanilla JS or Alpine.js for lightweight reactivity.