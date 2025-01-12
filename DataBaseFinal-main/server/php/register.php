<?php
session_start();
include '../DB.php'; // 包含資料庫連接文件

// 獲取資料庫連接
$pdo = Database::getInstance()->getConnection();

// 假設這裡有一些驗證邏輯
$account = $_POST['member_account'];
$password = $_POST['member_password'];
$name = $_POST['member_name'];
$email = $_POST['member_email'];
$celephone = $_POST['member_celephone'];
$role = $_POST['role'];

// 假設這裡有一些錯誤檢查
$errors = [];

if (empty($account)) {
    $errors[] = '帳號不能為空';
}

if (empty($password)) {
    $errors[] = '密碼不能為空';
}

if (empty($name)) {
    $errors[] = '姓名不能為空';
}

if (empty($email)) {
    $errors[] = '電子信箱不能為空';
}

if (empty($celephone)) {
    $errors[] = '手機號碼不能為空';
}

if ($account === $password) {
    header("Location: ../../front/html/error_account_password.html");
    exit();
}

// 檢查資料庫中是否有相同的帳號
$query = $pdo->prepare("SELECT * FROM member WHERE member_account = ?");
$query->execute([$account]);
if ($query->rowCount() > 0) {
    header("Location: ../../front/html/error_account_exists.html");
    exit();
}

// 如果有其他錯誤，將錯誤訊息存入 session 並重定向到錯誤頁面
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: ../../front/html/error.html");
    exit();
}

// 假設這裡有一些註冊邏輯
$insertQuery = $pdo->prepare("INSERT INTO member (member_account, member_password, member_name, member_email, member_celephone, member_role) VALUES (?, ?, ?, ?, ?, ?)");
$insertQuery->execute([$account, $password, $name, $email, $celephone, $role]);

// 註冊成功後重定向到成功頁面
header("Location: ../../front/html/success.html");
exit();
?>