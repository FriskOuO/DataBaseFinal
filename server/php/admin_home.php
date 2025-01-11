<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final works";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$movie_id = $_POST['movie_id'];
$movie_name = $_POST['movie_name'];
$movie_type = $_POST['movie_type'];
$movie_lv = $_POST['movie_lv'];

// 調試信息
error_log("Received data: movie_id=$movie_id, movie_name=$movie_name, movie_type=$movie_type, movie_lv=$movie_lv");

$sql = "INSERT INTO movie (movie_id, movie_name, movie_type, movie_lv) VALUES ('$movie_id', '$movie_name', '$movie_type', '$movie_lv')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    // 調試信息
    error_log("SQL error: " . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}

$conn->close();
?>