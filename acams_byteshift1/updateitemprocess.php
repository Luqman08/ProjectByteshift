<?php

include('mysession.php');
if (!session_id()) {
    session_start();
}

include('dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $itemPrice = mysqli_real_escape_string($con, $_POST['iprice']);

    // Get values from the URL
    $idParam = $_GET['id'];
    list($itemName, $itemType, $itemCategory) = explode(",", $idParam);

    // Update data in the database
    $sql = "UPDATE constructionitem SET CI_price = ? WHERE CI_name = ? AND CI_type = ? AND CI_category = ?";

    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "dssi", $itemPrice, $itemName, $itemType, $itemCategory);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Check if any rows were affected
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // Item updated successfully
                $_SESSION['success_message'] = "Item updated successfully!";
            } else {
                // No rows were affected, i.e., no changes were made
                $_SESSION['error_message'] = "No changes were made. Please make sure the item exists.";
            }
        } else {
            // Error in executing the statement
            $_SESSION['error_message'] = "Error: " . mysqli_error($con);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Error in preparing the statement
        $_SESSION['error_message'] = "Error: " . mysqli_error($con);
    }

    // Redirect back to the form page
    header("Location: managecons.php");
    exit();
} else {
    // Invalid request method
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: managecons.php");
    exit();
}
