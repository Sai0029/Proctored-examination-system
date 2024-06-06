<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
include("php/config.php");

// Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\public_html\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\public_html\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\public_html\phpmailer\src\SMTP.php';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);

    $result = mysqli_query($con, "SELECT * FROM student_users WHERE mail='$email'") or die("Select Error");
    $row = mysqli_fetch_assoc($result);

    if (is_array($row) && !empty($row)) {
        // Generate OTP
        $otp = rand(100000, 999999);
        $otp_expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Store OTP and expiry time in the database
        $update_query = "UPDATE student_users SET otp='$otp', otp_expiry='$otp_expiry' WHERE mail='$email'";
        if (mysqli_query($con, $update_query)) {
            // Send OTP to user's email
            $_SESSION['temp_email'] = $email;

            // Create an instance of PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'sainagineni2002@gmail.com';
                $mail->Password = 'uheksmkpmpgrdccz';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                // Recipients
                $mail->setFrom('sainagineni2002@gmail.com', 'SAIKRISHNA');
                $mail->addAddress($email);
                $mail->addReplyTo('sainagineni2002@gmail.com', 'SAIKRISHNA');

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your Password Reset OTP';
                $mail->Body = 'Your OTP for password reset is ' . $otp;

                // Send the email
                $mail->send();
                echo "<script>alert('OTP Sent Successfully!'); window.location.href = 'verify_reset_otp.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Failed to send OTP. Mailer Error: {$mail->ErrorInfo}');</script>";
            }
        } else {
            echo "Error storing OTP: " . mysqli_error($con);
        }
    } else {
        echo "<div class='message'><p>Email not found</p></div> <br>";
        echo "<a href='forgot_password.php'><button class='btn'>Try Again</button></a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Forgot Password</title>
</head>
<body>
<div class="container">
    <div class="box form-box">
        <header>Forgot Password</header>
        <form action="" method="post">
            <div class="field input">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" autocomplete="off" required>
            </div>

            <div class="field">
                <input type="submit" class="btn" name="submit" value="Send OTP" required>
            </div>
        </form>
    </div>
</div>
</body>
</html>
