<?php
session_start();
include '../DB.php'; // 包含資料庫連接文件

// 獲取資料庫連接
$pdo = Database::getInstance()->getConnection();

// 獲取表單數據
$account = $_POST['account'];
$password = $_POST['password'];
$role = $_POST['role'];

// 檢查帳號是否存在
$query = $pdo->prepare("SELECT * FROM member WHERE member_account = ?");
$query->execute([$account]);
$user = $query->fetch();

if (!$user) {
    // 無此帳號
    if ($role === 'admin') {
        header("Location: ../../front/html/error_admin_no_account.html");
    } else {
        header("Location: ../../front/html/error_no_account.html");
    }
    exit();
}

// 檢查帳號和密碼是否正確
$query = $pdo->prepare("SELECT * FROM member WHERE member_account = ? AND member_password = ?");
$query->execute([$account, $password]);
$user = $query->fetch();

if ($user) {
    // 檢查角色是否正確
    if ($user['member_role'] !== $role) {
        if ($role === 'admin') {
            header("Location: ../../front/html/error_admin_wrong_role.html");
        } else {
            header("Location: ../../front/html/error_user_wrong_role.html");
        }
        exit();
    }

    // 登入成功
    $_SESSION['user'] = $user;
    if ($role === 'user') {
        header("Location: ../../front/html/user_home.html"); // 重定向到 user_home.html
    } elseif ($role === 'admin') {
        header("Location: ../../front/html/admin_home.html"); // 重定向到 admin_home.html
    }
    exit();
} else {
    // 帳號或密碼錯誤
    if ($role === 'admin') {
        header("Location: ../../front/html/error_admin_wrong_password.html");
    } else {
        header("Location: ../../front/html/error_wrong_password.html");
    }
    exit();
}

// 預期外的錯誤
if ($role === 'admin') {
    header("Location: ../../front/html/error_admin_unexpected.html");
} else {
    header("Location: ../../front/html/error_unexpected.html");
}
exit();
?>