<?php
require_once __DIR__ . "/auth.php";
require_once "../includes/db.php";

/* ================= Professors ================= */
$professors = $conn->query("SELECT * FROM professor ORDER BY id ASC");

/* ================= Stats ================= */
$total = 0;
$msc = 0;
$phd = 0;
$alumni = 0;
$pub_count = 0;
$proj_count = 0;

$res_total = $conn->query("SELECT COUNT(*) as c FROM students WHERE graduated=0");
if ($res_total) $total = $res_total->fetch_assoc()['c'];

$res_msc = $conn->query("SELECT COUNT(*) as c FROM students WHERE (status LIKE '%MSc%' OR degree='MSc') AND graduated=0");
if ($res_msc) $msc = $res_msc->fetch_assoc()['c'];

$res_phd = $conn->query("SELECT COUNT(*) as c FROM students WHERE (status LIKE '%PhD%' OR degree='PhD') AND graduated=0");
if ($res_phd) $phd = $res_phd->fetch_assoc()['c'];

$res_alumni = $conn->query("SELECT COUNT(*) as c FROM students WHERE graduated=1");
if ($res_alumni) $alumni = $res_alumni->fetch_assoc()['c'];

$res_pub = $conn->query("SELECT COUNT(*) as c FROM publications");
if ($res_pub) $pub_count = $res_pub->fetch_assoc()['c'];

$res_proj = $conn->query("SELECT COUNT(*) as c FROM projects");
if ($res_proj) $proj_count = $res_proj->fetch_assoc()['c'];

/* ================= Student Search ================= */
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== "") {
    $stmt = $conn->prepare("
        SELECT id, COALESCE(full_name, name) AS full_name, email, major, status, photo, graduated 
        FROM students 
        WHERE full_name LIKE CONCAT('%', ?, '%') OR name LIKE CONCAT('%', ?, '%') OR email LIKE CONCAT('%', ?, '%')
        ORDER BY id DESC LIMIT 20
    ");
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $students = $stmt->get_result();
} else {
    $students = $conn->query("
        SELECT id, COALESCE(full_name, name) AS full_name, email, major, status, photo, graduated
        FROM students 
        ORDER BY graduated ASC, CASE WHEN status LIKE '%PhD%' OR degree='PhD' THEN 1 ELSE 2 END ASC, id ASC
    ");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | CVIP Research Lab</title>
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

/* Sidebar */
.sidebar {
    width: 260px;
    background: var(--bg-side);
    border-right: 1px solid var(--border);
    padding: 30px 20px;
    display: flex;
    flex-direction: column;
}

.brand {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--accent);
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.nav-links {
    display: flex;
    flex-direction: column;
    gap: 6px;
    flex-grow: 1;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: var(--text-muted);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.92rem;
    border-radius: 8px;
    transition: all 0.2s;
}

.nav-link:hover, .nav-link.active {
    background: rgba(56, 189, 248, 0.1);
    color: var(--accent);
}

.logout-btn {
    margin-top: auto;
    color: #f87171 !important;
}

/* Content Area */
.content {
    flex: 1;
    padding: 40px;
    overflow-y: auto;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.header-title h1 {
    font-size: 1.8rem;
    font-weight: 800;
}

.header-title p {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-top: 4px;
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin-bottom: 36px;
}

.stat-box {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px;
    text-align: center;
    transition: transform 0.2s;
}

.stat-box:hover {
    transform: translateY(-3px);
    border-color: var(--accent);
}

.stat-num {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--accent);
    line-height: 1;
    margin-bottom: 8px;
}

.stat-lbl {
    font-size: 0.85rem;
    color: var(--text-muted);
    font-weight: 600;
}

/* Action Buttons */
.quick-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.88rem;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
}

.btn-primary {
    background: var(--accent-blue);
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.05);
    color: var(--text-primary);
    border: 1px solid var(--border);
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--accent);
}

/* Card Block */
.card-block {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 28px;
    margin-bottom: 30px;
}

.card-block h2 {
    font-size: 1.25rem;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 14px 16px;
    text-align: left;
    border-bottom: 1px solid var(--border);
}

