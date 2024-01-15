<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include 'header.php';
include('dbcon.php');

$todayttc = date("Y-m-d");
$queryttc = "SELECT SUM(qc_total) AS today_cons_sale FROM quotecons WHERE DATE(qc_issuedate) = '$todayttc'";
$resultttc = mysqli_query($con, $queryttc);

if (!$resultttc) {
    die("Error in SQL query: " . mysqli_error($con));
}

$rowttc = mysqli_fetch_assoc($resultttc);
$todayConsSale = $rowttc['today_cons_sale'];

$querytc = "SELECT SUM(qc_total) AS total_cons_sale FROM quotecons";
$resulttc = mysqli_query($con, $querytc);
$rowtc = mysqli_fetch_assoc($resulttc);
$totalConsSale = $rowtc['total_cons_sale'];

$selectedDuration = isset($_GET['duration']) ? $_GET['duration'] : 'monthly';

switch ($selectedDuration) {
    case 'weekly':
        $dateColumn = "WEEK(qc_issuedate)";
        $dateFormat = "Week %U";
        break;
    case 'monthly':
        $dateColumn = "DATE_FORMAT(qc_issuedate, '%Y-%m')";
        $dateFormat = "%b %Y";
        break;
    case 'annual':
        $dateColumn = "YEAR(qc_issuedate)";
        $dateFormat = "Year %Y";
        break;
    default:
        $dateColumn = "DATE_FORMAT(qc_issuedate, '%Y-%m')";
        $dateFormat = "%b %Y";
}

$financeQuery = "SELECT $dateColumn AS date, SUM(qc_total) AS total_amount
                 FROM quotecons
                 GROUP BY date
                 ORDER BY date";
$financeResult = mysqli_query($con, $financeQuery);

if (!$financeResult) {
    die("Error in SQL query: " . mysqli_error($con));
}

$dates = [];
$totalAmounts = [];

while ($financeRow = mysqli_fetch_assoc($financeResult)) {
    $dates[] = $financeRow['date'];
    $totalAmounts[] = $financeRow['total_amount'];
}

$todayDate = date("Y-m-d");

$selectedDurationAds = isset($_GET['duration']) ? $_GET['duration'] : 'monthly';

switch ($selectedDurationAds) {
    case 'weekly':
        $dateColumnAds = "WEEK(o.o_date)";
        $dateFormatAds = "Week %U";
        break;
    case 'monthly':
        $dateColumnAds = "DATE_FORMAT(o.o_date, '%Y-%m')";
        $dateFormatAds = "%b %Y";
        break;
    case 'annual':
        $dateColumnAds = "YEAR(o.o_date)";
        $dateFormatAds = "Year %Y";
        break;
    default:
        $dateColumnAds = "DATE_FORMAT(o.o_date, '%Y-%m')";
        $dateFormatAds = "%b %Y";
}

$financeAdsQuery = "SELECT $dateColumnAds AS date, SUM(o.grand_total) AS total_amount
                   FROM tb_order o
                   GROUP BY date
                   ORDER BY date";
$financeAdsResult = mysqli_query($con, $financeAdsQuery);

if (!$financeAdsResult) {
    die("Error in SQL query: " . mysqli_error($con));
}

$adsDates = [];
$adsTotalAmounts = [];

while ($financeAdsRow = mysqli_fetch_assoc($financeAdsResult)) {
    $adsDates[] = $financeAdsRow['date'];
    $adsTotalAmounts[] = $financeAdsRow['total_amount'];
}

$todayDate = date("Y-m-d");

// Fetch Today Ads Sale from tb_orderproduct
$queryTodayAdsSale = "SELECT SUM(o.grand_total) AS today_ads_sale
                     FROM tb_order o
                     WHERE DATE(o.o_date) = '$todayDate'";
$resultTodayAdsSale = mysqli_query($con, $queryTodayAdsSale);

if (!$resultTodayAdsSale) {
    die("Error in SQL query: " . mysqli_error($con));
}

$rowTodayAdsSale = mysqli_fetch_assoc($resultTodayAdsSale);
$todayAdsSale = $rowTodayAdsSale['today_ads_sale'];

$queryTotalAdsSale = "SELECT SUM(o.grand_total) AS total_ads_sale FROM tb_order o";
$resultTotalAdsSale = mysqli_query($con, $queryTotalAdsSale);

if (!$resultTotalAdsSale) {
    die("Error in SQL query: " . mysqli_error($con));
}

$rowTotalAdsSale = mysqli_fetch_assoc($resultTotalAdsSale);
$totalAdsSale = $rowTotalAdsSale['total_ads_sale'];

