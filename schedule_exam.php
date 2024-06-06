<?php
// Handle form submission for scheduling exams

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    if (isset($_POST['exam_name']) && isset($_POST['exam_date']) && isset($_POST['exam_time']) && isset($_POST['duration']) && isset($_POST['student_id'])) {
        $examName = $_POST['exam_name'];
        $examDate = $_POST['exam_date'];
        $examTime = $_POST['exam_time'];
        $duration = $_POST['duration'];
        $studentId = $_POST['student_id'];
        
        // Insert exam details into database
        $servername = "localhost";
        $username = "root";
        $password = "1234";
        $dbname = "id22126747_myproject";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert exam details into database
        $sql = "INSERT INTO exams (exam_name, exam_date, exam_time, duration, student_id) VALUES ('$examName', '$examDate', '$examTime', '$duration', '$studentId')";
        if ($conn->query($sql) === TRUE) {
            echo "Exam scheduled successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Missing required parameters.";
    }
}
?>
