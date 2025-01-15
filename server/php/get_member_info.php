<?php
require_once '../DB.php';

function getMemberInfo() {
    $response = [
        'status' => 200,
        'message' => '',
        'result' => null
    ];

    // 假設會員帳號是從 session 中獲取的
    session_start();
    $member_account = $_SESSION['member_account'];

    $pdo = Database::getInstance()->getConnection();

    try {
        $stmt = $pdo->prepare("SELECT member_account, member_name, member_celephone, member_email FROM member WHERE member_account = ?");
        $stmt->execute([$member_account]);
        $member = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($member) {
            $response['result'] = $member;
        } else {
            $response['status'] = 404;
            $response['message'] = '會員資料不存在';
        }
    } catch (PDOException $e) {
        $response['status'] = 500;
        $response['message'] = '資料庫錯誤: ' . $e->getMessage();
    }

    return $response;
}

$response = getMemberInfo();
header('Content-Type: application/json');
echo json_encode($response);