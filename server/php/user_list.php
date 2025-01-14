<?php
require_once './DB.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $db = Database::getInstance(); // 使用 Database 類
    $conn = $db->getConnection(); // 獲取 PDO 連線

    $sql = "SELECT member_account, member_name, member_celephone, member_email, member_role FROM member";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($users);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>