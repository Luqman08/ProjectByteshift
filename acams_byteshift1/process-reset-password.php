<?php

$token = $_POST["token"];

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

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE tb_user
        SET u_pwd = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE u_id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $password_hash, $user["u_id"]);

$stmt->execute();

echo "Password updated. You can now login.";

?>