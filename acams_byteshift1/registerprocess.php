<?php
//connect db
include("dbcon.php");
//retrieve data from registration form
$fname = $_POST['fname'];
$fpwd = $_POST['fpwd'];
$femail = $_POST['femail'];
$userType = $_POST['userType'];
$Uname = $_POST['Uname'];
$Uphone = $_POST['Uphone'];
//CRUD Operations
//CREATE-SQL Insert statement
$sql = "INSERT INTO tb_user(u_id,u_email,u_pwd,u_type,u_name,u_phone)
        VALUES('$fname','$femail','$fpwd','$userType','$Uname','$Uphone')";

//Execute SQL
mysqli_query($con, $sql);
//close DB connection
mysqli_close($con);

header('Location:login.php');