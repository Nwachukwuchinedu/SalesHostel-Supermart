<?php include '../includes/head.php'; ?>

<?php
// Mock Data for Select Options
$customers = [
    ['id' => 1, 'name' => 'Liam Johnson'],
    ['id' => 2, 'name' => 'Olivia Smith'],
    ['id' => 3, 'name' => 'Noah Williams'],
];
$suppliers = [
    ['id' => 1, 'name' => 'Fresh Farms Ltd'],
    ['id' => 2, 'name' => 'Bakery Supplies Co'],
];
$staff = [
    ['id' => 1, 'name' => 'Admin User'],
    ['id' => 2, 'name' => 'Staff Member'],
];

// Handle Form Submission (Mock Logic)
$reportGenerated = false;
$salesReport = "";
$financialInsights = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reportGenerated = true;
    $startDate = $_POST['startDate'] ?? '';
    $endDate = $_POST['endDate'] ?? '';
    $reportType = $_POST['reportType'] ?? 'general';
    
    // Mock Response
    $salesReport = "Sales Report Summary\n\nPeriod: $startDate to $endDate\nType: " . ucfirst($reportType) . "\n\nTotal Sales: ₦1,250,000.00\nTotal Orders: 450\nAverage Order Value: ₦2,777.78\n\nTop Selling Product: Organic Fuji Apples";
    $financialInsights = "AI-Powered Insights\n\n- Sales have increased by 15% compared to the previous period.\n- Customer retention rate is steady at 85%.\n- Consider restocking 'Artisanal Sourdough' as inventory is running low.\n- Peak sales hours are between 4 PM and 7 PM.";
}
?>

