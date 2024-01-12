<?php include 'headermain.php'; ?>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><img src="img/Removal-612.png" alt="" style="width: 60px; height: 60px;"></i>AK MAJU</h3>
                            </a>
                            <h3>Sign Up</h3>
                        </div>
                        <form method="POST" action="registerprocess.php" onsubmit="return validateForm()">
                            <div class="form-floating mb-3">
                                <input type="text" name="fname" class="form-control" id="floatingText" placeholder="jhondoe" required>
                                <label for="floatingText">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="femail" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="Uname" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                <label for="floatingInput">name</label>
                            </div>
                            <div class="form-floating mb-3">
                            <input type="tel" name="Uphone" class="form-control" id="floatingInput" placeholder="0131234566" oninput="validatePhoneNumber(this)" required>
                            <label for="floatingInput">Number Phone</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="fpwd" class="form-control" id="floatingPassword" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>
                            <!-- Repeat Password Field -->
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingRepeatPassword" placeholder="Repeat Password" required>
                                <label for="floatingRepeatPassword">Repeat Password</label>
                            </div>
                            <!-- End Repeat Password Field -->

                            <!-- User Type Dropdown -->
                            <div class="form-group mb-4">
                                <label for="userType">Select User Type:</label>
                                <select class="form-control" id="userType" name="userType" required>
                                    <option value="2">Admin</option>
                                    <option value="1">Staff</option>
                                </select>
                            </div>
                            <!-- End User Type Dropdown -->
                            

                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                            <p class="text-center mb-0">Already have an Account? <a href="login.php">Sign In</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
    </div>

    <script>
        function validateForm() {
            var password = document.getElementById('floatingPassword').value;
            var repeatPassword = document.getElementById('floatingRepeatPassword').value;

            if (password !== repeatPassword) {
                alert('Passwords do not match');
                return false; // Prevent form submission
            }

            return true; // Allow form submission if passwords match
        }
        
    function validatePhoneNumber(input) {
        // Remove non-numeric characters
        input.value = input.value.replace(/\D/g, '');
    }

    </script>
</body>

<?php include 'footer.php'; ?>