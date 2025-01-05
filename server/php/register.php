<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../DB.php"; // 確保這個路徑正確

    $member_account = $_POST['member_account'];
    $member_password = $_POST['member_password'];
    $member_name = $_POST['member_name'];
    $member_email = $_POST['member_email'];
    $member_celephone = $_POST['member_celephone'];
    $member_role = $_POST['role'];

    // 檢查帳號和密碼是否相同
    if ($member_account === $member_password) {
        header("Location: ../../front/html/error.html?error=" . urlencode("帳號與密碼不可相同"));
        exit();
    }

    $response = DB();

    if ($response['status'] == 200) {
        $conn = $response['result'];

        // 檢查是否有重複的帳號或密碼
        $check_sql = "SELECT COUNT(*) FROM `member` WHERE `member_account` = ? OR `member_password` = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->execute([$member_account, $member_password]);

        // 如果沒有重複的帳號或密碼，插入新會員資料
        if ($check_stmt->fetchColumn() == 0) {
            $insert_sql = "INSERT INTO `member` (`member_account`, `member_password`, `member_name`, `member_email`, `member_celephone`, `member_role`) VALUES (?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->execute([$member_account, $member_password, $member_name, $member_email, $member_celephone, $member_role]);

            header("Location: ../../front/html/success.html");
        } else {
            header("Location: ../../front/html/error.html?error=" . urlencode("帳號或密碼已存在"));
        }
    } else {
        header("Location: ../../front/html/error.html?error=" . urlencode("資料庫連接失敗"));
    }
    exit();
}
?>