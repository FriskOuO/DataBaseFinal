<?php
session_start();
include('db_connection.php'); // 假設你有一個檔案用於資料庫連線

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 防止 SQL 注入
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // 查詢資料庫
    $sql = "SELECT * FROM users WHERE username = '$username' and password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    // 如果結果匹配 $username 和 $password, 表示登入成功
    if ($count == 1) {
        $_SESSION['login_user'] = $username;
        header("location: welcome.php"); // 登入成功後重定向到歡迎頁面
    } else {
        $error = "您的登入名稱或密碼無效";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>登入</title>
</head>
<body>
    <h2>登入頁面</h2>
    <form action="" method="post">
        <label>使用者名稱 :</label>
        <input type="text" name="username" required><br>
        <label>密碼 :</label>
        <input type="password" name="password" required><br>
        <input type="submit" value=" 登入 ">
    </form>
    <div><?php echo isset($error) ? $error : ''; ?></div>
</body>
</html>