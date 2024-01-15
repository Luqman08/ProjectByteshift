<?php

include('mysession.php');
if (!session_id()) {

    session_start();
}


if (isset($_GET['id'])) {
    $idParam = $_GET['id'];
    list($fstate, $fcity, $fdis) = explode(",", $idParam);
}

include('dbcon.php');

$sqlr = "SELECT * FROM consplace WHERE cp_state = ? AND cp_city = ? AND cp_distance = ?";

$stmt = mysqli_prepare($con, $sqlr);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssi", $fstate, $fcity, $fdis);
    mysqli_stmt_execute($stmt);

    // Get the result set from the prepared statement
    $resultr = mysqli_stmt_get_result($stmt);

    // Fetch the data from the result set
    $rowr = mysqli_fetch_array($resultr);

    // Close the statement
    mysqli_stmt_close($stmt);
}


include 'header.php';
?>


<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><img src="img/Removal-612.png" alt="" style="width: 60px; height: 60px;">&nbspACAMS</h3>
        </a>
        <div class="navbar-nav w-100">
            <a href="report.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <a href="cons.php" class="nav-item nav-link active"><i class="fa fa-laptop me2"></i>Construction</a>
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



<!-- option -->


<form method="POST" action="updateitemprocess.php">
    <div class="container-fluid pt-4 px-4">
        <div class="container-fluid pt-4 px-4">
            <div class="bg-secondary rounded h-100 p-4">
                <fieldset>
                    <h6 class="mb-4">Update Place Percentage</h6>

                    <div class="form-floating mb-3">
                        <?php
                        echo '<input type="text" value="' . $rowr["cp_percentage"] . '" name="ipercentage" class="form-control" id="floatingInput">'
                        ?>
                        <label for="floatingInput">Place Percentage</label>
                    </div>

                </fieldset>
                <button type="submit" class="btn btn-primary m-2">Update</button>
            </div>
        </div>
    </div>
    <br><br>
</form>

<!-- Sale & Revenue End -->

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