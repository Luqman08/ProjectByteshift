<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('connection.php');

//retreive data from form 
$fID = $_POST['fID'];
$fname = $_POST['fname'];
$fnamee = $_POST['fnamee'];
$fphone = $_POST['fphone'];
$femail = $_POST['femail'];
$fpwd = $_POST['fpwd'];
$userType = $_POST['userType'];



//CRUD:UPDATE current item in inventory
$sql = "UPDATE tb_user
 SET u_name='$fnamee',u_phone='$fphone', u_email='$femail', u_pwd='$fpwd',u_type='$userType'
 WHERE u_id='$fID'";

mysqli_query($con, $sql);
mysqli_close($con);


//Display result
header('Location:managestaff.php');
?>
<!-- <div class="container">
    <h5>Here is Your NEW Item Details.</h5><br>
    <h5>Item ID:<?php echo $fID; ?></h5>
    <h5>Item Name:<?php echo $fnamee; ?></h5>
    <h5>Description: <?php echo $fphone; ?></h5>
    <h5>Unit Price:<?php echo $femail; ?></h5>
    <h5>Quantity:<?php echo $fpwd; ?></h5>
	<h5>Quantity:<?php echo $userType; ?></h5>

</div> -->