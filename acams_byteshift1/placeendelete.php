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
    $sqlenp = "SELECT * FROM consplace WHERE cp_category = 1 AND cp_state = '$state' AND cp_city = '$city'";
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
                        <th scope="col">Less than 15km</th>
                        <th scope="col">15-30km</th>
                        <th scope="col">30-50km</th>
                        <th scope="col">50-75km</th>
                        <th scope="col">More than 75km</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($rowenp = mysqli_fetch_array($resultenp)) {
                        echo "<tr>";
                        echo "<td>" . $rowenp['cp_state'] . "</td>";
                        echo "<td>" . $rowenp['cp_city'] . "</td>";

                        foreach (['15', '30', '40', '50', '75'] as $distanceCategory) {
                            echo "<td>";
                            if ($rowenp['cp_distance'] == $distanceCategory) {
                                echo $rowenp['cp_percentage'];
                            }
                            echo "</td>";
                        }

                        echo "<td>";
                        echo "<button class='btn btn-primary m-2' onclick=\"confirmDelete('" . $rowenp['cp_state'] . "', '" . $rowenp['cp_city'] . "', '" . $rowenp['cp_distance'] . "')\">Delete</button>";

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
<script>
    function confirmDelete(state, city, distance) {
        if (confirm("Are you sure you want to delete '" + state + "' , '" + city + "' with distance '" + distance + "'?")) {
            // Use AJAX to send a request for deletion
            $.ajax({
                type: 'GET',
                url: 'placeendeleteprocess.php',
                data: {
                    state: state,
                    city: city,
                    distance: distance
                },
                success: function(response) {
                    console.log(response); // Log the response to the browser console
                    location.reload(); // Reload the page after successful deletion
                    showAlert('success', 'Place deleted successfully!');
                },
                error: function(error) {
                    console.error('Error deleting item:', error);
                    showAlert('error', 'Error deleting place: ' + error.responseText);
                }
            });
        }
    }

    function showAlert(type, message) {
        var alertClass = 'alert-success'; // Default to success
        var icon = 'fa-check-circle'; // Default to check-circle icon

        if (type === 'error') {
            alertClass = 'alert-danger';
            icon = 'fa-exclamation-circle'; // Change to exclamation-circle icon for error
        }

        // Create the alert HTML
        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
            '<i class="fa ' + icon + ' me-2"></i>' + message +
            '<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>' +
            '</div>';

        // Append the alert to the body
        $('body').append(alertHtml);

        // Automatically close the alert after 3 seconds (adjust as needed)
        setTimeout(function() {
            $('.alert').alert('close');
        }, 3000);
    }
</script>

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


<?php include 'footer.php'; ?>