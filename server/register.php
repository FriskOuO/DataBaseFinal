<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "./DB.php";

    $member_account = $_POST['member_account'];
    $member_password = $_POST['member_password'];
    $member_name = $_POST['member_name'];
    $member_email = $_POST['member_email'];
    $member_celephone = $_POST['member_celephone'];
    $member_role = $_POST['role'];

    // 檢查帳號和密碼是否相同
    if ($member_account === $member_password) {
        header("Location: ../front/error.html?error=" . urlencode("帳號與密碼不可相同"));
        exit();
    }

    $response = DB();

    if ($response['status'] == 200) {
        $conn = $response['result'];

        // 檢查是否有重複的帳號或密碼
        $check_sql = "SELECT COUNT(*) FROM `member` WHERE `member_account` = ? OR `member_password` = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->execute([$member_account, $member_password]);
        $count = $check_stmt->fetchColumn();

        if ($count > 0) {
            $response['status'] = 409;
            $response['message'] = "帳號或密碼已存在";
            header("Location: ../front/duplicate.html?error=" . urlencode($response['message']));
            exit();
        } else {
            $sql = "INSERT INTO `member` (`member_account`, `member_password`, `member_name`, `member_email`, `member_celephone`, `member_role`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([$member_account, $member_password, $member_name, $member_email, $member_celephone, $member_role]);

            if ($result) {
                $count = $stmt->rowCount();

                if ($count < 1) {
                    $response['status'] = 204;
                    $response['message'] = "註冊失敗";
                    header("Location: ../front/register.html?error=" . urlencode($response['message']));
                    exit();
                } else {
                    $response['status'] = 200;
                    $response['message'] = "註冊成功";
                    header("Location: ../front/success.html");
                    exit();
                }
            } else {
                $response['status'] = 400;
                $response['message'] = "SQL錯誤";
                header("Location: ../front/register.html?error=" . urlencode($response['message']));
                exit();
            }
        }
    } else {
        header("Location: ../front/register.html?error=" . urlencode("資料庫連線失敗"));
        exit();
    }
}
?>