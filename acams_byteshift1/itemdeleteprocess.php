<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include('dbcon.php');

if (isset($_GET['id'])) {
    list($fName, $fType) = explode(',', $_GET['id']);

    $sql = "DELETE FROM constructionitem WHERE CI_name = '$fName' AND CI_type = '$fType'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $_SESSION['success_message'] = "Item deleted successfully!";
        header("Location: managecons.php"); // Replace 'your_previous_page.php' with the actual page
        exit();
    } else {
        $_SESSION['error_message'] = "Error deleting item: " . mysqli_error($con);
        header("Location: managecons.php"); // Replace 'your_previous_page.php' with the actual page
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid parameters!";
    header("Location: managecons.php"); // Replace 'your_previous_page.php' with the actual page
    exit();
}
?>
