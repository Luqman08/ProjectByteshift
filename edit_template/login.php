<?php
include("headermain.php");
include("loginprocess.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>

<body>
<form method="post" action="loginprocess.php" onsubmit="return validateForm()">
        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <img src="img/Removal-612.png" alt="" style="width: 100px; height: 100px;">
                            </a>
                            <h3>Sign In</h3>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="u_id" placeholder="name@example.com">
                            <label for="floatingInput">Username</label>

                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" name="fpwd" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <!-- User Type Dropdown -->
                        <div class="form-group mb-4">
                            <label for="userType">Select User Type:</label>
                            <select class="form-control" id="userType" name="userType">
                                <option value="1">Staff</option>
                                <option value="2"> Admin</option>
                            </select>
                        </div>
                        <!-- End User Type Dropdown -->
                        <!-- <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div>
                            <a href="">Forgot Password</a>
                        </div> -->
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                        <p class="text-center mb-0">Don't have an Account? <a href="register.php">Register</a></p>
                        <!-- Corrected Forgot Password link -->
                        <p class="text-center mb-0">Forgot Password? <a href="forgot-password.php">Reset Password</a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </form>
</body>
<script>
    function validateForm() {
        // You can add more validation logic here if needed

        // Return true to submit the form, or false to prevent submission
        return true;
    }
</script>