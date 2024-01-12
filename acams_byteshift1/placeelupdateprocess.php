<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include('dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $percentage = $_POST['ipercentage'];

    // Validate and sanitize data
    $percentage = filter_var($percentage, FILTER_SANITIZE_STRING);

    // Check if state, city, and distance parameters are set
    if (isset($_GET['id'])) {
        list($fstate, $fcity, $fdis) = explode(",", $_GET['id']);

        // Update the consplace table
        $sql = "UPDATE consplace SET cp_percentage = ? WHERE cp_state = ? AND cp_city = ? AND cp_distance = ?";
        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "dsss", $percentage, $fstate, $fcity, $fdis);
            $result = mysqli_stmt_execute($stmt);

            // Check the result of the update operation
            if ($result) {
                $_SESSION['success_message'] = 'Place percentage updated successfully.';
            } else {
                $_SESSION['error_message'] = 'Error updating place percentage.';
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['error_message'] = 'Error preparing the update statement.';
        }
    } else {
        $_SESSION['error_message'] = 'Invalid parameters.';
    }

    // Redirect back to the page
    header("Location: managecons.php");
    exit();
} else {
    // If the form is not submitted via POST, redirect to the home page
    header("Location: index.html");
    exit();
}
