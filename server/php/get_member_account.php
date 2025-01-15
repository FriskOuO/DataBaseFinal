<!-- filepath: /d:/Xampp/htdocs/DataBaseFinal/server/php/get_member_account.php -->
<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['member_account'])) {
    echo json_encode(['member_account' => $_SESSION['member_account']]);
} else {
    echo json_encode(['member_account' => '']);
}
?>