$todayDate = date("Y-m-d");

// Calculate today's total customers from tb_order
$queryTodayOrderCustomers = "SELECT COUNT(DISTINCT o.o_cid) AS today_order_customers
                             FROM tb_order o
                             WHERE DATE(o.o_date) = '$todayDate'";
$resultTodayOrderCustomers = mysqli_query($con, $queryTodayOrderCustomers);

if (!$resultTodayOrderCustomers) {
    die("Error in SQL query: " . mysqli_error($con));
}

$rowTodayOrderCustomers = mysqli_fetch_assoc($resultTodayOrderCustomers);
$todayOrderCustomers = $rowTodayOrderCustomers['today_order_customers'];

// Calculate today's total customers from quotecons
$queryTodayQuoteconsCustomers = "SELECT COUNT(DISTINCT qc.qc_custname) AS today_quotecons_customers
                                 FROM quotecons qc
                                 WHERE DATE(qc.qc_issuedate) = '$todayDate'";
$resultTodayQuoteconsCustomers = mysqli_query($con, $queryTodayQuoteconsCustomers);

if (!$resultTodayQuoteconsCustomers) {
    die("Error in SQL query: " . mysqli_error($con));
}

$rowTodayQuoteconsCustomers = mysqli_fetch_assoc($resultTodayQuoteconsCustomers);
$todayQuoteconsCustomers = $rowTodayQuoteconsCustomers['today_quotecons_customers'];

// Calculate total customers from tb_order (considering duplicates)
$queryTotalOrderCustomers = "SELECT COUNT(DISTINCT o.o_cid) AS total_order_customers
                             FROM tb_order o";
$resultTotalOrderCustomers = mysqli_query($con, $queryTotalOrderCustomers);

if (!$resultTotalOrderCustomers) {
    die("Error in SQL query: " . mysqli_error($con));
}

$rowTotalOrderCustomers = mysqli_fetch_assoc($resultTotalOrderCustomers);
$totalOrderCustomers = $rowTotalOrderCustomers['total_order_customers'];

// Calculate total customers from quotecons (considering duplicates)
$queryTotalQuoteconsCustomers = "SELECT COUNT(DISTINCT qc.qc_custname) AS total_quotecons_customers
                                 FROM quotecons qc";
$resultTotalQuoteconsCustomers = mysqli_query($con, $queryTotalQuoteconsCustomers);

if (!$resultTotalQuoteconsCustomers) {
    die("Error in SQL query: " . mysqli_error($con));
}

$rowTotalQuoteconsCustomers = mysqli_fetch_assoc($resultTotalQuoteconsCustomers);
$totalQuoteconsCustomers = $rowTotalQuoteconsCustomers['total_quotecons_customers'];

// Calculate total customers from tb_order (considering duplicates)
$queryTotalOrderCustomers = "SELECT COUNT(DISTINCT o.o_cid) AS total_order_customers FROM tb_order o";
$resultTotalOrderCustomers = mysqli_query($con, $queryTotalOrderCustomers);

if (!$resultTotalOrderCustomers) {
    die("Error in SQL query: " . mysqli_error($con));
}

$rowTotalOrderCustomers = mysqli_fetch_assoc($resultTotalOrderCustomers);
$totalOrderCustomers = $rowTotalOrderCustomers['total_order_customers'];

// Calculate total customers from quotecons (considering duplicates)
$queryTotalQuoteconsCustomers = "SELECT COUNT(DISTINCT qc.qc_custname) AS total_quotecons_customers FROM quotecons qc";
$resultTotalQuoteconsCustomers = mysqli_query($con, $queryTotalQuoteconsCustomers);

if (!$resultTotalQuoteconsCustomers) {
    die("Error in SQL query: " . mysqli_error($con));
}

$rowTotalQuoteconsCustomers = mysqli_fetch_assoc($resultTotalQuoteconsCustomers);
$totalQuoteconsCustomers = $rowTotalQuoteconsCustomers['total_quotecons_customers'];

$todayDate = date("Y-m-d");

// Fetch Today Transaction Items from tb_orderproduct
$queryTodayTransacItems = "SELECT SUM(op.op_quantity) AS today_transac_items
                           FROM tb_order o
                           JOIN tb_orderproduct op ON o.o_id = op.op_orderid
                           WHERE DATE(o.o_date) = '$todayDate'";
$resultTodayTransacItems = mysqli_query($con, $queryTodayTransacItems);

if (!$resultTodayTransacItems) {
    die("Error in SQL query: " . mysqli_error($con));
}

