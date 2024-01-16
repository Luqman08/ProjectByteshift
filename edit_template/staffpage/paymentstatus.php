<?php
include 'dbcon.php';

include('mysession.php');
if (!session_id()) {

    session_start();
}


// Function to retrieve and display payment details
function displayPayments($con, $orderID)
{
    $sqlGetPayments = "SELECT * FROM tb_payment WHERE order_id = $orderID";
    $resultPayments = $con->query($sqlGetPayments);

    if ($resultPayments->num_rows > 0) {
        $paymentDetailsDisplayed = false;  // Flag to track if payment details are already displayed
        while ($rowPayment = $resultPayments->fetch_assoc()) {
?>
            <div class="card mb-3">
                <div class="card-header">
                    Transaction ID:
                    <?php echo $rowPayment['payment_id']; ?>
                </div>
                <div class="card-body">
                    <p class="card-text">Transaction Type:
                        <?php echo $rowPayment['transaction_type']; ?>
                    </p>
                    <p class="card-text">Transaction Date:
                        <?php echo $rowPayment['transaction_date']; ?>
                    </p>
                    <p class="card-text">Payment Type:
                        <?php echo $rowPayment['payment_type']; ?>
                    </p>
                    <p class="card-text">Amount:
                        <?php echo $rowPayment['amount']; ?>
                    </p>
                    <p class="card-text">Evidence: <a href="<?php echo $rowPayment['evidence_path']; ?>" target="_blank">View
                            Evidence</a></p>
                </div>
            </div>
<?php
            $paymentDetailsDisplayed = true;
        }

        // Display a message if payment details are not found
        if (!$paymentDetailsDisplayed) {
            echo "<p>No payments found for this order ID.</p>";
        }
    } else {
        echo "<p>No payments found for this order ID.</p>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderID = $_POST['orderID'];
} else {
    // Set a default value or handle the case when the page is accessed without a valid POST request
    $orderID = 0;
}

include 'header.php';
?>




<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><img src="img/Removal-612.png" alt="" style="width: 60px; height: 60px;">&nbspACAMS</h3>
        </a>
        <div class="navbar-nav w-100">
           
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
            <a href="quotationlistAdv.php" class="nav-item nav-link"><i class="fa fa-laptop me2"></i>Ads Quotation</a>
        </div>
    </nav>
</div>
<!-- Sidebar End -->


<!-- Content Start -->

<body>
    <!-- Navbar Start -->
    <!-- Navbar End -->


    <!-- Blank Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="container-fluid pt-4 px-4">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Payment Status for Order ID:
                    <?php echo $orderID; ?>
                </h6>

                <form action="paymentstatus.php" method="post">
                    <div class="mb-3">
                        <label for="orderID" class="form-label">Enter Order ID:</label>
                        <input type="number" class="form-control" name="orderID" id="orderID" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Get Payment Status</button>
                </form><br>

                <?php
                if ($orderID > 0) {
                    displayPayments($con, $orderID);
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Include your Bootstrap or other JS scripts here -->

    <!-- Blank End -->


    <!-- Footer Start -->
    <!-- Footer End -->
</body>
<!-- Content End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


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