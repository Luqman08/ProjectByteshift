<?php include 'headercust.php'; 
include('mysession.php');
if(!session_id())
{
  session_start();
}

//Get booking ID from URL
if(isset($_GET['idd']))
{
  $fbid=$_GET['idd'];
}

include('dbcon.php');

//CURD: Delete
$sql="DELETE FROM tb_data WHERE idd='$fbid'";
$result-mysqli_query($con,$sql);
mysqli_close($con);

//Redirect
header('location:managestaff.php');
?>