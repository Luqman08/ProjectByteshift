<?php
// Ensure that PHP error reporting is enabled for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the header file
include("headermain.php");
?>

<body>

    <!-- Preloader start
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
     Preloader end -->

    <form method="POST" action="resetpasswordprocess.php">
        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                            <img src="img/Removal-612.png" alt="" style="width: 100px; height: 100px;">
                            </a>
                            <h3>Reset Password</h3>
                        </div>
                        <?php
                        // Check if 'code' parameter is set in the URL
                        if (isset($_GET['code'])) {
                            $code = $_GET['code'];
                        } else {
                            die("Error: Code is not set. Make sure you have the correct reset link.");
                        }
                        ?>
                        <div class="form-group mb-3">
                            <input type="hidden" id="hiddenField" name="code" value="<?php echo $code; ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">New Password</label>
                            <input type="password" name="fpwd" class="form-control" id="password" placeholder="Password" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="RepeatPassword">Repeat New Password</label>
                            <input type="password" name="frpwd" class="form-control" id="RepeatPassword" placeholder="Repeat Password" required>
                        </div>
                        <div id="passwordMismatchMessage" style="color: red;"></div>
                        <div id="passwordmatchMessage" style="color: green;"></div>
                        <button type="submit" id="confirm" name="change" class="btn btn-success w-100">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </form>

    <!-- Add your scripts or other content here -->

</body>

</html>