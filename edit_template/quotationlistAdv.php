<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include 'header.php';
include('dbcon.php');
?>

<script>
    $(document).ready(function() {
        $('#tb_order').DataTable();
    });
</script>

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
                <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Quotation</a>
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

<!-- Content Start -->

<body>
    <!-- Quotation Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="mb-0">Quotation for Advertisement Order</h5>
            </div>
            <form action="" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <select name="sort_alphabet" class="form-control">
                                <option value="">--Sort by Customer--</option>
                                <option value="a-z" <?php echo isset($_GET['sort_alphabet']) && $_GET['sort_alphabet'] == "a-z" ? "selected" : ""; ?>> A-Z (Ascending Order) </option>
                                <option value="z-a" <?php echo isset($_GET['sort_alphabet']) && $_GET['sort_alphabet'] == "z-a" ? "selected" : ""; ?>> Z-A (Descending Order) </option>
                            </select>
                            <button type="submit" class="input-group-text btn btn-primary" id="basic-addon2">
                                Sort
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">Order Advertisement ID</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Issue Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sort_option = "";
                        if (isset($_GET['sort_alphabet'])) {
                            if ($_GET['sort_alphabet'] == "a-z") {
                                $sort_option = "ASC";
                            } elseif ($_GET['sort_alphabet'] == "z-a") {
                                $sort_option = "DESC";
                            }
                        }

                        $query = "SELECT tb_order.*, tb_customer.c_name FROM tb_order 
                                LEFT JOIN tb_customer ON tb_order.o_cid = tb_customer.c_id
                                ORDER BY tb_customer.c_name $sort_option";

                        $query_run = mysqli_query($con, $query);

                        if ($query_run) {
                            $displayedOrderConstructionIDs = array();

                            while ($row = mysqli_fetch_array($query_run)) {
                                $o_id = $row['o_id'];

                                // Check if this order construction ID has been displayed
                                if (!in_array($o_id, $displayedOrderConstructionIDs)) {
                                    echo "<tr>";
                                    echo "<td>" . $o_id . "</td>";
                                    echo "<td>" . $row['c_name'] . "</td>";
                                    echo "<td>" . $row['o_date'] . "</td>";
                                    echo "<td>";

                                    $deleteUrl = 'quotationAdvDelete.php?id=' . $o_id;
                                    echo "<a href='printQuotationAdv.php?id=" . $o_id . "' class='btn btn-info m-2'> PDF Quotation </a> &nbsp";
                                    echo "<a href='printInvoiceAdv.php?id=" . $o_id . "' class='btn btn-info m-2'> PDF Invoice   </a> &nbsp";
                                    echo "<a href='quotationAdvDelete.php?id=" . $o_id . "' class='btn btn-primary m-2' onclick='confirmDelete(\"$deleteUrl\")'>Delete</a>&nbsp";

                                    // Mark this order construction ID as displayed
                                    $displayedOrderConstructionIDs[] = $o_id;

                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                        } else {
                            echo "Error executing query: " . mysqli_error($con);
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Quotation End -->
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <?php
    mysqli_close($con);
    ?>
    <script>
        function confirmDelete(url) {
            if (confirm("Reminder: Download first the quotation! Are you sure you want to delete this quotation?")) {
                window.location.href = url;
            } else {
                // Prevent the default action (following the link)
                event.preventDefault();
            }
        }
    </script>
</body>

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


<?php include 'footer.php'; ?>