$rowTodayTransacItems = mysqli_fetch_assoc($resultTodayTransacItems);
$todayTransacItems = $rowTodayTransacItems['today_transac_items'];

// Fetch Total Transaction Items from tb_orderproduct (without date restriction)
$queryTotalTransacItems = "SELECT SUM(op.op_quantity) AS total_transac_items
                           FROM tb_order o
                           JOIN tb_orderproduct op ON o.o_id = op.op_orderid";
$resultTotalTransacItems = mysqli_query($con, $queryTotalTransacItems);

if (!$resultTotalTransacItems) {
    die("Error in SQL query: " . mysqli_error($con));
}

$rowTotalTransacItems = mysqli_fetch_assoc($resultTotalTransacItems);
$totalTransacItems = $rowTotalTransacItems['total_transac_items'];

// Fetch Total Transaction Items from tb_orderproduct (without date restriction)
$queryTotalTransacItemsInventory = "SELECT SUM(op.op_quantity) AS total_transac_items_inventory
                                   FROM tb_order o
                                   JOIN tb_orderproduct op ON o.o_id = op.op_orderid";
$resultTotalTransacItemsInventory = mysqli_query($con, $queryTotalTransacItemsInventory);

if (!$resultTotalTransacItemsInventory) {
    die("Error in SQL query: " . mysqli_error($con));
}

$rowTotalTransacItemsInventory = mysqli_fetch_assoc($resultTotalTransacItemsInventory);
$totalTransacItemsInventory = $rowTotalTransacItemsInventory['total_transac_items_inventory'];

?>

<?php
// Fetch inventory items with quantities lower than the minimum
$queryLowQuantityItems = "SELECT p_id, p_name, p_quantity, p_minimum FROM tb_product WHERE p_quantity < p_minimum";
$resultLowQuantityItems = mysqli_query($con, $queryLowQuantityItems);

if (!$resultLowQuantityItems) {
    die("Error in SQL query: " . mysqli_error($con));
}

$lowQuantityItems = [];

while ($rowLowQuantityItem = mysqli_fetch_assoc($resultLowQuantityItems)) {
    $lowQuantityItems[] = $rowLowQuantityItem;
}
?>

