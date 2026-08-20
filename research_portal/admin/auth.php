<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// چک کردن اینکه آیا ادمین لاگین کرده یا خیر
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== 1) {
    // اگر لاگین نکرده بود، هدایت به صفحه لاگین
    header("Location: login.php");
    exit();
}
?>
