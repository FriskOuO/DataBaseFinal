<?php
require_once '../DB.php';

function editProfile() {
    $response = [
        'status' => 200,
        'message' => ''
    ];

    $pdo = Database::getInstance()->getConnection();

    $member_account = $_POST['member_account'];
    $member_name = $_POST['member_name'];
    $member_celephone = $_POST['member_celephone'];
    $member_email = $_POST['member_email'];

    try {
        // 日誌輸出
        error_log("Updating member: account=$member_account, name=$member_name, celephone=$member_celephone, email=$member_email");

        // 檢查是否存在該會員帳號
        $stmt = $pdo->prepare("SELECT * FROM member WHERE member_account = ?");
        $stmt->execute([$member_account]);
        $existingMember = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingMember) {
            // 日誌輸出現有資料
            error_log("Existing member data: " . print_r($existingMember, true));

            $stmt = $pdo->prepare("UPDATE member SET member_name = ?, member_celephone = ?, member_email = ? WHERE member_account = ?");
            $stmt->execute([$member_name, $member_celephone, $member_email, $member_account]);

            if ($stmt->rowCount() > 0) {
                $response['message'] = '資料更新成功';
            } else {
                $response['message'] = '沒有資料被更新';
            }
        } else {
            $response['message'] = '會員帳號不存在';
        }
    } catch (PDOException $e) {
        $response['status'] = 400;
        $response['message'] = '資料庫錯誤: ' . $e->getMessage();
    }

    return $response;
}

$response = editProfile();
header('Content-Type: application/json');
echo json_encode($response);