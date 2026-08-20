<?php
require_once "auth.php";
require_once "../includes/db.php";

$students = $conn->query("
    SELECT id, COALESCE(full_name, name) AS display_name, email, major, status, degree, photo, graduated 
    FROM students 
    ORDER BY graduated ASC, id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Students | Admin Panel</title>
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
.card-block {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 28px;
}
.top-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}
table { width: 100%; border-collapse: collapse; }
th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid var(--border); }
th { color: var(--text-muted); font-size: 0.82rem; text-transform: uppercase; }
td { font-size: 0.9rem; }
tr:hover { background: rgba(255, 255, 255, 0.02); }
img { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; }
.btn {
    padding: 9px 16px; border-radius: 8px; font-weight: 600; font-size: 0.88rem;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
}
.btn-primary { background: var(--accent-blue); color: white; }
.btn-sm { padding: 6px 12px; font-size: 0.8rem; border-radius: 6px; }
.btn-edit { background: var(--accent-blue); color: white; }
.btn-del { background: #ef4444; color: white; }
.badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
.badge-active { background: rgba(16, 185, 129, 0.15); color: #34d399; }
.badge-alumni { background: rgba(56, 189, 248, 0.15); color: #38bdf8; }
</style>
</head>
<body>

<aside class="sidebar">
    <div class="brand">🔬 CVIP Lab CMS</div>
    <nav class="nav-links">
        <a href="dashboard.php" class="nav-link">📊 Overview</a>
        <a href="students.php" class="nav-link active">👥 Students</a>
        <a href="add_student.php" class="nav-link">➕ Add Student</a>
        <a href="professor.php" class="nav-link">👨‍🏫 Faculty & Bio</a>
        <a href="add_publication.php" class="nav-link">📚 Publications</a>
        <a href="../public_page.php" target="_blank" class="nav-link">🌐 View Website</a>
        <a href="logout.php" class="nav-link" style="margin-top:auto; color:#f87171;">🚪 Sign Out</a>
    </nav>
</aside>

<main class="content">
    <div class="card-block">
        <div class="top-actions">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 800;">All Lab Students & Researchers</h1>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Total records: <?= $students ? $students->num_rows : 0 ?></p>
            </div>
            <a href="add_student.php" class="btn btn-primary">➕ Add New Student</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Major</th>
                    <th>Status / Degree</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($students && $students->num_rows > 0): ?>
                <?php while ($row = $students->fetch_assoc()): ?>
                <tr>
                    <td>
                        <img src="../uploads/<?= !empty($row['photo']) ? htmlspecialchars($row['photo']) : 'default.png' ?>" alt="">
                    </td>
                    <td><strong><?= htmlspecialchars($row['display_name']) ?></strong></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['major']) ?></td>
                    <td><?= htmlspecialchars(!empty($row['status']) ? $row['status'] : $row['degree']) ?></td>
                    <td>
                        <span class="badge <?= (int)$row['graduated'] === 1 ? 'badge-alumni' : 'badge-active' ?>">
                            <?= (int)$row['graduated'] === 1 ? 'Alumni' : 'Active' ?>
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 6px;">
                            <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-edit">Edit</a>
                            <a href="delete_student.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-del" onclick="return confirm('Delete this student?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr><td colspan="7" style="text-align: center; color: var(--text-muted);">No students found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
