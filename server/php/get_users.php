htdocs/DataBaseFinal/server/php/get_users.php
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

    // 查詢使用者清單，添加條件 member_role = 'user'
    $sql = "SELECT * FROM member WHERE member_role = 'user'";
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

getUsers();
?>