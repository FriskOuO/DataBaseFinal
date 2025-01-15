<?php
require_once '../DB.php';

function getAllMovies() {
    $response = [
        'status' => 200,
        'message' => '',
        'result' => null
    ];

    // 獲取資料庫連接
    $pdo = Database::getInstance()->getConnection();

    // 獲取影片列表
    try {
        $stmt = $pdo->query("SELECT movie_id, movie_type, movie_name, movie_lv FROM movie"); // 使用正確的表名
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['status'] = 200; // OK
        $response['message'] = '查詢成功';
        $response['result'] = $movies;
    } catch (PDOException $e) {
        $response['status'] = 400; // Bad Request
        $response['message'] = '資料庫錯誤: ' . $e->getMessage();
    }

    return $response;
}

$response = getAllMovies();
header('Content-Type: application/json');
echo json_encode($response);