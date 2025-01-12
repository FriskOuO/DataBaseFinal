/php/login.php
<?php
include 'auth.php';

$account = $_POST['account'];
$password = $_POST['password'];
$role = $_POST['role'];

if ($role == 'user') {
    if (authenticate_user($account, $password)) {
        header('Location: ../../front/html/user_home.html');
    } else {
        echo '使用者帳號或密碼錯誤';
    }
} elseif ($role == 'admin') {
    if (authenticate_admin($account, $password)) {
        header('Location: ../../front/html/admin_home.html');
    } else {
        echo '管理者帳號或密碼錯誤';
    }
} else {
    echo '無效的角色';
}
?>