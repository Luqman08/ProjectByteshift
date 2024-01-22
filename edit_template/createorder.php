<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include 'header.php';
include 'dbcon.php';

$sqli = "SELECT * FROM constructionitem";
$resulti = mysqli_query($con, $sqli);

$sqlsc = "SELECT DISTINCT cp_state, cp_city FROM consplace";
$resultsc = mysqli_query($con, $sqlsc);

$sqlcc = "SELECT * FROM cust_cat";
$resultcc = mysqli_query($con, $sqlcc);

$sqlqs = "SELECT * FROM quote_status";
$resultqs = mysqli_query($con, $sqlqs);

// Fetch all rows and store them in an array
$dataArray = [];
while ($row = mysqli_fetch_assoc($resulti)) {
    $dataArray[] = $row;
}

// Fetch state and city data
$stateArray = [];
$cityArray = [];
while ($row = mysqli_fetch_assoc($resultsc)) {
    $stateArray[] = $row['cp_state'];
    $cityArray[] = $row;
}

// Remove duplicates from stateArray
$stateArray = array_unique($stateArray);

mysqli_data_seek($resultsc, 0); // Reset pointer to fetch city data again
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
<?php
if (isset($_SESSION['duplicateOrder'])) {
    $duplicateOrder = $_SESSION['duplicateOrder'];
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>' . $duplicateOrder . '. Please update the information.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['duplicateOrder']); // Clear the session variable
}
?>

