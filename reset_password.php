<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
include("php/config.php");

if (!isset($_SESSION['reset_email'])) {
    header("Location: index.html");
    exit();
}

if (isset($_POST['submit'])) {
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $email = $_SESSION['reset_email'];

        $update_query = "UPDATE student_users SET password='$hashed_password' WHERE mail='$email'";
        if (mysqli_query($con, $update_query)) {
            echo "<script>alert('Password reset successfully!'); window.location.href = 'index.html';</script>";
        } else {
            echo "Error resetting password: " . mysqli_error($con);
        }

        unset($_SESSION['reset_email']);
    } else {
        echo "<div class='message'><p>Passwords do not match</p></div> <br>";
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
    <title>Reset Password</title>
</head>
<body>
<div class="container">
    <div class="box form-box">
        <header>Reset Password</header>
        <form action="" method="post">
            <div class="field input">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" autocomplete="off" required>
            </div>
            <div class="field input">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" autocomplete="off" required>
            </div>
            <div class="field">
                <input type="submit" class="btn" name="submit" value="Reset Password" required>
            </div>
        </form>
    </div>
</div>
</body>
</html>
