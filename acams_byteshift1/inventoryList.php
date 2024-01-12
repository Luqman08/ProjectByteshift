<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include('dbcon.php');

//CRUD: Retrieve booking operation
$sql = "SELECT * FROM tb_product";


$result = mysqli_query($con, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<?php
// Retrieve items with current stock level lower than the minimum stock level
$queryLowStock = "SELECT * FROM tb_product WHERE p_quantity < p_minimum";
$resultLowStock = mysqli_query($con, $queryLowStock);

$alertHTML = ''; // Initialize an empty string to store alert HTML

if ($resultLowStock->num_rows > 0) {
    while ($rowLowStock = $resultLowStock->fetch_assoc()) {
        // Generate alert HTML for each item with low stock
        $itemNameLowStock = $rowLowStock['p_name'];
        $currentStockLowStock = $rowLowStock['p_quantity'];
        $minStockLevelLowStock = $rowLowStock['p_minimum'];

        $alertHTML .= '<div class="alert alert-primary alert-dismissible fade show" role="alert">';
        $alertHTML .= '<i class="fa fa-exclamation-circle me-2"></i>';
        $alertHTML .= "Low stock alert for $itemNameLowStock! Current stock: $currentStockLowStock, Minimum stock level: $minStockLevelLowStock";
        $alertHTML .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertHTML .= '</div>';

        // Add code to send notifications (e.g., email, SMS, etc.) or take other actions
    }
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
            <a href="inventoryList.php" class="nav-item nav-link active"><i class="fa fa-laptop me2"></i>Ads Inventory</a>
            <a href="managestaff.php" class="nav-item nav-link"><i class="fa fa-laptop me2"></i>Manage Staff</a>
        </div>
    </nav>
</div>
<!-- Sidebar End -->


<!-- Content Start -->

<!-- Navbar End -->


<body>

    <?php echo $alertHTML; ?>
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Inventory Item List</h6>
                <a href="inventoryAdd.php">Insert New Item</a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">ID</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Minimum Stock Level</th>
                            <th scope="col">Markup Percentage</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['p_id'] . "</td>";
                            echo "<td>" . $row['p_name'] . "</td>";
                            echo "<td>" . $row['p_price'] . "</td>";
                            echo "<td>" . $row['p_quantity'] . "</td>";
                            echo "<td>" . $row['p_minimum'] . "</td>";
                            echo "<td>" . $row['p_markup'] . "</td>";
                            echo "<td>";
                            $deleteUrl = 'inventoryDelete.php?id=' . $row['p_id'];

                            echo "<a href='inventoryUpdate.php?id=" . $row['p_id'] . "' class='btn btn-warning m-2'>Modify</a> &nbsp";
                            echo "<a href='#' class='btn btn-primary m-2' onclick='confirmDelete(\"$deleteUrl\", \"" . $row['p_id'] . "\")'>Delete</a>&nbsp";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->

    <!-- Footer Start -->
    <?php
    mysqli_close($con);
    ?>

</body>
<!-- Content End -->


<!-- Back to Top -->

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
    function confirmDelete(url, itemName) {
        if (confirm("Are you sure you want to delete the item: '" + itemName + "'?")) {
            window.location.href = url;
        } else {
            // Prevent the default action (following the link)
            event.preventDefault();
        }
    }
</script>

<script>
    function confirmDelete(url, itemName) {
        if (confirm("Are you sure you want to delete the item: '" + itemName + "'?")) {
            window.location.href = url;
        } else {
            // Prevent the default action (following the link)
            event.preventDefault();
        }
    }
</script>

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


<?php include 'footer.php'; ?>