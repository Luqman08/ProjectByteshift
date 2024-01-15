<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include 'header.php';
include('dbcon.php');

// Function to get customer details with orders and statuses
function getCustomerStatus()
{
    global $con;

    $query = "SELECT tb_customer.c_id, c_name, c_email, c_phone, o_id, o_date, o_delivery_status, o_payment_status, o_payment_proof
              FROM tb_customer
              LEFT JOIN tb_order ON tb_customer.c_id = tb_order.o_cid
              ORDER BY c_id, o_id";

    $result = $con->query($query);

    $customerStatus = array();
    while ($row = $result->fetch_assoc()) {
        $customerStatus[] = $row;
    }

    return $customerStatus;
}

// Handle file upload and update payment status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
        $targetDir = 'uploads/';
        $fileName = basename($_FILES['payment_proof']['name']);
        $targetFile = $targetDir . $fileName;

        // Check if the directory exists, if not, create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $targetFile)) {
            // Update the payment status and payment proof in the database
            $orderId = $_POST['order_id'];

            // Update query with proper error handling
            $updatePaymentStatusQuery = "UPDATE tb_order SET o_payment_status = 'Paid', o_payment_proof = '$fileName' WHERE o_id = $orderId";

            if ($con->query($updatePaymentStatusQuery)) {
                // Display pop-up notification for successful update
                $successMessage = "The file " . htmlspecialchars($fileName) . " has been uploaded. Payment status and proof updated successfully.";
                echo "<script>alert('" . addslashes($successMessage) . "');</script>";
            } else {
                echo "Error updating payment status and proof: " . $con->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Handle delete payment proof
    if (isset($_POST['delete_proof'])) {
        $orderId = $_POST['order_id'];
        $deleteProofQuery = "UPDATE tb_order SET o_payment_proof = NULL, o_payment_status = 'Unpaid' WHERE o_id = $orderId";

        if ($con->query($deleteProofQuery)) {
            // Display pop-up notification for successful deletion
            echo "<script>alert('Payment proof deleted successfully. Payment status set to Unpaid.');</script>";
        } else {
            echo "Error deleting payment proof: " . $con->error;
        }
    }
}

// Get customer status
$customerStatus = getCustomerStatus();
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


<!-- Content Start -->

<body>

    <div class="container-fluid pt-4 px-4">
        <div class="container-fluid pt-4 px-4">
            <div class="bg-secondary rounded h-100 p-4">
                <?php
                // Display customer details with orders and statuses
                if (!empty($customerStatus)) {
                    echo "<div class='bg-secondary text-center rounded p-4'>
                    <div class='d-flex align-items-center justify-content-between mb-4'>
                        <h6 class='mb-0'>Status page</h6>
                    </div>
                    <div class='table-responsive'>
                        <table class='table text-start align-middle table-bordered table-hover mb-0'>
                            <thead>
                                <tr class='text-white'>

                                    <th scope='col'>Customer ID</th>
                                    <th scope='col'>Customer Name</th>
                                    <th scope='col'>Customer Email</th>
                                    <th scope='col'>Phone</th>
                                    <th scope='col'>Order ID</th>
                                    <th scope='col'>Order Date</th>
                                    <th scope='col'>Delivery Status</th>
                                    <th scope='col'>Payment Status</th>
                                    <th scope='col'>Action</th>
                                </tr>
                            </thead>
                            <tbody>";

                    foreach ($customerStatus as $item) {
                        echo "<tr>
                        <td>{$item['c_id']}</td>
                        <td>{$item['c_name']}</td>
                        <td>{$item['c_email']}</td>
                        <td>{$item['c_phone']}</td>
                        <td>{$item['o_id']}</td>
                        <td>{$item['o_date']}</td>
                        <td>{$item['o_delivery_status']}</td>
                        <td>{$item['o_payment_status']}</td>
                        <td>
                            
                                <button class='btn btn-success w-100' onclick='showPaymentProof(\"{$item['o_payment_proof']}\")'>Show Proof</button>
                                <form method='post' onsubmit='return confirm(\"Are you sure you want to delete the payment proof?\");'>
                                    <input type='hidden' name='order_id' value='{$item['o_id']}'>
                                    <button type='submit' name='delete_proof' class='btn btn-primary w-100'>Delete Proof</button>
                                </form>
                        
                        </td>
                      </tr>";
                    }

                    echo "</tbody>
                  </table>
                </div>
              </div>";
                } else {
                    echo "<p>No customer data found.</p>";
                }
                ?>

                <!-- Form for uploading payment proof -->
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Upload Payment Proof:</label>
                        <input type="file" class="form-control bg-dark" name="payment_proof" accept=".jpg, .jpeg, .png" required>
                    </div>
                    <div class="mb-3">
                        <label for="order_id" class="form-label">Order ID:</label>
                        <input type="text" class="form-control" name="order_id" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Payment Proof</button>
                </form>

                <!-- Modal for displaying payment proof -->
                <div class="modal fade" id="paymentProofModal" tabindex="-1" role="dialog" aria-labelledby="paymentProofModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymentProofModalLabel">Payment Proof</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img id="paymentProofImage" class="img-fluid" alt="Payment Proof">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
<!-- Footer Start -->

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
    function showPaymentProof(paymentProof) {
        // Display the payment proof in the modal
        if (paymentProof !== '') {
            document.getElementById('paymentProofImage').src = 'uploads/' + paymentProof;
            $('#paymentProofModal').modal('show');
        } else {
            alert('Payment proof not available for this order.');
        }
    }
</script>

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


<?php include 'footer.php'; ?>