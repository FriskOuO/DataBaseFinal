<!-- filepath: /d:/Xampp/htdocs/DataBaseFinal/server/php/add_movie.php -->
<?php
session_start();
include '../DB.php'; // 包含資料庫連接文件

// 獲取資料庫連接
$pdo = Database::getInstance()->getConnection();

// 獲取表單提交的數據
$movie_id = $_POST['movie_id'];
$movie_type = $_POST['movie_type'];
$movie_name = $_POST['movie_name'];
$movie_lv = $_POST['movie_lv'];
$member_account = $_POST['member_account']; // 從表單中獲取會員帳號

// 錯誤檢查
$errors = [];

if (empty($movie_id)) {
    $errors[] = '影片編號不能為空';
}

if (empty($movie_type)) {
    $errors[] = '影片類型不能為空';
}

if (empty($movie_name)) {
    $errors[] = '影片名稱不能為空';
}

if (empty($movie_lv)) {
    $errors[] = '影片等級不能為空';
}

if (empty($member_account)) {
    $errors[] = '會員帳號不能為空';
}

// 檢查資料庫中是否有相同的影片編號
$query = $pdo->prepare("SELECT * FROM movie WHERE movie_id = ?");
$query->execute([$movie_id]);
if ($query->rowCount() > 0) {
    header("Location: ../../front/html/error_movie_exists.html");
    exit();
}

// 檢查添加者帳號是否存在且為管理者
$query = $pdo->prepare("SELECT * FROM member WHERE member_account = ? AND member_role = 'admin'");
$query->execute([$member_account]);
if ($query->rowCount() == 0) {
    header("Location: ../../front/html/error_invalid_account.html");
    exit();
}

// 如果有其他錯誤，將錯誤訊息存入 session 並重定向到錯誤頁面
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: ../../front/html/error.html");
    exit();
}

// 插入新影片資料
$insertQuery = $pdo->prepare("INSERT INTO movie (movie_id, movie_type, movie_name, movie_lv, member_account) VALUES (?, ?, ?, ?, ?)");
$insertQuery->execute([$movie_id, $movie_type, $movie_name, $movie_lv, $member_account]);

// 新增影片成功後重定向到成功頁面
header("Location: ../../front/html/success_add_movie.html");
exit();
?>