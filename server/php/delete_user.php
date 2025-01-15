<?php
require_once '../DB.php';

function deleteUser() {
    $response = [
        'status' => 200,
        'message' => '',
        'result' => null
    ];

    // 獲取資料庫連接
    $pdo = Database::getInstance()->getConnection();

    // 獲取表單提交的數據
    $user_id = $_POST['user_id'];

    // 錯誤檢查
    if (empty($user_id)) {
        $response['status'] = 400;
        $response['message'] = '請選擇要刪除的使用者';
        return $response;
    }

    // 刪除使用者
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
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

$response = deleteUser();
header('Content-Type: application/json');
echo json_encode($response);
?>