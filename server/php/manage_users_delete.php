<?php
session_start();
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
    $member_account = $_POST['member_account']; // 使用正確的欄位名稱

    // 錯誤檢查
    if (empty($member_account)) {
        $response['status'] = 400;
        $response['message'] = '請選擇要刪除的使用者';
        echo json_encode($response);
        return;
    }

    // 刪除使用者
    $sql = "DELETE FROM member WHERE member_account = ?"; // 使用正確的欄位名稱
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$member_account]);

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

deleteUser();