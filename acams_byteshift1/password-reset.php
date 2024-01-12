<?php
session_start();

include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token']) && isset($_GET['email'])) {
    $token = $_GET['token'];
    $email = $_GET['email'];

    // Check if the token is valid
    $check_token = "SELECT reset_token FROM tb_user WHERE u_email = ?";
    $check_token_stmt = mysqli_prepare($con, $check_token);

    if ($check_token_stmt) {
        mysqli_stmt_bind_param($check_token_stmt, "s", $email);
        mysqli_stmt_execute($check_token_stmt);
        mysqli_stmt_store_result($check_token_stmt);

        if (mysqli_stmt_num_rows($check_token_stmt) > 0) {
            mysqli_stmt_bind_result($check_token_stmt, $db_token);
            mysqli_stmt_fetch($check_token_stmt);

            if ($token === $db_token) {
                // Token is valid, allow password reset
                $_SESSION['reset_email'] = $email;
                $_SESSION['reset_token'] = $token;
            } else {
                echo "Invalid token";
            }
        } else {
            echo "Invalid email";
        }

        mysqli_stmt_close($check_token_stmt);
    } else {
        echo "Something went wrong";
    }
}

mysqli_close($con);
?>
<?php
include("headermain.php");
include("loginprocess.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <?php if (isset($_SESSION['reset_email']) && isset($_SESSION['reset_token'])): ?>
        <!-- Your HTML form for resetting password -->
        <form method="post" action="password-change.php">
            <input type="hidden" name="email" value="<?php echo $_SESSION['reset_email']; ?>">
            <input type="hidden" name="password_token" value="<?php echo $_SESSION['reset_token']; ?>">

            <label for="newpwd">New Password:</label>
            <input type="password" id="newpwd" name="newpwd" required>

            <label for="confirmpwd">Confirm Password:</label>
            <input type="password" id="confirmpwd" name="confirmpwd" required>

            <button type="submit" name="resetBtn">Reset Password</button>
        </form>
    <?php else: ?>
        <p>Invalid request</p>
    <?php endif; ?>
</body>

</html>