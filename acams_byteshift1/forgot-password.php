<?php
include("headermain.php");
include("loginprocess.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Password Reset</title>
</head>

<body>
    <form method="post" action="send-password-reset.php">
        <!-- Password Reset Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <img src="img/Removal-612.png" alt="" style="width: 100px; height: 100px;">
                            </a>
                            <h3>Password Reset</h3>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="email" class="form-control" id="floatingInput" name="email"
                                placeholder="name@example.com">
                            <label for="floatingInput">Email</label>
                        </div>
                        <!-- Removed Password Fields -->
                        <button type="submit" name="reset" class="btn btn-primary py-3 w-100 mb-4">Reset
                            Password</button>
                        <p class="text-center mb-0"><a href="login.php">Back to Login</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Password Reset End -->
    </form>
</body>

</html>