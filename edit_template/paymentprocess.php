<?php
include 'dbcon.php';

include('mysession.php');
if (!session_id()) {

    session_start();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the form has already been processed
    if (!isset($_POST['payment_processed'])) {
        // Set a flag to indicate that the form has been processed
        $_POST['payment_processed'] = true;

        // Initialize the alert message
        $alertMessage = "";

        // Sanitize and validate input data
        $orderID = mysqli_real_escape_string($con, $_POST['order_id']);

        // Check if order ID is valid
        $checkOrderQuery = "SELECT op_balance FROM tb_orderproduct WHERE op_orderid = '$orderID'";
        $result = mysqli_query($con, $checkOrderQuery);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $paymentBalance = $row['op_balance'];

            // Only proceed if order ID is valid
            if (isset($_POST['amount']) && $_POST['amount'] <= $paymentBalance) {
                $transaction_date = mysqli_real_escape_string($con, $_POST['transaction_date']);
                $payment_type = mysqli_real_escape_string($con, $_POST['payment_type']);
                $transaction_type = mysqli_real_escape_string($con, $_POST['transaction_type']);
                $amount = mysqli_real_escape_string($con, $_POST['amount']);

                // Upload Evidence
                $evidence_path = '';
                if ($_FILES['evidence']['size'] > 0) {
                    $upload_dir = 'evidence/';
                    $evidence_name = basename($_FILES['evidence']['name']);
                    $evidence_path = $upload_dir . $evidence_name;

                    // Check if the directory exists, create it if not
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }

                    // Move uploaded file to the destination directory
                    if (move_uploaded_file($_FILES['evidence']['tmp_name'], $evidence_path)) {
                        // File uploaded successfully, set the success message
                        $insertPaymentQuery = "INSERT INTO tb_payment (order_id, transaction_date, payment_type, transaction_type, amount, evidence_path) VALUES ('$orderID', '$transaction_date', '$payment_type', '$transaction_type', '$amount', '$evidence_path')";
                        mysqli_query($con, $insertPaymentQuery);

                        // Update payment balance statement
                        $updateBalanceQuery = "UPDATE tb_orderproduct SET op_balance = op_balance - '$amount' WHERE op_orderid = '$orderID'";
                        mysqli_query($con, $updateBalanceQuery);

                        // Retrieve updated payment balance statement
                        $getBalanceStatementQuery = "SELECT op_balance FROM tb_orderproduct WHERE op_orderid = '$orderID'";
                        $result = mysqli_query($con, $getBalanceStatementQuery);

                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            $paymentBalanceStatement = $row['op_balance'];

                            // Set the success alert message
                            $alertMessage = "File uploaded successfully! Payment Balanced: RM" . $paymentBalanceStatement;
                        } else {
                            $alertMessage = "Error retrieving balance information.";
                        }
                    } else {
                        $alertMessage = "Error moving uploaded file. Check directory permissions and paths.";
                    }
                }
            } else {
                // Set the failure alert message
                $alertMessage = "Invalid amount or amount exceeds the balance. Please enter a valid amount.";
            }
        } else {
            // Set the failure alert message
            $alertMessage = "Invalid order ID. Please enter a valid order ID.";
        }

        // Pass the alert message to the session variable
        
        $_SESSION['payment_alert'] = $alertMessage;
    }
}
