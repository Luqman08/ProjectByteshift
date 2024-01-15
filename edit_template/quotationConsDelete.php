<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

// Get booking id from url
if (isset($_GET['id'])) {
    $fID = $_GET['id'];
}

include('dbcon.php');

// CRUD Delete using prepared statement
$sql = "DELETE FROM quotecons WHERE qc_OCID = ?";
$stmt = mysqli_prepare($con, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $fID); // "i" represents integer type

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
