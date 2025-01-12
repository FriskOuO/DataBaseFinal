<?php
session_start();
if (isset($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {
        echo '<p class="error">' . htmlspecialchars($error) . '</p>';
    }
    unset($_SESSION['errors']);
}
?>