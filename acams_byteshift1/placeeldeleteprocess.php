<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}

include('dbcon.php');

if (isset($_GET['state']) && isset($_GET['city']) && isset($_GET['distance'])) {
  $fstate = $_GET['state'];
  $fcity = $_GET['city'];
  $fdis = $_GET['distance'];

  // Use prepared statement to prevent SQL injection
  $sql = "DELETE FROM consplace WHERE cp_state = ? AND cp_city = ? AND cp_distance = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "sss", $fstate, $fcity, $fdis);
  $result = mysqli_stmt_execute($stmt);

  if ($result) {
    $_SESSION['success_message'] = "Place deleted successfully!";
    // Redirect to managecons.php after successful deletion
    header("Location: managecons.php");
    exit();
  } else {
    $_SESSION['error_message'] = "Error deleting place: " . mysqli_error($con);
    // Send a JSON response to indicate deletion failure
    echo json_encode(['status' => 'error', 'message' => 'Error deleting place: ' . mysqli_error($con)]);
  }
} else {
  // Send a JSON response for invalid parameters
  echo json_encode(['status' => 'error', 'message' => 'Invalid parameters!']);
}
