<?php
include 'auth.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

if ($role == 'user') {
    if (authenticate_user($username, $password)) {
        header('Location: ../../front/html/user_home.html');
    } else {
        echo '使用者帳號或密碼錯誤';
    }
} elseif ($role == 'admin') {
    if (authenticate_admin($username, $password)) {
        header('Location: ../../front/html/admin_home.html');
    } else {
        echo '管理者帳號或密碼錯誤';
    }
} else {
    echo '無效的角色';
}
?>