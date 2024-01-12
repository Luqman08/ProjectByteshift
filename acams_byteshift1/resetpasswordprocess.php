<?php


if (isset($_POST['code'])) {
    $code = $_POST['code'];

    // Connect to DB
    $conn = new mySqli('localhost', 'root', '', 'acams_byteshift');

    if ($conn->connect_error) {
        die('Could not connect to the databse');
    }


    $verifyQuery = $conn->query("SELECT * FROM tb_user WHERE u_code='$code'  ");



    $new_password = $_POST['fpwd'];


    $changeQuery = $conn->query("UPDATE tb_user SET u_pwd='$new_password' WHERE u_code='$code' ");




    if ($changeQuery) {
        header("Location: login.php");
        $con - close();
    } else {
        header("http://localhost/acams_byteshift1/resetpassword.php?code='. $code");
    }





} else {
    // Handle the case when $code is not set
    die("Error: Code is not set. Make sure you have the correct reset link.");
}





?>