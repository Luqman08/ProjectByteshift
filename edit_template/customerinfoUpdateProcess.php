<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbcon.php');

//retreive data from form 
$fID = $_POST['fID'];
$fname = $_POST['fname'];
$femail = $_POST['femail'];
$fphone = $_POST['fphone'];


//CRUD:UPDATE current item in inventory
$sql = "UPDATE tb_customer
 SET c_name='$fname', c_email='$femail', c_phone='$fphone'
 WHERE c_id='$fID'";

mysqli_query($con, $sql);
mysqli_close($con);


//Display result
header('Location:customerinfo.php');
