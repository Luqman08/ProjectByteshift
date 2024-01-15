<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}

include('dbcon.php');

// Process the form submission and add the new item to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $itemName = mysqli_real_escape_string($con, $_POST['iname']);
  $itemType = mysqli_real_escape_string($con, $_POST['itype']);
  $itemCategory = mysqli_real_escape_string($con, $_POST['icat']);
  $itemUnit = mysqli_real_escape_string($con, $_POST['iunit']);
  $itemPrice = mysqli_real_escape_string($con, $_POST['iprice']);

  // Check for duplicate entry
  $checkDuplicateSql = "SELECT * FROM constructionitem WHERE CI_name='$itemName' AND CI_type='$itemType' AND CI_category='$itemCategory'";
  $checkDuplicateResult = mysqli_query($con, $checkDuplicateSql);

  if (mysqli_num_rows($checkDuplicateResult) > 0) {
    // Duplicate entry found
    $_SESSION['error_message'] = "Error: The item name, type, and category already exist.";
  } else {
    // Insert data into the database
    $sql = "INSERT INTO constructionitem (CI_name, CI_type, CI_category, CI_unit, CI_price) VALUES ('$itemName', '$itemType', '$itemCategory', '$itemUnit', '$itemPrice')";

    if (mysqli_query($con, $sql)) {
      // Item added successfully
      $_SESSION['success_message'] = "New item added successfully!";
    } else {
      // Error adding item
      $_SESSION['error_message'] = "Error: " . mysqli_error($con);
    }
  }

  // Redirect back to the form page
  header("Location: managecons.php");
  exit();
}
