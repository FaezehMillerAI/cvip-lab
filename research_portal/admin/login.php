<?php
session_start();
require_once "../includes/db.php";

if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']);

    if ($conn && !$conn->connect_error) {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $_SESSION['admin'] = 1;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "نام کاربری یا رمز عبور اشتباه است";
        }
    } else {
        // Fallback for demo admin/admin123
        if ($username === 'admin' && $_POST['password'] === 'admin123') {
            $_SESSION['admin'] = 1;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "نام کاربری یا رمز عبور اشتباه است";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به پنل مدیریت | Research Lab CMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Vazirmatn:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/modern-theme.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: var(--gradient-hero);
            margin: 0;
            padding: 20px;
        }
        .login-box {
            width: 100%;
            max-width: 440px;
            padding: 40px;
        }
    </style>
</head>
<body>

<div class="glass-card login-box">
    <div style="text-align: center; margin-bottom: 28px;">
        <div class="nav-logo-icon" style="margin: 0 auto 16px auto;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>
        <h1 style="font-size: 1.6rem; font-weight: 800; color: var(--text-primary); margin-bottom: 6px;">پنل مدیریت آزمایشگاه</h1>
        <p style="color: var(--text-muted); font-size: 0.88rem;">جهت ورود نام کاربری و رمز عبور خود را وارد نمایید</p>
    </div>

    <?php if(!empty($error)): ?>
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 0.9rem;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label class="form-label">نام کاربری (Username)</label>
            <input type="text" name="username" class="form-control" placeholder="admin" value="admin" required>
        </div>

        <div class="form-group">
            <label class="form-label">کلمه عبور (Password)</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" value="admin123" required>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
            ورود به سیستم (Sign In)
        </button>
    </form>

    <div style="margin-top: 24px; text-align: center;">
        <a href="../public_page.php" style="color: var(--text-muted); font-size: 0.85rem; text-decoration: none;">
            ← بازگشت به وب‌سایت آزمایشگاه
        </a>
    </div>
</div>

</body>
</html>
