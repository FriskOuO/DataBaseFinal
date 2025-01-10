<?php
session_start();
include('../DB.php'); // 假設你有一個檔案用於資料庫連線
include 'auth.php';

$account = $_POST['account'];
$password = $_POST['password'];
$role = $_POST['role'];

if ($role == 'user') {
    if (authenticate_user($account, $password)) {
        header('Location: ../../front/html/user_home.html');
    } else {
        header('Location: ../../front/html/user_login.html?error=user');
    }
} elseif ($role == 'admin') {
    if (authenticate_admin($account, $password)) {
        header('Location: ../../front/html/admin_home.html');
    } else {
        header('Location: ../../front/html/admin_login.html?error=admin');
    }
} else {
    echo '無效的角色';
}
?>