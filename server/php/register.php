<?php
session_start();

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

// 如果有錯誤，將錯誤訊息存入 session 並重定向回註冊頁面
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: ../../front/html/register.html");
    exit();
}

// 假設這裡有一些註冊邏輯
// ...

// 註冊成功後重定向回註冊頁面並顯示成功訊息
header("Location: ../../front/html/register.html?success=true");
exit();
?>