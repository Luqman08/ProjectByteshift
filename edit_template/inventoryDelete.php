<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

// Get item id from url
if (isset($_GET['id'])) {
    $fID = $_GET['id'];
}

include('dbcon.php');

// Identify associated quotations
$query = "SELECT DISTINCT tb_order.o_id
          FROM tb_order
          INNER JOIN tb_orderproduct ON tb_order.o_id = tb_orderproduct.op_orderid
          WHERE tb_orderproduct.op_productid = ?";

$stmtQuotations = mysqli_prepare($con, $query);

if ($stmtQuotations) {
    mysqli_stmt_bind_param($stmtQuotations, "i", $fID);
    mysqli_stmt_execute($stmtQuotations);

    // Fetch the result before executing another statement
    $resultQuotations = mysqli_stmt_get_result($stmtQuotations);

    // Delete associated quotations
    while ($row = mysqli_fetch_assoc($resultQuotations)) {
        $quotationId = $row['o_id'];
        $deleteQuotationQuery = "DELETE FROM tb_order WHERE o_id = ?";
        $stmtDeleteQuotation = mysqli_prepare($con, $deleteQuotationQuery);

        if ($stmtDeleteQuotation) {
            mysqli_stmt_bind_param($stmtDeleteQuotation, "i", $quotationId);
            mysqli_stmt_execute($stmtDeleteQuotation);
            mysqli_stmt_close($stmtDeleteQuotation);
        } else {
            // Handle prepare error for quotation deletion
            echo "Error preparing statement to delete quotation: " . mysqli_error($con);
        }
    }

    mysqli_stmt_close($stmtQuotations);
} else {
    // Handle prepare error for associated quotations identification
    echo "Error preparing statement to identify associated quotations: " . mysqli_error($con);
}

// CRUD Delete using prepared statement for inventory item
$sqlDeleteProduct = "DELETE FROM tb_product WHERE p_id = ?";
$stmtDeleteProduct = mysqli_prepare($con, $sqlDeleteProduct);

if ($stmtDeleteProduct) {
    mysqli_stmt_bind_param($stmtDeleteProduct, "i", $fID);

    if (mysqli_stmt_execute($stmtDeleteProduct)) {
        mysqli_stmt_close($stmtDeleteProduct);
        mysqli_close($con);

        // Redirect
        header('Location:inventoryList.php');
        exit();
    } else {
        // Handle execution error for inventory item deletion
        echo "Error executing statement to delete inventory item: " . mysqli_error($con);
    }
} else {
    // Handle prepare error for inventory item deletion
    echo "Error preparing statement to delete inventory item: " . mysqli_error($con);
}

// If you reach here, something went wrong
mysqli_close($con);
