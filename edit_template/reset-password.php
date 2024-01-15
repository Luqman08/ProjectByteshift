<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require 'connection.php'; // Include your database connection script

$sql = "SELECT * FROM tb_user
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("Token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired");
}

?>

<?php
include("headermain.php");
include("loginprocess.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password</title>
    <!-- Add your stylesheet and other head elements here -->
</head>

<body>

    <h1>Reset Password</h1>

    <form method="post" action="process-reset-password.php">

        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <label for="password">New password</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirmation">Repeat password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <button>Reset Password</button>
    </form>

</body>

</html>