<body>

    <script>
        // Add this JavaScript function to handle duration change
        function changeDuration() {
            const selectedDuration = document.getElementById('durationSelect').value;
            window.location.href = `report.php?duration=${selectedDuration}`;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('finance-chart').getContext('2d');

            // Initial chart data
            const data = {
                labels: <?php echo json_encode($dates); ?>,
                datasets: [{
                    label: 'Finance Construction Report',
                    data: <?php echo json_encode($totalAmounts); ?>,
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 2,
                    fill: false,
                    pointStyle: 'cross',
                    pointRadius: 5,
                    pointHoverRadius: 8
                }]
            };

            // Initial chart configuration
            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: (ctx) => 'Point Style: ' + ctx.chart.data.datasets[0].pointStyle,
                        }
                    }
                }
            };

            // Initialize the chart
            const myChart = new Chart(ctx, config);

            // Actions to change point styles dynamically
            const actions = [{
                    name: 'pointStyle: cross',
                    handler: () => setPointStyle('cross')
                },
                // Add other point styles here...
            ];

            // Helper function to update point style
            function setPointStyle(style) {
                myChart.data.datasets.forEach(dataset => {
                    dataset.pointStyle = style;
                });
                myChart.update();
            }

            // Add event listeners to your buttons or triggers
            actions.forEach(action => {
                const button = document.getElementById(action.name.replace(/\s+/g, ''));
                if (button) {
                    button.addEventListener('click', () => action.handler());
                }
            });
        });
    </script>


    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-secondary navbar-dark">
            <a href="index.html" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary"><img src="img/Removal-612.png" alt="" style="width: 60px; height: 60px;">&nbspACAMS</h3>
            </a>
            <div class="navbar-nav w-100">
                <a href="report.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="cons.php" class="nav-item nav-link"><i class="fa fa-laptop me2"></i>Construction</a>
                <div class="nav-item dropdown">
                    <a href="manageorder.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Advertisment</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="manageorder.php" class="dropdown-item">Manage Order</a>
                        <a href="createcustomer.php" class="dropdown-item">Create Customer</a>
                        <a href="customerinfo.php" class="dropdown-item">Customer Information</a>
                        <a href="createorderads.php" class="dropdown-item">Create Order</a>
                        <a href="statuspage.php" class="dropdown-item">Delivery Page</a>
                        <a href="paymentpage.php" class="dropdown-item">Payment Page</a>
                        <a href="paymentstatus.php" class="dropdown-item">Payment Status</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Quotation</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="quotationlistAdv.php" class="dropdown-item">Advertisement</a>
                        <a href="quotationlistCons.php" class="dropdown-item">Construction</a>
                    </div>
                </div>
                <a href="inventoryList.php" class="nav-item nav-link"><i class="fa fa-laptop me2"></i>Ads Inventory</a>
                <a href="managestaff.php" class="nav-item nav-link"><i class="fa fa-laptop me2"></i>Manage Staff</a>
            </div>
        </nav>
    </div>


    <!-- Navbar End -->

    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Today Ads Sale</p>
                        <h6 class="mb-0">RM<?php echo number_format(round($todayAdsSale, 2), 2); ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Ads Sale</p>
                        <h6 class="mb-0">RM<?php echo number_format(round($totalAdsSale, 2), 2); ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Today Cons Sale</p>
                        <h6 class="mb-0">RM<?php echo number_format(round($todayConsSale, 2), 2); ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Cons Sale</p>
                        <h6 class="mb-0">RM<?php echo number_format(round($totalConsSale, 2), 2); ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-area fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Today Transac Item</p>
                        <h6 class="mb-0"><?php echo $todayTransacItems; ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-pie fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Transac Item</p>
                        <h6 class="mb-0"><?php echo $totalTransacItems; ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Today Customers</p>
                        <h6 class="mb-0"><?php echo $todayOrderCustomers + $todayQuoteconsCustomers; ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Customers</p>
                        <h6 class="mb-0"><?php echo $totalOrderCustomers + $totalQuoteconsCustomers; ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sale & Revenue End -->


    <!-- Sales Chart Start -->
    <div class="container-fluid pt-4 px-4">

        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary text-center rounded p-4">
                    <h6 class="mb-4">Finance Construction Report</h6>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <label for="durationSelect" class="form-label">Select Duration:</label>
                        <select class="form-select" id="durationSelect" name="duration" onchange="changeDuration()">
                            <option value="weekly" <?php echo ($selectedDuration === 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                            <option value="monthly" <?php echo ($selectedDuration === 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                            <option value="annual" <?php echo ($selectedDuration === 'annual') ? 'selected' : ''; ?>>Annual</option>
                        </select>
                    </div>
                    <canvas id="finance-chart"></canvas>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary text-center rounded p-4">
                    <h6 class="mb-4">Finance Advertisement Report</h6>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <label for="durationSelectAds" class="form-label">Select Duration:</label>
                        <select class="form-select" id="durationSelectAds" name="duration" onchange="changeDurationAds()">
                            <option value="weekly" <?php echo ($selectedDuration === 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                            <option value="monthly" <?php echo ($selectedDuration === 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                            <option value="annual" <?php echo ($selectedDuration === 'annual') ? 'selected' : ''; ?>>Annual</option>
                        </select>
                    </div>
                    <canvas id="line-chart-ads"></canvas>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary text-center rounded p-4">
                    <h6 class="mb-4">Customer Report</h6>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <label for="durationSelectCustomer" class="form-label">Select Duration:</label>
                        <select class="form-select" id="durationSelectCustomer" name="duration" onchange="changeDurationCustomer()">
                            <option value="weekly" <?php echo ($selectedDurationAds === 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                            <option value="monthly" <?php echo ($selectedDurationAds === 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                            <option value="annual" <?php echo ($selectedDurationAds === 'annual') ? 'selected' : ''; ?>>Annual</option>
                        </select>
                    </div>
                    <canvas id="customer-pie-chart" width="500" height="500"></canvas>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary text-center rounded p-4">
                    <h6 class="mb-4">Inventory Report</h6>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <label for="durationSelectInventory" class="form-label">Select Duration:</label>
                        <select class="form-select" id="durationSelectInventory" name="duration" onchange="changeDurationInventory()">
                            <option value="weekly" <?php echo ($selectedDurationAds === 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                            <option value="monthly" <?php echo ($selectedDurationAds === 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                            <option value="annual" <?php echo ($selectedDurationAds === 'annual') ? 'selected' : ''; ?>>Annual</option>
                        </select>
                    </div>
                    <!-- Display the Total Transaction Items -->
                    <p>Total Transaction Items: <?php echo $totalTransacItemsInventory; ?></p>
                    <!-- Include the Line Chart or any other visualization if needed -->
                    <canvas id="line-chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Sales Chart End -->

        <!-- Recent Sales Start -->

        <!-- Recent Sales End -->


        <!-- Widgets Start -->
        <div class="container-fluid pt-4 px-4">

            <div class="row g-4">
                <div class="col-sm-12 col-xl-6">
                    <div class="h-100 bg-secondary rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Calender</h6>
                        </div>
                        <div id="calender"></div>
                    </div>
                </div>

                <div class="col-sm-12 col-xl-6">
                    <div class="h-100 bg-secondary rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Low Quantity Items</h6>
                        </div>
                        <ul class="list-group">
                            <?php foreach ($lowQuantityItems as $item) : ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $item['p_name']; ?>
                                    <span class="badge bg-danger rounded-pill"><?php echo $item['p_quantity']; ?> (Min: <?php echo $item['p_minimum']; ?>)</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>





        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/chart/chart.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/tempusdominus/js/moment.min.js"></script>
        <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const adsCtx = document.getElementById('line-chart-ads').getContext('2d');

                // Initial chart data for Finance Advertisement Report
                const adsData = {
                    labels: <?php echo json_encode($adsDates); ?>,
                    datasets: [{
                        label: 'Finance Advertisement Report',
                        data: <?php echo json_encode($adsTotalAmounts); ?>,
                        borderColor: 'rgba(255, 255, 255, 1)',
                        borderWidth: 2,
                        fill: false,
                        pointStyle: 'cross',
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                };

                // Initial chart configuration for Finance Advertisement Report
                const adsConfig = {
                    type: 'line',
                    data: adsData,
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: (adsCtx) => 'Point Style: ' + adsCtx.chart.data.datasets[0].pointStyle,
                            }
                        }
                    }
                };

                // Initialize the chart for Finance Advertisement Report
                const adsChart = new Chart(adsCtx, adsConfig);
                // ... (previous code for point style change remains unchanged)
            });

            function changeDurationAds() {
                const selectedDurationAds = document.getElementById('durationSelectAds').value;
                window.location.href = `report.php?duration=${selectedDurationAds}&chart=ads`;
            }
        </script>

        <!-- JavaScript for Customer Pie Chart -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const customerCtx = document.getElementById('customer-pie-chart').getContext('2d');

                // Data for Customer Pie Chart
                const customerData = {
                    labels: ['Construction', 'Advertisement'],
                    datasets: [{
                        data: [<?php echo $totalOrderCustomers; ?>, <?php echo $totalQuoteconsCustomers; ?>],
                        backgroundColor: ['rgba(255, 99, 132, 0.8)', 'rgba(54, 162, 235, 0.8)'],
                    }]
                };

                // Configuration for Customer Pie Chart
                const customerConfig = {
                    type: 'pie',
                    data: customerData,
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Total Customers Breakdown',
                            },
                        },
                        aspectRatio: 1.4, // Adjust the aspect ratio as needed
                    },
                };

                // Initialize the Customer Pie Chart
                const customerPieChart = new Chart(customerCtx, customerConfig);
            });

            // Add this JavaScript function to handle duration change for Customer Report
            function changeDurationCustomer() {
                const selectedDurationCustomer = document.getElementById('durationSelectCustomer').value;
                window.location.href = `report.php?duration=${selectedDurationCustomer}&chart=customer`;
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const inventoryCtx = document.getElementById('line-chart').getContext('2d');

                // Initial chart data for Inventory Report
                const inventoryData = {
                    labels: <?php echo json_encode($dates); ?>,
                    datasets: [{
                        label: 'Total Transaction Items',
                        data: <?php echo json_encode($totalTransacItems); ?>,
                        borderColor: 'rgba(255, 255, 255, 1)',
                        borderWidth: 2,
                        fill: false,
                        pointStyle: 'cross',
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                };

                // Initial chart configuration for Inventory Report
                const inventoryConfig = {
                    type: 'line',
                    data: inventoryData,
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: (inventoryCtx) => 'Point Style: ' + inventoryCtx.chart.data.datasets[0].pointStyle,
                            },
                        },
                        aspectRatio: 1.5,
                    },

                };

                // Initialize the chart for Inventory Report
                const inventoryChart = new Chart(inventoryCtx, inventoryConfig);
                // ... (previous code for point style change remains unchanged)
            });

            function changeDurationInventory() {
                const selectedDurationInventory = document.getElementById('durationSelectInventory').value;
                window.location.href = `report.php?duration=${selectedDurationInventory}&chart=inventory`;
            }
        </script>

        <!-- Chart.js Script -->

</body>
<!-- Widgets End -->

<!-- Content End -->

<?php include 'footer.php'; ?>