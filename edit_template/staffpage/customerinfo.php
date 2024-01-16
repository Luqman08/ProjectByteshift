<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include('dbcon.php');


// Display success message
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            {$_SESSION['success_message']}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";

    unset($_SESSION['success_message']);
}

// Display error message
if (isset($_SESSION['error_message'])) {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            {$_SESSION['error_message']}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";

    unset($_SESSION['error_message']);
}

// Your SQL query for customer information
$query = "SELECT tb_customer.c_id, c_name, c_email, c_phone, o_id, o_date, o_delivery_status, o_payment_status, o_payment_proof
              FROM tb_customer
              LEFT JOIN tb_order ON tb_customer.c_id = tb_order.o_cid
              ORDER BY c_id, o_id";

$result = $con->query($query);
$count = 0;

// Include header files
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

<!-- Navbar End -->

<body>
    <!-- Blank Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Customer Information</h6>

                    <!-- Search Form -->
                    <form method="post" class="mb-3" id="searchForm">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search by Customer ID, Name, Phone, or Email" name="search_term" id="search_term">
                        </div>
                    </form>

                    <!-- Your existing HTML content for displaying customer information table -->
                    <div id="searchResults" style="overflow-y: auto;">
                        <table class="table table-bordered" id="customerTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Customer ID</th>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Action</th>
                                    <!-- Add more columns if needed -->
                                </tr>
                            </thead>
                            <tbody id="customerBody">
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $count++;
                                ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $count; ?>
                                        </th>
                                        <td>
                                            <?php echo $row['c_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['o_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['c_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['c_email']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['c_phone']; ?>
                                        </td>
                                        <td>
                                            <?php echo "<a href='customerinfoUpdate.php?id=" . $row['c_id'] . "' class='btn btn-warning m-2'>Modify</a> &nbsp"; ?>
                                        </td>

                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    $color = 'grey';
                    echo "<p style='color: $color;'><i>Total Customers: $count</i></p>";
                    ?>
                </div>
            </div>
        </div>
    </div>


    <?php
    mysqli_close($con);
    ?>
</body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/chart/chart.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/tempusdominus/js/moment.min.js"></script>
<script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search_term').on('input', function() {
            // Get the search term
            var searchTerm = $(this).val();

            // Make an AJAX request to fetch search results
            $.ajax({
                type: 'POST',
                url: 'search_customer.php',
                data: {
                    search_term: searchTerm
                },
                success: function(response) {
                    // Update the search results container with the response
                    $('#customerBody').html(response);
                }
            });
        });
    });
</script>

<script src="js/main.js"></script>

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


<?php include 'footer.php'; ?>