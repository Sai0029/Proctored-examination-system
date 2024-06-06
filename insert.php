<?php
require 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$question = $_POST['question'];
$topic = $_POST['topic'];
$difficulty = $_POST['difficulty'];
$options = $_POST['options'];
$correct_option = $_POST['correct_option'];

// Validate form data
if (empty($question) || empty($topic) || empty($difficulty) || empty($options) || empty($correct_option)) {
    echo 'error';
    $conn->close();
    exit;
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO questions (question_text, topic, difficulty) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $question, $topic, $difficulty);

if ($stmt->execute()) {
    $question_id = $stmt->insert_id;
    
    $stmt->close();

    // Insert options into options table
    foreach ($options as $option_text) {
        $option_text = $conn->real_escape_string($option_text); // Escape special characters to prevent SQL injection
        $is_correct = ($option_text === $correct_option) ? 1 : 0;

        $stmt = $conn->prepare("INSERT INTO options (question_id, option_text, is_correct) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $question_id, $option_text, $is_correct);

        if (!$stmt->execute()) {
            echo 'error: ' . $stmt->error;
            $stmt->close();
            $conn->close();
            exit;
        }
    }

    $stmt->close();
    echo "success";
} else {
    echo 'error: ' . $stmt->error;
    $stmt->close();
}

$conn->close();
?>
