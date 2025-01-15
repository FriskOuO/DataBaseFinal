<?php
session_start();
require_once '../DB.php';

function deleteMovie() {
    $response = [
        'status' => 200,
        'message' => '',
        'result' => null
    ];

    // 獲取資料庫連接
    $pdo = Database::getInstance()->getConnection();

    // 獲取表單提交的數據
    $movie_id = $_POST['movie_id'];

    // 錯誤檢查
    if (empty($movie_id)) {
        $response['status'] = 400;
        $response['message'] = '請選擇要刪除的影片';
        echo json_encode($response);
        return;
    }

    // 刪除影片
    $sql = "DELETE FROM movie WHERE movie_id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$movie_id]);

    if ($result) {
        $count = $stmt->rowCount();
        if ($count < 1) {
            $response['status'] = 204;
            $response['message'] = '刪除失敗';
        } else {
            $response['status'] = 200;
            $response['message'] = '刪除成功';
        }
    } else {
        $response['status'] = 400;
        $response['message'] = 'SQL錯誤';
    }

    echo json_encode($response);
}

deleteMovie();
?>