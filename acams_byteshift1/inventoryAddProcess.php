<?php
// Connect to DB
include("dbcon.php");

// Retrieve data from registration form
$fID = $_POST['fID'];
$fname = $_POST['fname'];
$funitprice = $_POST['funitprice'];
$fquantity = $_POST['fquantity'];
$fminimum = $_POST['fminimum'];
$fmarkup = $_POST['fmarkup'];

// CRUD Operation
// CREATE - SQL Insert statement with prepared statement
$sql = "INSERT INTO tb_product (p_id, p_name, p_price, p_quantity,p_minimum, p_markup) VALUES (?, ?, ?, ?,?, ?)";

// Prepare the statement
$stmt = mysqli_prepare($con, $sql);

if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "isdiid", $fID, $fname, $funitprice, $fquantity, $fminimum, $fmarkup);

        // Execute SQL
        if (mysqli_stmt_execute($stmt)) {
                // Close the statement and DB connection
                mysqli_stmt_close($stmt);
                mysqli_close($con);

                // Redirect to next page
                header('Location: inventoryList.php');
                exit();
        } else {
                // Handle execution error
                echo "Error executing statement: " . mysqli_stmt_error($stmt);
        }
} else {
        // Handle prepare error
        echo "Error preparing statement: " . mysqli_error($con);
}

// If you reach here, something went wrong
mysqli_close($con);
