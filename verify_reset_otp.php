<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
include("php/config.php");

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
        $_SESSION['reset_email'] = $email;

        // Clear OTP
        mysqli_query($con, "UPDATE student_users SET otp=NULL, otp_expiry=NULL WHERE mail='$email'");

        // Redirect to reset password form
        header("Location: reset_password.php");
        exit();
    } else {
        echo "<div class='message'><p>Invalid OTP or OTP expired</p></div> <br>";
        echo "<a href='verify_reset_otp.php'><button class='btn'>Try Again</button></a>";
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
    <title>Verify OTP</title>
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
    </div>
</div>
</body>
</html>