th {
    color: var(--text-muted);
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

td {
    font-size: 0.9rem;
}

tr:hover {
    background: rgba(255, 255, 255, 0.02);
}

.student-thumb {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
}

.badge-active { background: rgba(16, 185, 129, 0.15); color: #34d399; }
.badge-alumni { background: rgba(56, 189, 248, 0.15); color: #38bdf8; }

.action-btns {
    display: flex;
    gap: 8px;
}

.btn-act {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
}

.btn-edit { background: var(--accent-blue); color: white; }
.btn-del { background: #ef4444; color: white; }

.search-box input {
    background: var(--bg-main);
    border: 1px solid var(--border);
    padding: 9px 16px;
    border-radius: 8px;
    color: white;
    outline: none;
}
</style>
</head>
<body>

<aside class="sidebar">
    <div class="brand">
        🔬 CVIP Lab CMS
    </div>

    <nav class="nav-links">
        <a href="dashboard.php" class="nav-link active">📊 Overview</a>
        <a href="students.php" class="nav-link">👥 Students (<?= $total + $alumni ?>)</a>
        <a href="add_student.php" class="nav-link">➕ Add Student</a>
        <a href="professor.php" class="nav-link">👨‍🏫 Faculty & Bio</a>
        <a href="add_publication.php" class="nav-link">📚 Publications (<?= $pub_count ?>)</a>
        <a href="../public_page.php" target="_blank" class="nav-link">🌐 View Website</a>
        <a href="logout.php" class="nav-link logout-btn">🚪 Sign Out</a>
    </nav>
</aside>

<main class="content">
    <div class="top-bar">
        <div class="header-title">
            <h1>Admin Control Panel</h1>
            <p>Manage faculty, graduate students, publications, projects and lab content.</p>
        </div>
        <div>
            <a href="../public_page.php" target="_blank" class="btn btn-secondary">
                🌐 Live Site
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-num"><?= $total ?></div>
            <div class="stat-lbl">Active Students</div>
        </div>
        <div class="stat-box">
            <div class="stat-num"><?= $phd ?></div>
            <div class="stat-lbl">PhD Candidates</div>
        </div>
        <div class="stat-box">
            <div class="stat-num"><?= $msc ?></div>
            <div class="stat-lbl">MSc Students</div>
        </div>
        <div class="stat-box">
            <div class="stat-num"><?= $alumni ?></div>
            <div class="stat-lbl">Alumni Graduates</div>
        </div>
        <div class="stat-box">
            <div class="stat-num"><?= $pub_count ?></div>
            <div class="stat-lbl">Publications</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="add_student.php" class="btn btn-primary">➕ Add New Student</a>
        <a href="add_publication.php" class="btn btn-secondary">📚 Add Publication</a>
        <a href="add_professor.php" class="btn btn-secondary">👨‍🏫 Add / Edit Professor</a>
    </div>

    <!-- Students Management Table -->
    <div class="card-block">
        <h2>
            <span>🎓 Lab Members Directory</span>
            <form class="search-box" method="GET">
                <input type="text" name="search" placeholder="Search student name..." value="<?= htmlspecialchars($search) ?>">
            </form>
        </h2>

        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Full Name</th>
                    <th>Degree / Status</th>
                    <th>Major</th>
                    <th>Email</th>
                    <th>State</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($students && $students->num_rows > 0): ?>
                <?php while ($row = $students->fetch_assoc()): ?>
                <tr>
                    <td>
                        <img class="student-thumb" src="../uploads/<?= !empty($row['photo']) ? htmlspecialchars($row['photo']) : 'default.png' ?>" alt="">
                    </td>
                    <td><strong><?= htmlspecialchars($row['full_name']) ?></strong></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= htmlspecialchars($row['major']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <span class="badge <?= (int)$row['graduated'] === 1 ? 'badge-alumni' : 'badge-active' ?>">
                            <?= (int)$row['graduated'] === 1 ? 'Alumni' : 'Active' ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn-act btn-edit">Edit</a>
                            <a href="delete_student.php?id=<?= $row['id'] ?>" class="btn-act btn-del" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-muted);">No students found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
