<!-- manageorder.php -->
<?php
// Start or resume the session
session_start();

// Include the common header file

include 'header.php';
// Include the database connection
include('dbcon.php');

// Include the PHP code for order management
include 'manageorderprocess.php';

// Initialize order ID in session if not set
if (!isset($_SESSION['order_id'])) {
    $_SESSION['order_id'] = null;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $orderId = $_POST['order_id'];
        $_SESSION['order_id'] = $orderId; // Store order ID in session
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $result = addProductToOrder($orderId, $productId, $quantity);
        if ($result === true) {
            $_SESSION['popup_message'] = "Product #$productId added to the order successfully!";
        } else {
            $_SESSION['popup_message'] = "Product #$productId is already in the order. To update the quantity, use the 'Update Quantity' option.";
        }
    } elseif (isset($_POST['update_quantity'])) {
        $orderProductId = $_POST['order_product_id'];
        $newQuantity = $_POST['new_quantity'];
        updateProductQuantity($orderProductId, $newQuantity);
    } elseif (isset($_POST['delete_product'])) {
        $orderProductId = $_POST['order_product_id'];
        deleteProductFromOrder($orderProductId);
    }
}

// Function to get order details with associated products
function getOrderDetails($orderId)
{
    global $con;

    $query = "SELECT tb_order.o_id as order_id, tb_customer.c_name as customer_name, o_date, 
                     tb_product.p_id as product_id, tb_product.p_name as product_name, tb_product.p_price, op_quantity, tb_orderproduct.op_id as order_product_id,
                     (tb_product.p_price * tb_orderproduct.op_quantity) as total_price
              FROM tb_order
              JOIN tb_customer ON tb_order.o_cid = tb_customer.c_id
              JOIN tb_orderproduct ON tb_order.o_id = tb_orderproduct.op_orderid
              JOIN tb_product ON tb_orderproduct.op_productid = tb_product.p_id
              WHERE tb_order.o_id = $orderId";

    $result = $con->query($query);

    $orderDetails = array();
    while ($row = $result->fetch_assoc()) {
        $orderDetails[] = $row;
    }

    return $orderDetails;
}

// Function to get all product IDs for the dropdown
function getAllProductIDs()
{
    global $con;

    $query = "SELECT p_id FROM tb_product";
    $result = $con->query($query);

    $productIDs = array();
    while ($row = $result->fetch_assoc()) {
        $productIDs[] = $row['p_id'];
    }

    return $productIDs;
}

?>


<script>
    <?php
    if (isset($_SESSION['popup_message'])) {
        echo "alert('{$_SESSION['popup_message']}');";
        unset($_SESSION['popup_message']); // Clear the message after displaying
    }
    ?>
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
                <a href="manageorder.php" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Advertisment</a>
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
<!-- Sidebar End -->


<!-- Content Start -->

<body>
    <!-- Navbar End -->


    <!-- Blank Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">


            <!-- Inserted template code for Basic Table -->
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Basic Table</h6>
                <h2>Order Details</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="order_id" class="form-label">Order ID:</label>
                        <input type="text" class="form-control" name="order_id" value="<?php echo $_SESSION['order_id']; ?>" placeholder="Enter Order ID" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Show Order Details</button>
                </form>
            </div>

            <!-- Inserted template code for Bordered Table -->
            <div class="bg-secondary rounded h-100 p-4 mt-4">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
                    $orderId = $_POST['order_id'];
                    $_SESSION['order_id'] = $orderId; // Update order ID in session
                    $orderDetails = getOrderDetails($orderId);

                    if (!empty($orderDetails)) {
                        echo "<h3>Order #$orderId Details</h3>";
                        echo "<p>Customer: {$orderDetails[0]['customer_name']}</p>";
                        echo "<p>Order Date: {$orderDetails[0]['o_date']}</p>";

                        echo "<table class='table table-bordered'>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>";

                        $grandTotal = 0;

                        foreach ($orderDetails as $item) {
                            echo "<tr>
                                <td>{$item['product_id']}</td>
                                <td>{$item['product_name']}</td>
                                <td>{$item['op_quantity']}</td>
                                <td>{$item['p_price']}</td>
                                <td>{$item['total_price']}</td>
                                <td>
                                    <form class='row g-2' method='post'>
                                        <div class='col-md-4'>
                                            <input type='hidden' name='order_product_id' value='{$item['order_product_id']}'>
                                            <label for='new_quantity' class='visually-hidden'>New Quantity:</label>
                                            <input type='number' class='form-control' name='new_quantity' required>
                                        </div>
                                        <div class='col-md-4'>
                                            <button type='submit' class='btn btn-success btn-sm' name='update_quantity'>Update</button>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <form method='post' onsubmit=\"return confirm('Are you sure you want to delete this product from the order?');\">
                                        <div class='col-md-4'>
                                            <input type='hidden' name='order_product_id' value='{$item['order_product_id']}'>
                                            <button type='submit' class='btn btn-danger btn-sm' name='delete_product'>Delete</button>
                                        </div>
                                    </form>
                                </td>
                              </tr>";

                            $grandTotal += $item['total_price'];
                        }
                        echo "</table>";

                        // Separate form for adding a new product (outside the loop)
                        echo "<form method='post' class='mt-3'>
                            <input type='hidden' name='order_id' value='$orderId'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <label for='product_id' class='form-label'>Product ID:</label>
                                    <input type='text' class='form-control' name='product_id' placeholder='Enter Product ID' required>
                                </div>
                                <div class='col-md-3'>
                                    <label for='quantity' class='form-label'>Quantity:</label>
                                    <input type='number' class='form-control' name='quantity' required>
                                </div>
                                <div class='col-md-3'>
                                    <label for='quantity' class='form-label'>Action:</label>
                                    <br>
                                    <button type='submit' class='btn btn-success' name='add_product'>Add Product</button>
                                </div>
                            </div>
                        </form>";

                        // Display the total price for the order
                        echo "<p class='mt-3'>Total Price for Order #$orderId: $grandTotal</p>";
                    } else {
                        echo "<p>No order found with ID #$orderId.</p>";
                    }
                }
                ?>
            </div>

        </div>
    </div>
    <!-- Blank End -->



    <!-- Footer End -->
</body>
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

<!-- Template Javascript -->
<script src="js/main.js"></script>

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


<?php include 'footer.php'; ?>