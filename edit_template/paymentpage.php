<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'dbcon.php';
include 'paymentprocess.php';


// Check if there is a payment alert in the session


include 'header.php';
?>

<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><img src="img/Removal-612.png" alt="" style="width: 60px; height: 60px;">&nbspACAMS</h3>
        </a>
        <div class="navbar-nav w-100">
            <a href="report.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <a href="cons.php" class="nav-item nav-link"><i class="fa fa-laptop me2"></i>Construction</a>
            <div class="nav-item dropdown">
                <a href="manageorder.php" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Advertisment</a>
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
<!-- Sidebar End -->

<body>
    <!-- Content Start -->

    <!-- Navbar Start -->

    <!-- Navbar End -->


    <!-- Blank Start -->
    <?php
    if (isset($_SESSION['payment_alert'])) {
        $paymentAlert = $_SESSION['payment_alert'];

        // Display the appropriate alert based on success or failure
        if (strpos($paymentAlert, 'success') !== false) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-circle me-2"></i>' . $paymentAlert . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        } else {
            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-circle me-2"></i>' . $paymentAlert . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }

        // Unset the session variable to avoid displaying the alert multiple times
        unset($_SESSION['payment_alert']);
    }


    ?>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h3>Payment Page</h3>
                    <form action="paymentpage.php" method="post" enctype="multipart/form-data">
                        <label for="order_id">Order ID:</label>
                        <input type="text" class="form-control" name="order_id" required><br>
                        <label for="transaction_date">Transaction Date:</label>
                        <input type="date" class="form-control" name="transaction_date" required><br>

                        <label for="payment_type">Payment Type:</label>
                        <select name="payment_type" required class="form-select">
                            <option value="deposit">Deposit</option>
                            <option value="payment">Payment</option>
                        </select><br>

                        <label for="transaction_type">Transaction Type:</label>
                        <select name="transaction_type" required class="form-select">
                            <option value="transfer">Transfer</option>
                            <option value="qr_pay">QR Pay</option>
                            <option value="tng">TnG</option>
                            <option value="debit">Debit</option>
                            <option value="credit">Credit</option>
                        </select><br>

                        <label for="amount">Amount:</label>
                        <input type="text" class="form-control" name="amount" required><br>

                        <label for="evidence">Upload Evidence (File or Picture):</label>
                        <input type="file" class="form-control bg-dark" name="evidence" accept="image/*, .pdf"><br>

                        <input type="submit" class="btn btn-primary" value="Submit">
                    </form>


                </div>
            </div>
        </div>
    </div>
    <!-- Blank End -->


    <!-- Footer Start -->

    <!-- Content End -->

</body>
<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
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

<?php include 'footer.php'; ?>