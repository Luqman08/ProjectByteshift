<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbcon.php');

//retreive data from form 
$fID = $_POST['fID'];
$fname = $_POST['fname'];
$funitprice = $_POST['funitprice'];
$fquantity = $_POST['fquantity'];
$fminimum = $_POST['fminimum'];
$fmarkup = $_POST['fmarkup'];


//CRUD:UPDATE current item in inventory
$sql = "UPDATE tb_product
 SET p_name='$fname', p_price='$funitprice', p_quantity='$fquantity',p_minimum='$fminimum', p_markup='$fmarkup'
 WHERE p_id='$fID'";

mysqli_query($con, $sql);
mysqli_close($con);


//Display result
header('Location:inventoryList.php');
