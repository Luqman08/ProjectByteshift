<?php
// Include the common header file
include 'header.php';

// Include the database connection
include 'dbcon.php';

// Include the PHP code for order management
include 'manageorderprocess.php';

include('mysession.php');
if (!session_id()) {

    session_start();
}


// Flag to check if order details have been displayed
$orderDetailsDisplayed = false;

// Function to create a new order

function createOrder($customerId, $products)
{
    global $con, $orderDetailsDisplayed;  // Add this line

    // Start a transaction
    $con->begin_transaction();

    // Insert order details into tb_order
    $insertOrderQuery = "INSERT INTO tb_order (o_cid, o_date) VALUES ($customerId, NOW())";
    $con->query($insertOrderQuery);

    // Get the order ID of the newly inserted order
    $orderId = $con->insert_id;

    // Insert product details into tb_orderproduct for each product
    foreach ($products as $product) {
        $productId = $product['product_id'];
        $quantity = $product['quantity'];

        // Check if the quantity is sufficient
        if (!isQuantitySufficient($productId, $quantity)) {
            // Rollback the transaction and display an error message
            $con->rollback();
            echo "<p class='text-danger'>Error: Insufficient quantity for Product #$productId. Order not placed.</p>";
            return;
        }

        $insertProductQuery = "INSERT INTO tb_orderproduct (op_orderid, op_productid, op_quantity, op_total_price, op_balance) VALUES ($orderId, $productId, $quantity, $quantity * (SELECT p_price_after_markup FROM tb_product WHERE p_id = $productId), $quantity * (SELECT p_price_after_markup FROM tb_product WHERE p_id = $productId))";
        $con->query($insertProductQuery);

        // Update the product quantity in tb_product
        $updateProductQuantityQuery = "UPDATE tb_product SET p_quantity = p_quantity - $quantity WHERE p_id = $productId";
        $con->query($updateProductQuantityQuery);
    }

    // Commit the transaction
    $con->commit();

    // Update the grand total for the order
    updateGrandTotal($orderId);

    // Set the flag to true
    $orderDetailsDisplayed = true;  // Change to use the global variable

    // Return the generated order ID
    return $orderId;
}

// Function to check if the quantity of a product is sufficient
function isQuantitySufficient($productId, $quantity)
{
    global $con;

    $checkQuantityQuery = "SELECT p_quantity FROM tb_product WHERE p_id = $productId";
    $result = $con->query($checkQuantityQuery);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['p_quantity'] >= $quantity;
    }

    return false;
}

// Function to get customer details based on customer ID
function getCustomerDetails($customerId)
{
    global $con;

    $getCustomerQuery = "SELECT * FROM tb_customer WHERE c_id = '$customerId'";
    $result = $con->query($getCustomerQuery);

    if ($result && $row = $result->fetch_assoc()) {
        return $row;
    }

    return null;
}

// Get product data for the dropdown
$productQuery = "SELECT p_id, p_name FROM tb_product";
$productResult = $con->query($productQuery);


?>

<!DOCTYPE html>
<html lang="en">







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
<!-- Sidebar End -->

<body>
    <!-- Content Start -->

    <!-- Navbar Start -->

    <!-- Navbar End -->



    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $customerId = $_POST['customer_id'];
        $products = $_POST['products'];

        $customerDetails = getCustomerDetails($customerId);

        if (!$customerDetails) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <i class='fa fa-exclamation-circle me-2'></i>Error: Customer not found for ID #$customerId.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
        } else {
            // Create the order
            $orderId = createOrder($customerId, $products);

            // Display success alert if the order is created successfully
            if ($orderId) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <i class='fa fa-exclamation-circle me-2'></i>Order created successfully! Check the details below.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
            }

            echo "<div class='container-fluid pt-4 px-4'>";
            echo "<div class='row g-4'>";
            echo "<div class='col-sm-12'>";
            echo "<div class='bg-secondary rounded h-100 p-4'>";
            echo "<h6 class='mb-4'>Order Details</h6>";

            // Display customer details
            echo "<p>Customer ID: {$customerDetails['c_id']}</p>";
            echo "<p>Customer Name: {$customerDetails['c_name']}</p>";
            echo "<p>Customer Email: {$customerDetails['c_email']}</p>";
            echo "<p>Customer Phone: {$customerDetails['c_phone']}</p>";

            // Display order details
            echo "<p>Order ID: $orderId</p>";

            // Display product details
            echo "<h6 class='mt-4 mb-2'>Products:</h6>";
            echo "<ul>";
            foreach ($products as $product) {
                echo "<li>Product ID: {$product['product_id']}, Quantity: {$product['quantity']}</li>";
            }
            echo "</ul>";

            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

            $orderDetailsDisplayed = true;
        }
    }
    ?>

    <!-- Blank Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h4 class="mb-4">Order Form</h4>
                    <!-- Create Order Form -->
                    <form method="post">
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer ID</label>
                            <input type="text" class="form-control" id="customer_id" name="customer_id" required>
                        </div>
                        <div id="products-container">
                            <div class="product-input mb-3">
                                <label for="product_id" class="form-label">Product ID</label>
                                <select class="form-control" name="products[0][product_id]" required>
                                    <?php while ($row = $productResult->fetch_assoc()) : ?>
                                        <option value="<?php echo $row['p_id']; ?>">
                                            <?php echo $row['p_name']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" min="0" class="form-control" name="products[0][quantity]" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addProductInput()">Add
                            Product</button>
                        <button type="submit" class="btn btn-primary">Submit Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addProductInput() {
            const container = document.getElementById('products-container');
            const index = container.children.length;
            const newProductInput = document.createElement('div');
            newProductInput.classList.add('product-input', 'mb-3');
            newProductInput.innerHTML = `
                <label for="product_id" class="form-label">Product ID</label>
                <select class="form-control" name="products[${index}][product_id]" required>
                    <?php $productResult->data_seek(0); // Reset result pointer 
                    ?>
                    <?php while ($row = $productResult->fetch_assoc()) : ?>
                                                                <option value="<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></option>
                    <?php endwhile; ?>
                </select>
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" name="products[${index}][quantity]" required>
            `;
            container.appendChild(newProductInput);
        }
    </script>

</body>

<!-- Blank End -->


<!-- Footer Start -->

<!-- Content End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


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
    function addProductInput() {
        const container = document.getElementById('products-container');
        const index = container.children.length;
        const newProductInput = document.createElement('div');
        newProductInput.classList.add('product-input', 'mb-3');
        newProductInput.innerHTML = `
                <label for="product_id" class="form-label">Product ID</label>
                <select class="form-control" name="products[${index}][product_id]" required>
                    <?php $productResult->data_seek(0); // Reset result pointer 
                    ?>
                    <?php while ($row = $productResult->fetch_assoc()) : ?>
                                                                                                <option value="<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></option>
                    <?php endwhile; ?>
                </select>
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" name="products[${index}][quantity]" required>
            `;
        container.appendChild(newProductInput);
    }
</script>
<?php
include 'footer.php'; ?>