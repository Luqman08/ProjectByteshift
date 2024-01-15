<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

// Get Order Construction ID from the URL
if (isset($_GET['id'])) {
    $qc_OCID = $_GET['id'];
} else {
    echo "Error: Order Construction ID not provided.";
    exit();
}

include('dbcon.php');

// Validate and sanitize the input
$qc_OCID = mysqli_real_escape_string($con, $qc_OCID);

// CRUD Delete using prepared statement
$sql = "DELETE FROM quotecons WHERE qc_OCID = ?";
$stmt = mysqli_prepare($con, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $qc_OCID);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($con);

        // Redirect
        header('Location:quotationlistCons.php');
        exit();
    } else {
        // Handle execution error
        echo "Error executing statement: " . mysqli_error($con);
    }
} else {
    // Handle prepare error
    echo "Error preparing statement: " . mysqli_error($con);
}

// If you reach here, something went wrong
mysqli_close($con);
