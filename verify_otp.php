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

if (!isset($_SESSION['temp_email'])) {
    header("Location: index.html");
    exit();
}

if (isset($_POST['verify'])) {
    $otp = mysqli_real_escape_string($con, $_POST['otp']);
    $email = $_SESSION['temp_email'];

    $result = mysqli_query($con, "SELECT * FROM student_users WHERE mail='$email' AND otp='$otp' AND otp_expiry >= NOW()") or die("Select Error");
    $row = mysqli_fetch_assoc($result);

    if (is_array($row) && !empty($row)) {
        // OTP is correct
        $_SESSION['valid'] = $row['mail'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['age'] = $row['age'];
        $_SESSION['id'] = $row['id'];

        // Clear OTP
        mysqli_query($con, "UPDATE student_users SET otp=NULL, otp_expiry=NULL WHERE mail='$email'");

        // Redirect to dashboard
        unset($_SESSION['temp_email']);
        header("Location: student_dashboard.php");
        exit();
    } else {
        echo "<div class='message'><p>Invalid OTP or OTP expired</p></div> <br>";
        echo "<a href='verify_otp.php'><button class='btn'>Try Again</button></a>";
    }
}

if (isset($_POST['resend_otp'])) {
    $email = $_SESSION['temp_email'];

    // Generate OTP
    $otp = rand(100000, 999999);
    $otp_expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    // Store OTP and expiry time in the database
    $update_query = "UPDATE student_users SET otp='$otp', otp_expiry='$otp_expiry' WHERE mail='$email'";
    if (mysqli_query($con, $update_query)) {
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
            $mail->Subject = 'Your OTP Code';
            $mail->Body = 'Your OTP code is ' . $otp;

            // Send the email
            $mail->send();
            echo "<script>alert('OTP Sent Successfully!');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Failed to send OTP. Mailer Error: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "Error storing OTP: " . mysqli_error($con);
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
    <title>OTP Verification</title>
    <script>
        let countdown;
        function startCountdown() {
            let timer = 60;
            countdown = setInterval(() => {
                if (timer > 0) {
                    timer--;
                    document.getElementById('countdown').innerText = `Resend OTP in ${timer} seconds`;
                } else {
                    clearInterval(countdown);
                    document.getElementById('resend-btn').disabled = false;
                    document.getElementById('countdown').innerText = '';
                }
            }, 1000);
        }
        window.onload = function() {
            startCountdown();
        }
    </script>
</head>
<body>
<div class="container">
    <div class="box form-box">
        <header>Enter OTP</header>
        <form action="" method="post">
            <div class="field input">
                <label for="otp">OTP</label>
                <input type="text" name="otp" id="otp" autocomplete="off" required>
            </div>

            <div class="field">
                <input type="submit" class="btn" name="verify" value="Verify OTP" required>
            </div>
        </form>
        <form action="" method="post">
            <div class="field">
                <input type="submit" class="btn" name="resend_otp" value="Resend OTP" id="resend-btn" disabled>
            </div>
            <div id="countdown"></div>
        </form>
    </div>
</div>
</body>
</html>
