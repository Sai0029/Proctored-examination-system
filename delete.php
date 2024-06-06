<?php
// delete.php

require_once 'config/db.php'; // Adjust the path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exam_id'])) {
    $examId = $_POST['exam_id'];

    $conn = mysqli_connect("localhost","id22126747_nsai0029","1466420@Sai","id22126747_myproject");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM exams WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $examId);
    mysqli_stmt_execute($stmt);

    // Close connections
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
