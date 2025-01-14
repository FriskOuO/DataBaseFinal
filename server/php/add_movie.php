<?php
header('Content-Type: application/json');

// 清除任何可能干擾 JSON 輸出的緩衝區
if (ob_get_level()) {
    ob_end_clean();
}

// 建立資料庫連線
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final works"; // 替換為您的資料庫名稱

$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查資料庫連線
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => '資料庫連線失敗: ' . $conn->connect_error]);
    exit;
}

// 根據請求方法進行處理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 處理新增電影
    $movie_id = $_POST['movie_id'];
    $movie_type = $_POST['movie_type'];
    $movie_name = $_POST['movie_name'];
    $movie_lv = $_POST['movie_lv'];

    // 驗證必要欄位是否完整
    if (empty($movie_id) || empty($movie_type) || empty($movie_name) || empty($movie_lv)) {
        echo json_encode(['success' => false, 'message' => '所有欄位都是必填的']);
        exit;
    }

    // 新增電影資料
    $sql = "INSERT INTO movie (movie_id, movie_type, movie_name, movie_lv) VALUES ('$movie_id', '$movie_type', '$movie_name', '$movie_lv')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => '電影新增成功']);
    } else {
        echo json_encode(['success' => false, 'message' => '新增失敗: ' . $conn->error]);
    }
} elseif (isset($_GET['action']) && $_GET['action'] === 'get_movies') {
    // 處理取得電影列表
    $sql = "SELECT * FROM movie";
    $result = $conn->query($sql);

    // 檢查 SQL 查詢是否成功
    if (!$result) {
        echo json_encode(['success' => false, 'message' => '查詢失敗: ' . $conn->error]);
        exit;
    }

    // 將查詢結果轉換為陣列
    $movies = [];
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }

    // 回應 JSON 格式的電影列表
    echo json_encode(['success' => true, 'movies' => $movies]);
} else {
    // 處理無效請求
    echo json_encode(['success' => false, 'message' => '無效的請求']);
}

// 關閉資料庫連線
$conn->close();
?>