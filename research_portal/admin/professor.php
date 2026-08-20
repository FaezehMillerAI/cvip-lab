<?php
require_once "auth.php";
require_once "../includes/db.php";

$professors = $conn->query("SELECT * FROM professor ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Faculty & Supervisors | Admin Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
    --bg-main: #0a0e1a;
    --bg-side: #0f172a;
    --bg-card: #1e293b;
    --border: rgba(255, 255, 255, 0.08);
    --text-primary: #f8fafc;
    --text-muted: #94a3b8;
    --accent: #38bdf8;
    --accent-blue: #3b82f6;
    --radius: 12px;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg-main);
    color: var(--text-primary);
    display: flex;
    min-height: 100vh;
}
.sidebar {
    width: 260px;
    background: var(--bg-side);
    border-right: 1px solid var(--border);
    padding: 30px 20px;
    display: flex;
    flex-direction: column;
}
.brand { font-size: 1.2rem; font-weight: 800; color: var(--accent); margin-bottom: 30px; }
.nav-links { display: flex; flex-direction: column; gap: 6px; flex-grow: 1; }
.nav-link {
    display: flex; align-items: center; gap: 12px; padding: 12px 16px;
    color: var(--text-muted); text-decoration: none; font-weight: 600; font-size: 0.92rem;
    border-radius: 8px; transition: all 0.2s;
}
.nav-link:hover, .nav-link.active { background: rgba(56, 189, 248, 0.1); color: var(--accent); }
.content { flex: 1; padding: 40px; overflow-y: auto; }
.grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 24px; margin-top: 24px; }
.prof-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px;
    display: flex;
    gap: 20px;
    align-items: flex-start;
}
.prof-card img {
    width: 110px; height: 135px; border-radius: 8px; object-fit: cover;
}
.btn {
    padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;
    text-decoration: none; display: inline-block; margin-top: 12px;
}
.btn-primary { background: var(--accent-blue); color: white; }
</style>
</head>
<body>

<aside class="sidebar">
    <div class="brand">🔬 CVIP Lab CMS</div>
    <nav class="nav-links">
        <a href="dashboard.php" class="nav-link">📊 Overview</a>
        <a href="students.php" class="nav-link">👥 Students</a>
        <a href="add_student.php" class="nav-link">➕ Add Student</a>
        <a href="professor.php" class="nav-link active">👨‍🏫 Faculty & Bio</a>
        <a href="add_publication.php" class="nav-link">📚 Publications</a>
        <a href="../public_page.php" target="_blank" class="nav-link">🌐 View Website</a>
        <a href="logout.php" class="nav-link" style="margin-top:auto; color:#f87171;">🚪 Sign Out</a>
    </nav>
</aside>

<main class="content">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 800;">Faculty & Lab Supervisors</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Manage professor bios, education timelines, scholar links, and photos.</p>
        </div>
        <a href="add_professor.php" class="btn btn-primary">➕ Add Professor</a>
    </div>

    <div class="grid">
        <?php if ($professors && $professors->num_rows > 0): ?>
        <?php while ($p = $professors->fetch_assoc()): ?>
        <div class="prof-card">
            <img src="../uploads/<?= !empty($p['image']) ? htmlspecialchars($p['image']) : 'default.png' ?>" alt="">
            <div style="flex: 1;">
                <h3 style="font-size: 1.2rem; color: var(--text-primary);"><?= htmlspecialchars($p['name']) ?></h3>
                <div style="font-size: 0.85rem; color: var(--accent); margin: 4px 0 8px 0;"><?= htmlspecialchars($p['position']) ?></div>
                <div style="font-size: 0.82rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 8px;">
                    <strong>Field:</strong> <?= htmlspecialchars($p['field']) ?>
                </div>
                <div style="font-size: 0.82rem; color: var(--text-muted);">
                    ✉️ <?= htmlspecialchars($p['email']) ?>
                </div>
                <a href="edit_professor.php?id=<?= $p['id'] ?>" class="btn btn-primary">✏️ Edit Profile</a>
            </div>
        </div>
        <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
