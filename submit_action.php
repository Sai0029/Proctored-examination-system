<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "id22126747_myproject";
date_default_timezone_set('Asia/Kolkata');
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize score and other variables
$score = 0;
$examTitle = $_POST['exam_title'] ?? '';
$username = $_POST['username'] ?? '';
$datetime = date('Y-m-d H:i:s'); // Current datetime

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through submitted answers
    foreach ($_POST as $key => $value) {
        // Check if answer is submitted for a question
        if (strpos($key, 'answer_') !== false) {
            // Extract question ID and submitted option ID
            $question_id = str_replace('answer_', '', $key);
            $submitted_option_id = $value;

            // Fetch correct option ID from database
            $fetch_correct_option_sql = "SELECT id FROM options WHERE question_id='$question_id' AND is_correct=1";
            $result = $conn->query($fetch_correct_option_sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $correct_option_id = $row['id'];

                // Check if submitted option is correct
                if ($submitted_option_id == $correct_option_id) {
                    $score++; // Increment score for correct answer
                }
            }
        }
    }

    // Insert exam results into database
    $insert_results_sql = "INSERT INTO exam_results (exam_title, username, score, exam_datetime) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_results_sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("ssis", $examTitle, $username, $score, $datetime);
        $stmt->execute();

        // Close statement
        $stmt->close();

        // Update student_id in exam_results based on username
        $update_student_id_sql = "UPDATE exam_results er
                                JOIN student_users su ON er.username = su.username
                                SET er.student_id = su.student_id
                                WHERE er.username = ?";
        $stmt_update = $conn->prepare($update_student_id_sql);
        
        if ($stmt_update) {
            $stmt_update->bind_param("s", $username);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
            echo "Error preparing SQL statement for updating student_id: " . $conn->error;
        }
    } else {
        echo "Error preparing SQL statement for inserting exam results: " . $conn->error;
    }

    // Display exam result using SweetAlert
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo 'Swal.fire({';
    echo 'title: "Exam Result",';
    echo 'text: "Your Score: ' . $score . '",';
    echo 'icon: "success",';
    echo '});';
    echo 'setTimeout(function() {';
    echo 'window.location.href = "student_dashboard.php";'; // Redirect to student_dashboard.php
    echo '}, 4000);'; // 5000 milliseconds = 5 seconds
    echo '});';
    echo '</script>';
} else {
    // If no form data is submitted
    echo "No data submitted.";
}

// Close connection
$conn->close();
?>
