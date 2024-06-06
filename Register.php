<?php 
include("php/config.php");

if (isset($_POST['submit'])) {
    // Retrieve form data
    $student_id = $_POST['student_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $password = $_POST['password'];

    // Perform validations
    $errors = array();

    // Validate username
    if (empty($username) || strlen($username) < 8 || !preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        $errors[] = "Invalid Username. Username must be at least 8 characters long and contain only alphanumeric characters.";
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email Format. Please enter a valid email address.";
    }

    // Validate password strength
    if (strlen($password) < 8 || !preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $password)) {
        $errors[] = "Invalid Password. Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, and one number.";
    }

    // Validate age
    if (!is_numeric($age) || $age <= 0 || $age >= 80) {
        $errors[] = "Invalid Age. Please enter a valid age between 1 and 79.";
    }

    // Check for duplicate entries
    $check_username_query = mysqli_query($con, "SELECT * FROM student_users WHERE username='$username'");
    if (mysqli_num_rows($check_username_query) > 0) {
        $errors[] = "Username already exists. Please choose a different one.";
    }

    $check_email_query = mysqli_query($con, "SELECT * FROM student_users WHERE mail='$email'");
    if (mysqli_num_rows($check_email_query) > 0) {
        $errors[] = "Email already exists. Please use a different one.";
    }

    $check_student_id_query = mysqli_query($con, "SELECT * FROM student_users WHERE student_id='$student_id'");
    if (mysqli_num_rows($check_student_id_query) > 0) {
        $errors[] = "Student ID already exists. Please use a different one.";
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $insert_query = "INSERT INTO student_users (student_id, username, mail, age, password) 
                         VALUES ('$student_id', '$username', '$email', '$age', '$hashed_password')";
        if (mysqli_query($con, $insert_query)) {
            echo "<script>
                    alert('Registration successful. You can now login.');
                    window.location.href = 'stu_login.php';
                  </script>";
            exit;
        } else {
            $errors[] = "Registration failed. Please try again later.";
        }
    }

    // Display errors
    foreach ($errors as $error) {
        echo "<script>alert('$error');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="style/style.css">
    <script>
        function showError(element, message) {
            const errorElement = element.nextElementSibling;
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        function hideError(element) {
            const errorElement = element.nextElementSibling;
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }

        function validateUsername(username) {
            if (username.length < 8 || !/^[a-zA-Z0-9]+$/.test(username)) {
                return "Username must be at least 8 characters long and contain only alphanumeric characters.";
            }
            return '';
        }

        function validateEmail(email) {
            if (!/\S+@\S+\.\S+/.test(email)) {
                return "Please enter a valid email address.";
            }
            return '';
        }

        function validatePassword(password) {
            if (password.length < 8 || !/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(password)) {
                return "Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, and one number.";
            }
            return '';
        }

        function validateConfirmPassword(password, confirmPassword) {
            if (password !== confirmPassword) {
                return "Passwords do not match.";
            }
            return '';
        }

        function validateAge(age) {
            if (!/^\d+$/.test(age) || age <= 0 || age >= 80) {
                return "Please enter a valid age between 1 and 79.";
            }
            return '';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.forms['registerForm'];

            form['username'].addEventListener('input', function () {
                const error = validateUsername(this.value);
                if (error) {
                    showError(this, error);
                } else {
                    hideError(this);
                }
            });

            form['email'].addEventListener('input', function () {
                const error = validateEmail(this.value);
                if (error) {
                    showError(this, error);
                } else {
                    hideError(this);
                }
            });

            form['password'].addEventListener('input', function () {
                const error = validatePassword(this.value);
                if (error) {
                    showError(this, error);
                } else {
                    hideError(this);
                }
            });

            form['confirm_password'].addEventListener('input', function () {
                const error = validateConfirmPassword(form['password'].value, this.value);
                if (error) {
                    showError(this, error);
                } else {
                    hideError(this);
                }
            });

            form['age'].addEventListener('input', function () {
                const error = validateAge(this.value);
                if (error) {
                    showError(this, error);
                } else {
                    hideError(this);
                }
            });

            form.addEventListener('submit', function (event) {
                let errors = [];

                const usernameError = validateUsername(form['username'].value);
                if (usernameError) errors.push(usernameError);

                const emailError = validateEmail(form['email'].value);
                if (emailError) errors.push(emailError);

                const passwordError = validatePassword(form['password'].value);
                if (passwordError) errors.push(passwordError);

                const confirmPasswordError = validateConfirmPassword(form['password'].value, form['confirm_password'].value);
                if (confirmPasswordError) errors.push(confirmPasswordError);

                const ageError = validateAge(form['age'].value);
                if (ageError) errors.push(ageError);

                if (errors.length > 0) {
                    alert(errors.join("\n"));
                    event.preventDefault();
                }
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="box form-box">
        <header>Student Registration</header>
        <form name="registerForm" action="" method="post">
            <div class="field input">
                <label for="student_id">Student ID</label>
                <input type="text" name="student_id" id="student_id" autocomplete="off" required>
                <span class="error-message"></span>
            </div>

            <div class="field input">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" autocomplete="off" required>
                <span class="error-message"></span>
            </div>

            <div class="field input">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" autocomplete="off" required>
                <span class="error-message"></span>
            </div>

            <div class="field input">
                <label for="age">Age</label>
                <input type="text" name="age" id="age" autocomplete="off" required>
                <span class="error-message"></span>
            </div>

            <div class="field input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" autocomplete="off" required>
                <span class="error-message"></span>
            </div>

            <div class="field input">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" autocomplete="off" required>
                <span class="error-message"></span>
            </div>

            <div class="field">
                <input type="submit" class="btn" name="submit" value="Register">
            </div>
        </form>
    </div>
</div>
</body>
</html>
