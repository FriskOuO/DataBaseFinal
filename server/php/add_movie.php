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
$member_account = $_SESSION['member_account']; // 從 session 中獲取會員帳號

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

// 如果有錯誤，返回錯誤信息
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ../../front/html/add_movie.html');
    exit();
}

// 插入數據到資料庫
try {
    $stmt = $pdo->prepare("INSERT INTO movies (movie_id, movie_type, movie_name, movie_lv, member_account) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$movie_id, $movie_type, $movie_name, $movie_lv, $member_account]);
    $_SESSION['success'] = '影片新增成功';
} catch (PDOException $e) {
    $_SESSION['errors'] = ['資料庫錯誤: ' . $e->getMessage()];
}

header('Location: ../../front/html/add_movie.html');
exit();
?>