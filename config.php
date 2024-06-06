<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "id22126747_myproject";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
