<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic = $_POST['topic'];
    $difficulty = strtolower($_POST['difficulty']);

    // Validate input
    if (empty($topic) || !in_array($difficulty, ['easy', 'medium', 'hard'])) {
        echo 'error: Invalid topic or difficulty';
        exit;
    }

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete options associated with questions to be deleted
        $stmt = $conn->prepare("DELETE options FROM options JOIN questions ON options.question_id = questions.id WHERE questions.topic = ? AND questions.difficulty = ?");
        $stmt->bind_param("ss", $topic, $difficulty);
        $stmt->execute();

        // Delete questions
        $stmt = $conn->prepare("DELETE FROM questions WHERE topic = ? AND difficulty = ?");
        $stmt->bind_param("ss", $topic, $difficulty);
        $stmt->execute();

        // Commit transaction
        $conn->commit();
        echo 'success';
    } catch (Exception $e) {
        // Rollback transaction
        $conn->rollback();
        echo 'error: ' . $e->getMessage();
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error: Invalid request method';
}
