<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}


/*include('mysession.php');
    if (!session_id()) {
        session_start();
    }*/

//Get item ID from URL
if (isset($_GET['id'])) {
    $fID = $_GET['id'];
}
include('dbcon.php');

//Retrieve booking data
$sqlr = "SELECT * FROM tb_product WHERE p_id = '$fID'";

//Execute
$resultr = mysqli_query($con, $sqlr);
$rowr = mysqli_fetch_array($resultr);

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
            <a href="inventoryList.php" class="nav-item nav-link active"><i class="fa fa-laptop me2"></i>Ads Inventory</a>
            <a href="managestaff.php" class="nav-item nav-link"><i class="fa fa-laptop me2"></i>Manage Staff</a>
        </div>
    </nav>
</div>
<!-- Sidebar End -->


<body>

    <!-- Form Start -->
    <div class="container-fluid pt-4 px-4">
        <form method="POST" action="inventoryUpdateProcess.php">
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Modify Item Details</h6>
                    <!-- <div class="form-floating mb-3"> -->
                    <div class="form-group">
                        <?php
                        echo '<input type="hidden" value="' . $rowr['p_id'] . '" name="fID" class="form-control" id="exampleInputPassword1" required>';
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="form-label mt-4">Item Name</label>
                        <?php
                        echo '<input type="text" value="' . $rowr['p_name'] . '" name="fname" class="form-control" id="exampleInputPassword1" required>';
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1" class="form-label mt-4">Unit Price</label>
                        <?php
                        echo '<input type="text" value="' . $rowr['p_price'] . '" name="funitprice" class="form-control" id="exampleInputPassword1" required>';
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="form-label mt-4">Quantity</label>
                        <?php
                        echo '<input type="text" value="' . $rowr['p_quantity'] . '" name="fquantity" class="form-control" id="exampleInputPassword1" required>';
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="form-label mt-4">Minimum</label>
                        <?php
                        echo '<input type="text" value="' . $rowr['p_minimum'] . '" name="fminimum" class="form-control" id="exampleInputPassword1" required>';
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="form-label mt-4">Markup Percentage (%)</label>
                        <?php
                        echo '<input type="text" value="' . $rowr['p_markup'] . '" name="fmarkup" class="form-control" id="exampleInputPassword1" required>';
                        ?>
                    </div>

                    <br>
                    <button class="btn btn-primary w-100 m-2" type="submit">Modify</button>
                    <button class="btn btn-outline-primary w-100 m-2" type="reset">Reset</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Form End -->


    <!-- Footer Start -->

    <!-- Footer End -->
    
    <!-- Content End -->


    <!-- Back to Top -->

</body>

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