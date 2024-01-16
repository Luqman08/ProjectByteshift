<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include 'header.php';
include('dbcon.php');

// Function to create a new customer
function createCustomer($customerId, $customerName, $customerEmail, $customerPhone)
{
    global $con;

    // Check if the customer ID already exists
    if (isCustomerIdExists($customerId)) {
        // Display a pop-up alert with the error message
        echo "<script>alert('Error: Customer ID #$customerId already exists. Please choose a different ID.');</script>";
        return false;
    }

    // Insert customer details into tb_customer
    $insertCustomerQuery = "INSERT INTO tb_customer (c_id, c_name, c_email, c_phone) VALUES ('$customerId', '$customerName', '$customerEmail', '$customerPhone')";

    if ($con->query($insertCustomerQuery)) {
        // Display a pop-up alert with success message
        echo "<script>alert('Customer added successfully!');</script>";
        return true;
    } else {
        // Display a pop-up alert with error message
        echo "<script>alert('Error: Unable to add customer. Please try again.');</script>";
        return false;
    }
}

// Function to check if the customer ID already exists
function isCustomerIdExists($customerId)
{
    global $con;

    $checkCustomerIdQuery = "SELECT COUNT(*) as count FROM tb_customer WHERE c_id = '$customerId'";
    $result = $con->query($checkCustomerIdQuery);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['count'] > 0;
    }

    return false;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerId = $_POST['customer_id'];
    $customerName = $_POST['customer_name'];
    $customerEmail = $_POST['customer_email'];
    $customerPhone = $_POST['customer_phone'];

    // Create the customer
    createCustomer($customerId, $customerName, $customerEmail, $customerPhone);
}
?>



<!-- Spinner End -->


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
    <!-- Blank Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Create Customer</h6>
                    <!-- Create Customer Form -->
                    <form method="post">
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer ID</label>
                            <input type="number" min="0" class="form-control" id="customer_id" name="customer_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Customer Email</label>
                            <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Customer Phone</label>
                            <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Customer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<!-- Blank End -->


<!-- Footer Start -->

<!-- Content End -->


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

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


<?php include 'footer.php'; ?>