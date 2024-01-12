<?php

include('mysession.php');
if (!session_id()) {
    session_start();
}

include 'header.php';

// Display error message if set

if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>' . $_SESSION['success_message'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>' . $_SESSION['error_message'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['error_message']);
}

include('dbcon.php');


$sqlen = "SELECT * FROM constructionitem";

$resulten = mysqli_query($con, $sqlen);

$sqlel = "SELECT * FROM constructionitem";

$resultel = mysqli_query($con, $sqlel);

$sqlenp = "SELECT * FROM consplace";

$resultenp = mysqli_query($con, $sqlenp);

$sqlelp = "SELECT * FROM consplace";

$resultelp = mysqli_query($con, $sqlelp);

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

<body>
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Engineering Item</h6>
                <a href="additem.php">Add new Item</a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">

                            <th scope="col">Item Name</th>
                            <th scope="col">Item Type</th>
                            <th scope="col">Item Unit</th>
                            <th scope="col">Item Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        while ($rowen = mysqli_fetch_array($resulten)) {

                            echo "<tr>";
                            if ($rowen['CI_category'] == '1') {
                                echo "<td>" . $rowen['CI_name'] . "</td>";
                                echo "<td>" . $rowen['CI_type'] . "</td>";
                                echo "<td>" . $rowen['CI_unit'] . "</td>";
                                echo "<td>RM" . $rowen['CI_price'] . "</td>";
                                echo "<td>";
                                echo "<a href ='itemupdate.php?id=" . $rowen['CI_name'] . "," . $rowen['CI_type'] . ", " . $rowen['CI_category'] . "' class='btn btn-warning m-2' >Update</a>";
                                echo "<button class='btn btn-primary m-2' onclick=\"confirmDelete('" . $rowen['CI_name'] . "', '" . $rowen['CI_type'] . "')\">Delete</button>";
                                echo "</td>";
                            }
                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Electrical Item</h6>
                <a href="additem.php">Add new Item</a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">

                            <th scope="col">Item Name</th>
                            <th scope="col">Item Type</th>
                            <th scope="col">Item Unit</th>
                            <th scope="col">Item Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        while ($rowel = mysqli_fetch_array($resultel)) {

                            echo "<tr>";
                            if ($rowel['CI_category'] == '2') {
                                echo "<td>" . $rowel['CI_name'] . "</td>";
                                echo "<td>" . $rowel['CI_type'] . "</td>";
                                echo "<td>" . $rowel['CI_unit'] . "</td>";
                                echo "<td>RM" . $rowel['CI_price'] . "</td>";
                                echo "<td>";
                                echo "<a href ='itemupdate.php?id=" . $rowel['CI_name'] . "," . $rowel['CI_type'] . ", " . $rowel['CI_category'] . "' class='btn btn-warning m-2' >Update</a>";
                                echo "<button class='btn btn-primary m-2' onclick=\"confirmDelete('" . $rowel['CI_name'] . "', '" . $rowel['CI_type'] . "')\">Delete</button>";
                                echo "</td>";
                            }
                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Additional Percentage for Engineering Item</h6>
            </div>
            <div class="table-responsive">
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
                        $uniqueItems = array();

                        while ($rowenp = mysqli_fetch_array($resultenp)) {
                            if ($rowenp['cp_category'] == '1') {
                                $state = $rowenp['cp_state'];
                                $city = $rowenp['cp_city'];

                                // Check if this state is already added
                                if (!isset($uniqueItems[$state])) {
                                    $uniqueItems[$state] = array(
                                        'cp_state' => $state,
                                        'cities' => array(),  // Array to store cities for each state
                                        'cp_percentages' => array('15' => null, '30' => null, '40' => null, '50' => null, '75' => null),
                                    );
                                }

                                // Check if this city is already added for the state
                                if (!isset($uniqueItems[$state]['cities'][$city])) {
                                    $uniqueItems[$state]['cities'][$city] = array(
                                        'cp_city' => $city,
                                        'cp_distance' => null,
                                        'cp_percentages' => array(),
                                    );
                                }

                                // Add the percentage for the specific distance if 'cp_distance' is set
                                if (isset($rowenp['cp_distance'])) {
                                    $uniqueItems[$state]['cities'][$city]['cp_distance'] = $rowenp['cp_distance'];
                                    $uniqueItems[$state]['cities'][$city]['cp_percentages'][$rowenp['cp_distance']] = $rowenp['cp_percentage'];
                                }
                            }
                        }

                        foreach ($uniqueItems as $stateData) {
                            echo "<tr>";

                            // Display State for each unique state
                            echo "<td rowspan='" . count($stateData['cities']) . "'>" . $stateData['cp_state'] . "</td>";

                            $firstCity = true;

                            foreach ($stateData['cities'] as $cityData) {
                                // Display City for each unique city
                                if (!$firstCity) {
                                    echo "<tr>";  // Start a new row for additional cities under the same state
                                }

                                echo "<td>" . $cityData['cp_city'] . "</td>";

                                // Display percentages for each distance category
                                foreach (['15', '30', '40', '50', '75'] as $distanceCategory) {
                                    // Check if the key 'cp_percentages' and 'cp_distance' are set
                                    if (isset($cityData['cp_percentages'][$distanceCategory])) {
                                        echo "<td>" . $cityData['cp_percentages'][$distanceCategory] . "%</td>";
                                    } else {
                                        echo "<td></td>";
                                    }
                                }

                                // Display Action column with buttons for each row
                                echo "<td>";
                                // Check if 'cp_state', 'cp_city', and 'cp_distance' are set before creating the links
                                if (isset($stateData['cp_state'])) {


                                    echo "<a href ='placeenupdate.php?state=" . $stateData['cp_state'] . "&city=" . $cityData['cp_city'] . "&distance=" . $cityData['cp_distance'] . "' class='btn btn-warning m-2' >Update</a>";
                                    echo "<a href ='placeendelete.php?state=" . $stateData['cp_state'] . "&city=" . $cityData['cp_city'] . "&distance=" . $cityData['cp_distance'] . "' class='btn btn-primary m-2' >Delete</a>";


                                    $firstCity = false;
                                }
                                echo "</td>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Additional Percentage for Electrical Item</h6>
            </div>
            <div class="table-responsive">
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
                        $uniqueItems = array();

                        while ($rowelp = mysqli_fetch_array($resultelp)) {
                            if ($rowelp['cp_category'] == '2') {
                                $state = $rowelp['cp_state'];
                                $city = $rowelp['cp_city'];

                                // Check if this state is already added
                                if (!isset($uniqueItems[$state])) {
                                    $uniqueItems[$state] = array(
                                        'cp_state' => $state,
                                        'cities' => array(),  // Array to store cities for each state
                                        'cp_percentages' => array('16' => null, '32' => null, '35' => null, '48' => null),
                                    );
                                }

                                // Check if this city is already added for the state
                                if (!isset($uniqueItems[$state]['cities'][$city])) {
                                    $uniqueItems[$state]['cities'][$city] = array(
                                        'cp_city' => $city,
                                        'cp_distance' => null,
                                        'cp_percentages' => array(),
                                    );
                                }

                                // Add the percentage for the specific distance if 'cp_distance' is set
                                if (isset($rowelp['cp_distance'])) {
                                    $uniqueItems[$state]['cities'][$city]['cp_distance'] = $rowelp['cp_distance'];
                                    $uniqueItems[$state]['cities'][$city]['cp_percentages'][$rowelp['cp_distance']] = $rowelp['cp_percentage'];
                                }
                            }
                        }

                        foreach ($uniqueItems as $stateData) {
                            echo "<tr>";

                            // Display State for each unique state
                            echo "<td rowspan='" . count($stateData['cities']) . "'>" . $stateData['cp_state'] . "</td>";

                            $firstCity = true;

                            foreach ($stateData['cities'] as $cityData) {
                                // Display City for each unique city
                                if (!$firstCity) {
                                    echo "<tr>";  // Start a new row for additional cities under the same state
                                }

                                echo "<td>" . $cityData['cp_city'] . "</td>";

                                // Display percentages for each distance category
                                foreach (['16', '32', '35', '48'] as $distanceCategory) {
                                    // Check if the key 'cp_percentages' and 'cp_distance' are set
                                    if (isset($cityData['cp_percentages'][$distanceCategory])) {
                                        echo "<td>" . $cityData['cp_percentages'][$distanceCategory] . "%</td>";
                                    } else {
                                        echo "<td></td>";
                                    }
                                }

                                // Display Action column with buttons for each row
                                echo "<td>";
                                // Check if 'cp_state', 'cp_city', and 'cp_distance' are set before creating the links
                                if (isset($stateData['cp_state'])) {


                                    echo "<a href ='placeelupdate.php?state=" . $stateData['cp_state'] . "&city=" . $cityData['cp_city'] . "&distance=" . $cityData['cp_distance'] . "' class='btn btn-warning m-2' >Update</a>";

                                    echo "<a href ='placeeldelete.php?state=" . $stateData['cp_state'] . "&city=" . $cityData['cp_city'] . "&distance=" . $cityData['cp_distance'] . "' class='btn btn-primary m-2' >Delete</a>";

                                    $firstCity = false;
                                }
                                echo "</td>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
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
    function confirmDelete(name, type) {
        if (confirm("Are you sure you want to delete item '" + name + "' with type '" + type + "'?")) {
            // Use PHP to redirect
            window.location.href = 'itemdeleteprocess.php?id=' + encodeURIComponent(name + ',' + type);
        }
    }
</script>


<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


<?php include 'footer.php'; ?>