<?php
//include 'headercust.php'; 
include('mysession.php');
if (!session_id()) {
    session_start();
}

// Get user ID from URL
if (isset($_GET['id'])) {
    $fbid = $_GET['id'];
}

include('dbcon.php');

// CURD: Delete
$sql = "DELETE FROM tb_user WHERE u_id='$fbid'";
$result = mysqli_query($con, $sql);

mysqli_close($con);

// Redirect
header('location: managestaff.php');
