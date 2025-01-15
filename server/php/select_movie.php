<?php
require_once '../DB.php';

function selectMovie() {
    $response = [
        'status' => 200,
        'message' => '',
        'result' => null
    ];

    // 獲取資料庫連接
    $pdo = Database::getInstance()->getConnection();

    // 查詢影片清單
    $sql = "SELECT * FROM movie";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute();

    if ($result) {
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response['status'] = 200; // OK
        $response['message'] = "查詢成功";
        $response['result'] = $rows;
    } else {
        $response['status'] = 400; // Bad Request
        $response['message'] = "SQL錯誤";
    }

    echo json_encode($response);
}

selectMovie();
?>