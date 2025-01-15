<?php
require_once '../DB.php';

function verifyUser() {
    $response = [
        'status' => 200,
        'message' => '',
        'result' => null
    ];

    $pdo = Database::getInstance()->getConnection();

    $member_account = $_POST['member_account'];
    $member_password = $_POST['member_password'];

    try {
        $stmt = $pdo->prepare("SELECT member_account, member_name, member_celephone, member_email FROM member WHERE member_account = ? AND member_password = ?");
        $stmt->execute([$member_account, $member_password]);
        $member = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($member) {
            $response['result'] = $member;
        } else {
            $response['status'] = 401;
            $response['message'] = '帳號或密碼錯誤';
        }
    } catch (PDOException $e) {
        $response['status'] = 500;
        $response['message'] = '資料庫錯誤: ' . $e->getMessage();
    }

    return $response;
}

$response = verifyUser();
header('Content-Type: application/json');
echo json_encode($response);