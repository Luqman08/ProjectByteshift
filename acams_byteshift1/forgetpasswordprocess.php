<?php
include("connection.php");
require 'path/to/PHPMailer/Exception.php';
require 'path/to/PHPMailer/PHPMailer.php';
require 'path/to/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $forgot_email = mysqli_real_escape_string($con, $_POST['forgot_email']);

    // Check if the email exists in your database
    $check_query = "SELECT * FROM tb_user WHERE u_email = '$forgot_email'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) == 1) {
        // Generate a unique token and store it in the database
        $reset_token = bin2hex(random_bytes(32));
        $update_query = "UPDATE tb_user SET reset_token = '$reset_token' WHERE u_email = '$forgot_email'";
        mysqli_query($con, $update_query);

        // Send a password reset link to the user's email
        $reset_link = "http://yourwebsite.com/resetpasswordpage.php?token=$reset_token";
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $reset_link";

        // Create a new PHPMailer instance
        $mail = new PHPMailer();

        // Configure PHPMailer settings (SMTP, sender, recipient, etc.)

        // Set up the email
        $mail->setFrom('your_email@example.com', 'Your Name');
        $mail->addAddress($forgot_email);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        if ($mail->send()) {
            echo 'Password reset instructions sent to your email.';
        } else {
            echo 'Error sending email: ' . $mail->ErrorInfo;
        }
    } else {
        echo "Email address not found.";
    }
}

mysqli_close($con);
?>
