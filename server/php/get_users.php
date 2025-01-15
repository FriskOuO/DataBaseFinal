<?php
require_once '../DB.php';

function getUsers() {
    $response = [
        'status' => 200,
        'message' => '',
        'result' => null
    ];

    // 獲取資料庫連接
    $pdo = Database::getInstance()->getConnection();

    // 獲取使用者列表
    try {
        $stmt = $pdo->query("SELECT account, name FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['status'] = 200; // OK
        $response['message'] = '查詢成功';
        $response['result'] = $users;
    } catch (PDOException $e) {
        $response['status'] = 400; // Bad Request
        $response['message'] = '資料庫錯誤: ' . $e->getMessage();
    }

    return $response;
}

$response = getUsers();
header('Content-Type: application/json');
echo json_encode($response);
?>