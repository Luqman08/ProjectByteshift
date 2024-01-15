<?php
include('dbcon.php');

if (isset($_GET['id'])) {
    $qc_OCID = $_GET['id'];

    // Perform the deletion
    $deleteQuery = "DELETE FROM quotecons WHERE qc_OCID = '$qc_OCID'";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        echo "Quotation deleted successfully.";

        // Redirect
        header('Location:quotationlistCons.php');
    } else {
        echo "Error deleting quotation: " . mysqli_error($con);
    }
} else {
    echo "Invalid request. Please provide a valid quotation ID.";
}

mysqli_close($con);
