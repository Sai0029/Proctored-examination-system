<?php
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt_question = $conn->prepare("INSERT INTO questions (question_text, topic, difficulty) VALUES (?, ?, ?)");
    $stmt_option = $conn->prepare("INSERT INTO options (question_id, option_text, is_correct) VALUES (?, ?, ?)");

    if ($stmt_question && $stmt_option) {
        foreach ($data as $index => $row) {
            $question = $row[0];
            $topic = $row[1];
            $difficulty = strtolower($row[2]);
            $correct_option = $row[3];
            $options = array_slice($row, 4);

            // Validate and convert difficulty
            if (!in_array($difficulty, ['easy', 'medium', 'hard'])) {
                echo "error: Invalid difficulty value at row " . ($index + 1);
                $stmt_question->close();
                $stmt_option->close();
                $conn->close();
                exit;
            }

            $stmt_question->bind_param("sss", $question, $topic, $difficulty);
            if ($stmt_question->execute()) {
                $question_id = $stmt_question->insert_id;

                foreach ($options as $option) {
                    $is_correct = ($option === $correct_option) ? 1 : 0;
                    $stmt_option->bind_param("isi", $question_id, $option, $is_correct);
                    if (!$stmt_option->execute()) {
                        echo 'error: ' . $stmt_option->error;
                        $stmt_question->close();
                        $stmt_option->close();
                        $conn->close();
                        exit;
                    }
                }
            } else {
                echo 'error: ' . $stmt_question->error;
                $stmt_question->close();
                $stmt_option->close();
                $conn->close();
                exit;
            }
        }

        $stmt_question->close();
        $stmt_option->close();
        echo 'success';
    } else {
        echo 'error: Failed to prepare statements';
    }

    $conn->close();
} else {
    echo 'error: Invalid data format';
}
?>
