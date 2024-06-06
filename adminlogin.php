<?php
ob_start(); // Start output buffering
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Admin Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php
            include("php/config.php");

            if(isset($_POST['submit'])){
                $email = mysqli_real_escape_string($con,$_POST['email']);
                $password = mysqli_real_escape_string($con,$_POST['password']);

                // Client-side validation for email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<div class='message'>
                        <p>Invalid email format</p>
                    </div> <br>";
                    echo "<a href='index.html'><button class='btn'>Go Back</button>";
                    ob_end_flush(); // Flush the buffered output
                    exit(); // Stop further execution
                }

                // Query the database to check if provided credentials match any admin user
                $query = "SELECT * FROM admin_users WHERE mail='$email' AND password='$password'";
                $result = mysqli_query($con, $query);

                if(mysqli_num_rows($result) == 1) {
                    // If a matching admin user is found, set the session and redirect to admin dashboard
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['valid'] = $row['mail'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    // If no matching admin user found, display error message
                    echo "<div class='message'>
                        <p>Wrong Username or Password</p>
                    </div> <br>";
                    echo "<a href='index.html'><button class='btn'>Go Back</button>";
                    ob_end_flush(); // Flush the buffered output
                }
            }
            ?>

            <header>Admin Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
