<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fianl_works";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $movie_id = $data['movie_id'];
        $movie_type = $data['movie_type'];
        $movie_name = $data['movie_name'];
        $movie_lv = $data['movie_lv'];
        $sql = "INSERT INTO movies (movie_id, movie_type, movie_name, movie_lv) VALUES ('$movie_id', '$movie_type', '$movie_name', '$movie_lv')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Movie added successfully"]);
        } else {
            echo json_encode(["error" => "Error adding movie: " . $conn->error]);
        }
        break;
    case 'DELETE':
        $movie_id = basename($_SERVER['REQUEST_URI']);
        $sql = "DELETE FROM movies WHERE movie_id = $movie_id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Movie deleted successfully"]);
        } else {
            echo json_encode(["error" => "Error deleting movie: " . $conn->error]);
        }
        break;
    case 'GET':
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $sql = "SELECT * FROM movies WHERE movie_name LIKE '%$search%'";
        } else {
            $sql = "SELECT * FROM movies";
        }
        $result = $conn->query($sql);
        $movies = [];
        while ($row = $result->fetch_assoc()) {
            $movies[] = $row;
        }
        echo json_encode($movies);
        break;
    default:
        echo json_encode(["error" => "Invalid request method"]);
        break;
}

$conn->close();
?>