<div class="flex min-h-screen w-full flex-col bg-muted/20">
    <?php include '../includes/sidebar.php'; ?>
    
    <div class="flex flex-col sm:gap-4 sm:py-4 md:ml-64 transition-all duration-300">
        <?php include '../includes/dashboard_header.php'; ?>
        
        <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <div class="flex flex-col gap-8 min-w-0 fade-up">
                <div>
                    <h1 class="text-3xl font-headline font-bold tracking-tight">
                        Reports
                    </h1>
                    <p class="text-muted-foreground">
                        Generate summaries and AI-powered insights.
                    </p>
                </div>

                <div class="glass-card rounded-xl p-6">
                    <form method="POST" action="">
                        <div class="flex flex-col space-y-1.5 mb-6">
                            <h3 class="font-semibold leading-none tracking-tight text-lg">Generate a New Report</h3>
                            <p class="text-sm text-muted-foreground">
                                Select a date range and filters to generate a sales report and get AI-powered insights.
                            </p>
                        </div>
                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="grid gap-2">
                                <label class="text-sm font-medium leading-none" for="start-date">Start Date</label>
                                <input class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary" id="start-date" name="startDate" type="date" value="<?php echo date('Y-m-01'); ?>">
                            </div>
                            <div class="grid gap-2">
                                <label class="text-sm font-medium leading-none" for="end-date">End Date</label>
                                <input class="flex h-10 w-full rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary" id="end-date" name="endDate" type="date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="grid gap-2">
                                <label class="text-sm font-medium leading-none" for="reportType">Report Type</label>
                                <select id="reportType" name="reportType" onchange="toggleFilters()" class="flex h-10 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                                    <option value="general">General</option>
                                    <option value="customer">By Customer</option>
                                    <option value="supplier">By Supplier</option>
                                    <option value="staff">By Staff</option>
                                </select>
                            </div>
                            
                            <!-- Dynamic Filters -->
                            <div id="customerFilter" class="grid gap-2 hidden animate-in fade-in slide-in-from-top-2 duration-200">
                                <label class="text-sm font-medium leading-none" for="customer">Customer</label>
                                <select name="customer" class="flex h-10 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                                    <option value="">Select a customer</option>
                                    <?php foreach ($customers as $c): ?>
                                        <option value="<?php echo $c['name']; ?>"><?php echo $c['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="supplierFilter" class="grid gap-2 hidden animate-in fade-in slide-in-from-top-2 duration-200">
                                <label class="text-sm font-medium leading-none" for="supplier">Supplier</label>
                                <select name="supplier" class="flex h-10 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                                    <option value="">Select a supplier</option>
                                    <?php foreach ($suppliers as $s): ?>
                                        <option value="<?php echo $s['name']; ?>"><?php echo $s['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="staffFilter" class="grid gap-2 hidden animate-in fade-in slide-in-from-top-2 duration-200">
                                <label class="text-sm font-medium leading-none" for="staff">Staff</label>
                                <select name="staff" class="flex h-10 w-full items-center justify-between rounded-lg border border-input bg-background/50 px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-all duration-200 focus:border-primary">
                                    <option value="">Select a staff member</option>
                                    <?php foreach ($staff as $s): ?>
                                        <option value="<?php echo $s['name']; ?>"><?php echo $s['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="flex items-center pt-6 mt-2">
                            <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-0.5 transition-all duration-200">
                                <i data-lucide="file-bar-chart" class="mr-2 h-4 w-4"></i>
                                Generate Report
                            </button>
                        </div>
                    </form>
                </div>

                <?php if ($reportGenerated): ?>
                <div class="grid gap-8 lg:grid-cols-2 fade-up" style="animation-delay: 0.2s;">
                    <div class="glass-card rounded-xl p-6 space-y-4">
                        <div class="flex flex-row items-center gap-2 pb-2 border-b border-border/50">
                            <div class="p-2 bg-primary/10 rounded-lg text-primary">
                                <i data-lucide="wand" class="h-5 w-5"></i>
                            </div>
                            <h3 class="font-semibold leading-none tracking-tight text-lg">Sales Report Summary</h3>
                        </div>
                        <div class="pt-2">
                            <p class="text-sm text-muted-foreground whitespace-pre-wrap leading-relaxed"><?php echo nl2br($salesReport); ?></p>
                        </div>
                    </div>
                    <div class="glass-card rounded-xl p-6 space-y-4">
                        <div class="flex flex-row items-center gap-2 pb-2 border-b border-border/50">
                            <div class="p-2 bg-purple-500/10 rounded-lg text-purple-600">
                                <i data-lucide="bot" class="h-5 w-5"></i>
                            </div>
                            <h3 class="font-semibold leading-none tracking-tight text-lg">AI-Powered Insights</h3>
                        </div>
                        <div class="pt-2">
                            <p class="text-sm text-muted-foreground whitespace-pre-wrap leading-relaxed"><?php echo nl2br($financialInsights); ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<script src="/assets/js/config.js"></script>
<script src="/assets/js/api.js"></script>
<script src="/assets/js/main.js"></script>
<script>
    lucide.createIcons();
    
    // GSAP Animations
    document.addEventListener('DOMContentLoaded', () => {
        gsap.to(".fade-up", {
            y: 0,
            opacity: 1,
            duration: 0.6,
            stagger: 0.1,
            ease: "power2.out"
        });
    });
    
    // Sidebar Toggle Logic
    const openSidebarBtn = document.getElementById('open-sidebar');
    const closeSidebarBtn = document.getElementById('close-sidebar');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');

    if (openSidebarBtn && mobileSidebar && mobileSidebarOverlay) {
        openSidebarBtn.addEventListener('click', () => {
            mobileSidebar.classList.remove('-translate-x-full');
            mobileSidebarOverlay.classList.remove('hidden');
        });

        const closeSidebar = () => {
            mobileSidebar.classList.add('-translate-x-full');
            mobileSidebarOverlay.classList.add('hidden');
        };

        closeSidebarBtn.addEventListener('click', closeSidebar);
        mobileSidebarOverlay.addEventListener('click', closeSidebar);
    }

    // Filter Toggle Logic
    function toggleFilters() {
        const reportType = document.getElementById('reportType').value;
        document.getElementById('customerFilter').classList.add('hidden');
        document.getElementById('supplierFilter').classList.add('hidden');
        document.getElementById('staffFilter').classList.add('hidden');

        if (reportType === 'customer') {
            document.getElementById('customerFilter').classList.remove('hidden');
        } else if (reportType === 'supplier') {
            document.getElementById('supplierFilter').classList.remove('hidden');
        } else if (reportType === 'staff') {
            document.getElementById('staffFilter').classList.remove('hidden');
        }
    }
</script>
</body>
</html>
