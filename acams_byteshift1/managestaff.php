<?php include 'header.php';
//include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbcon.php');

// Retrieve staff information from the database
$sql = "SELECT * FROM tb_user"; // Replace 'staff_table' with your actual staff table name
$result = mysqli_query($con, $sql);

mysqli_close($con);


?>

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
                    <a href="statuspage.php" class="dropdown-item">Status Page</a>
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
            <a href="managestaff.php" class="nav-item nav-link active"><i class="fa fa-laptop me2"></i>Manage Staff</a>
        </div>
    </nav>
</div>



<!-- option -->

<body>
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Manage Staff</h6>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">

                            <th scope="col">ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Email</th>
                            <th scope="col">Password</th>
                            <th scope="col">User Type</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['u_id'] . "</td>";
                            echo "<td>" . $row['u_name'] . "</td>";
                            echo "<td>" . $row['u_phone'] . "</td>";
                            echo "<td>" . $row['u_email'] . "</td>";
                            echo "<td>" . $row['u_pwd'] . "</td>";
                            echo "<td>" . $row['u_type'] . "</td>";
                            //echo "<td>********</td>"; // Passwords are usually not displayed for security reasons
                            echo "<td>";
                            echo "<a href='editstaffpage.php?id=" . $row['u_id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                            echo "<button class='btn btn-danger btn-sm' onclick='confirmDelete(" . $row['u_id'] . ")'>Delete</button>";
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
    // JavaScript function to display confirmation dialog and redirect to deletestaff.php
    function confirmDelete(userId) {
        if (confirm("Are you sure you want to delete this staff member?")) {
            // If user clicks 'OK', redirect to deletestaff.php with the user ID
            window.location.href = "deletestaff.php?id=" + userId;
        }
        // If user clicks 'Cancel', do nothing
    }
</script>

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


<?php include 'footer.php'; ?>