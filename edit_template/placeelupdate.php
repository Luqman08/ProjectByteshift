<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include 'header.php';

include('dbcon.php');

if (isset($_GET['state']) && isset($_GET['city'])) {
    $state = $_GET['state'];
    $city = $_GET['city'];

    // Use parameters to filter the SQL query
    $sqlenp = "SELECT * FROM consplace WHERE cp_category = 2 AND cp_state = '$state' AND cp_city = '$city'";
    $resultenp = mysqli_query($con, $sqlenp);
}
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

<!-- Additional Percentage Table -->

<body>
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <!-- Your existing table code here -->
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col">State</th>
                        <th scope="col">City</th>
                        <th scope="col">Less than 16km</th>
                        <th scope="col">16-32km</th>
                        <th scope="col">32-48km</th>
                        <th scope="col">More than 48km</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($rowenp = mysqli_fetch_array($resultenp)) {
                        echo "<tr>";
                        echo "<td>" . $rowenp['cp_state'] . "</td>";
                        echo "<td>" . $rowenp['cp_city'] . "</td>";

                        foreach (['16', '32', '35', '48'] as $distanceCategory) {
                            echo "<td>";
                            if ($rowenp['cp_distance'] == $distanceCategory) {
                                echo $rowenp['cp_percentage'];
                            }
                            echo "</td>";
                        }

                        echo "<td>";
                        echo "<a href ='placeenupdateform.php?id=" . $rowenp['cp_state'] . "," . $rowenp['cp_city'] . ", " . $rowenp['cp_distance'] . "' class='btn btn-warning m-2' >Update</a>";

                        echo "</td>";

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<!-- Sale & Revenue End -->

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
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