<form method="POST" action="createorderprocess.php">
    <div class="container-fluid pt-4 px-4">
        <div class="container-fluid pt-4 px-4">
            <div class="bg-secondary rounded h-100 p-4">
                <fieldset>
                    <h6 class="mb-4">Create New Order</h6>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="ocid" id="floatingInput">
                        <label for="floatingInput">Order Quotation</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="cname" id="floatingInput">
                        <label for="floatingInput">Customer Name</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="cemail" id="floatingInput">
                        <label for="floatingInput">Customer Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="cphone" id="floatingInput">
                        <label for="floatingInput">Customer Phone Number</label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control" name="caddress" placeholder="Leave a comment here" id="floatingTextarea" style="height: 150px;"></textarea>
                        <label for="floatingTextarea">Customer Address</label>
                    </div><br>

                    <div class="form-floating mb-3">
                        <select class="form-select" name="ccat" aria-label="Floating label select example">
                            <?php
                            while ($rowcc = mysqli_fetch_array($resultcc)) {
                                echo '<option value="' . $rowcc["cc_id"] . '">' . $rowcc["cc_desc"] . '</option>';
                            }
                            ?>
                        </select>
                        <label for="floatingSelect">Customer Category</label>
                    </div>


                    <div id="itemFields">
                        <!-- Initial item field -->
                        <div class="item-section">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="ocname[]" aria-label="Floating label select example" onchange="updateItemTypes(this)">
                                    <?php
                                    $uniqueItemNames = array_unique(array_column($dataArray, 'CI_name'));
                                    foreach ($uniqueItemNames as $itemName) {
                                        echo '<option value="' . $itemName . '">' . $itemName . '</option>';
                                    }
                                    ?>
                                </select>
                                <label for="floatingSelect">Item Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" name="octype[]" aria-label="Floating label select example">
                                    <!-- Item types will be dynamically populated based on the selected item name -->
                                </select>
                                <label for="floatingSelect">Item Type</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" min="0" class="form-control" name="ocquantity[]" id="floatingInput">
                                <label for="floatingInput">Item Quantity</label>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success mb-3 btn-add-item">Add Item</button>

                    <div class="form-floating mb-3">
                        <select class="form-select" name="ocstate" aria-label="Floating label select example">
                            <?php
                            foreach ($stateArray as $state) {
                                echo '<option value="' . $state . '">' . $state . '</option>';
                            }
                            ?>
                        </select>
                        <label for="floatingSelect">Item State</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="occity" aria-label="Floating label select example">
                            <?php
                            foreach ($cityArray as $city) {
                                echo '<option value="' . $city['cp_city'] . '">' . $city['cp_city'] . '</option>';
                            }
                            ?>
                        </select>
                        <label for="floatingSelect">Item City</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" name="ocdistance" aria-label="Floating label select example">
                            <option selected>Open this select menu</option>
                            <option value="15">Less than 15km(Engineering Item)</option>
                            <option value="30">15-30km(Engineering Item)</option>
                            <option value="40">30-50km(Engineering Item)</option>
                            <option value="50">50-75km(Engineering Item)</option>
                            <option value="75">More than 75km(Engineering Item)</option>
                            <option value="16">Less than 16km(Electrical Item)</option>
                            <option value="32">16-32km(Electrical Item)</option>
                            <option value="45">32-48km(Electrical Item)</option>
                            <option value="48">More than 48km(Electrical Item)</option>
                        </select>
                        <label for="floatingSelect">Distance</label>
                    </div>
                    <div class="form-floating mb-3">

                        <input type="date" class="form-control" id="floatinginput" name="ocidate">

                        <label for="floatingInput">Quotation Issue Date</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" name="ocedate" id="floatingInput">
                        <label for="floatingInput">Quotation Expiry Date</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" name="qstat" aria-label="Floating label select example">
                            <?php
                            while ($rowqs = mysqli_fetch_array($resultqs)) {
                                echo '<option value="' . $rowqs["qs_ID"] . '">' . $rowqs["qs_desc"] . '</option>';
                            }
                            ?>
                        </select>
                        <label for="floatingSelect">Quotation Status</label>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <button type="submit" class="btn btn-primary w-100">Create Order</button>
                    </div>
                    <div class="col-md-6 mb-2">
                        <button type="button" onclick="resetForm()" class="btn btn-primary w-100">Reset</button>
                    </div>
                </div>
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
<script>
    var stateArray = <?php echo json_encode($stateArray); ?>;
    var cityArray = <?php echo json_encode($cityArray); ?>;
    var itemData = <?php echo json_encode($dataArray); ?>;

    document.addEventListener('DOMContentLoaded', function() {

        // Initial call to populate item types for the first item field
        updateItemTypes(document.querySelector('[name="ocname[]"]'));
    });

    function addItemField() {
        var itemFields = document.getElementById('itemFields');
        var newItemSection = document.createElement('div');
        newItemSection.classList.add('item-section');

        // Fetch unique item names
        var uniqueItemNames = <?php echo json_encode(array_unique(array_column($dataArray, 'CI_name'))); ?>;

        // Append item fields to the new section
        newItemSection.innerHTML = `
        <div id="itemFields">
                        <!-- Initial item field -->
                        <div class="item-section">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="ocname[]" aria-label="Floating label select example" onchange="updateItemTypes(this)">
                                    <?php
                                    $uniqueItemNames = array_unique(array_column($dataArray, 'CI_name'));
                                    foreach ($uniqueItemNames as $itemName) {
                                        echo '<option value="' . $itemName . '">' . $itemName . '</option>';
                                    }
                                    ?>
                                </select>
                                <label for="floatingSelect">Item Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" name="octype[]" aria-label="Floating label select example">
                                    <!-- Item types will be dynamically populated based on the selected item name -->
                                </select>
                                <label for="floatingSelect">Item Type</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="ocquantity[]" id="floatingInput">
                                <label for="floatingInput">Item Quantity</label>
                            </div>
                            <button type="button" onclick="removeItemField(this.parentNode)" class="btn btn-danger mb-3">Remove Item</button>
                        </div>
                    </div>
        `;

        itemFields.appendChild(newItemSection);

        // Call updateItemTypes to populate item types for the newly added item
        updateItemTypes(newItemSection.querySelector('[name="ocname[]"]'));

        // Update item numbers after appending
        updateItemNumbers();

        // Attach event listener to the newly created "Remove Item" button
        newItemSection.querySelector('.btn-danger').addEventListener('click', function() {
            removeItemField(newItemSection);
        });
    }

    function removeItemField(itemSection) {
        // Remove the item section
        itemSection.remove();

        // Update numbering after removal
        updateItemNumbers();
    }

    function updateItemNumbers() {
        var itemSections = document.querySelectorAll('.item-section');
        itemSections.forEach(function(section, index) {
            // Update the label text to show the item number
            var labels = section.querySelectorAll('label');
            labels.forEach(function(label) {
                label.textContent = label.textContent.replace(/\d+/, index + 1);
            });
        });
    }

    function resetForm() {
        // Reset the form by setting its innerHTML to an empty string
        document.getElementById('itemFields').innerHTML = '';

        // Add a new item field after reset
        addItemField();
    }

    function updateItemCities(selectElement) {
        var selectedState = selectElement.value;
        var citySelect = selectElement.closest('.item-section').querySelector('[name="occity"]');

        // Clear existing options
        citySelect.innerHTML = '';

        // Add a default option
        citySelect.options.add(new Option('Select City', ''));

        // Filter cities based on the selected state
        var citiesInState = cityArray.filter(city => city.cp_state === selectedState);

        // Add options for the selected state
        citiesInState.forEach(function(city) {
            citySelect.options.add(new Option(city.cp_city, city.cp_city));
        });
    }

    function updateItemTypes(selectElement) {
        var selectedName = selectElement.value;
        var itemTypesSelect = selectElement.closest('.item-section').querySelector('[name="octype[]"]');

        // Clear existing options
        itemTypesSelect.innerHTML = '';

        // Filter unique item types based on the selected item name
        var uniqueItemTypes = [...new Set(
            itemData.filter(item => item.CI_name === selectedName).map(item => item.CI_type)
        )];

        // Add a default option
        itemTypesSelect.options.add(new Option('Select Type', ''));

        // Add options for the selected item name
        uniqueItemTypes.forEach(function(itemType) {
            itemTypesSelect.options.add(new Option(itemType, itemType));
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Attach event listener to the form submission
        document.querySelector('form').addEventListener('submit', function(event) {
            // Get the issue date and expiry date values
            var issueDate = new Date(document.querySelector('[name="ocidate"]').value);
            var expiryDate = new Date(document.querySelector('[name="ocedate"]').value);

            // Check if expiry date is less than issue date
            if (expiryDate < issueDate) {
                // Show a popup notification
                alert('Expiry date cannot be less than the issue date. Please enter valid dates.');

                // Prevent form submission
                event.preventDefault();
            }
        });

        // Attach event listener to the "Add Item" button
        document.querySelector('.btn-add-item').addEventListener('click', function() {
            addItemField();
        });

        // Initial call to populate item types for the first item field
        updateItemTypes(document.querySelector('[name="ocname[]"]'));
    });
</script>

<script>
    // Add this script to show/hide the alert based on the URL parameter
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const duplicate = urlParams.get('duplicate');

        if (duplicate === 'true') {
            // Show the alert
            $('.alert').show();
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#ocidate').datepicker({
            format: 'yyyy-mm-dd', // Adjust the format as needed
            autoclose: true
        });
    });
</script>


<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

<?php include 'footer.php'; ?>