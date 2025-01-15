<!-- filepath: /d:/Xampp/htdocs/DataBaseFinal/server/php/delete_movie.php -->
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
        return $response;
    }

    // 刪除影片
    try {
        $stmt = $pdo->prepare("DELETE FROM movies WHERE movie_id = ?");
        $stmt->execute([$movie_id]);
        $count = $stmt->rowCount();

        if ($count < 1) {
            $response['status'] = 204;
            $response['message'] = '刪除失敗';
        } else {
            $response['status'] = 200;
            $response['message'] = '刪除成功';
        }
    } catch (PDOException $e) {
        $response['status'] = 400;
        $response['message'] = '資料庫錯誤: ' . $e->getMessage();
    }

    return $response;
}

$response = deleteMovie();
header('Content-Type: application/json');
echo json_encode($response);
?>