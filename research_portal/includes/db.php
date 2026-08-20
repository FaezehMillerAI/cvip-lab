<?php
/**
 * Database connection & auto-setup initializer
 */
$host = "localhost";
$user = "root";
$pass = "";
$db   = "image_lab";

// Auto-run setup once
if (!file_exists(__DIR__ . '/.setup_done')) {
    require_once __DIR__ . "/setup.php";
    @file_put_contents(__DIR__ . '/.setup_done', date('Y-m-d H:i:s'));
}

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    // If database connection fails (e.g. running outside MySQL), handle gracefully
    // to allow fallback rendering
    error_log("Database connection failed: " . $conn->connect_error);
} else {
    $conn->set_charset('utf8mb4');
}
?>
