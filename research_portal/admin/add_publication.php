<?php
require_once "auth.php";
require_once "../includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title    = trim($_POST["title"]);
    $authors  = trim($_POST["authors"]);
    $journal  = trim($_POST["journal"]);
    $year     = !empty($_POST["year"]) ? intval($_POST["year"]) : null;
    $doi      = trim($_POST["doi"]);
    $link     = trim($_POST["link"]);
    $pub_type = trim($_POST["pub_type"] ?? 'Journal');
    $bibtex   = trim($_POST["bibtex"] ?? '');
    $citations = !empty($_POST["citations"]) ? intval($_POST["citations"]) : 0;

    $pdf_file = "";

    if (isset($_FILES["pdf_file"]) && $_FILES["pdf_file"]["error"] == 0) {
        $upload_dir = "../uploads/publications/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $original_name = basename($_FILES["pdf_file"]["name"]);
        $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

        if ($ext == "pdf") {
            $pdf_file = time() . "_" . preg_replace("/[^a-zA-Z0-9._-]/", "_", $original_name);
            move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $upload_dir . $pdf_file);
        }
    }

    $stmt = $conn->prepare("INSERT INTO publications (title, authors, journal, year, doi, link, pdf_file, bibtex, pub_type, citations) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisssssi", $title, $authors, $journal, $year, $doi, $link, $pdf_file, $bibtex, $pub_type, $citations);

    if ($stmt->execute()) {
        $message = "Publication added successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Publication | Admin Panel</title>
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
.form-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 36px;
    max-width: 800px;
}
.form-group { margin-bottom: 18px; }
label { display: block; font-size: 0.88rem; font-weight: 600; margin-bottom: 8px; color: var(--text-primary); }
input, select, textarea {
    width: 100%; padding: 12px 16px; background: var(--bg-main);
    border: 1px solid var(--border); border-radius: 8px; color: white; outline: none; font-size: 0.92rem;
}
input:focus, select:focus, textarea:focus { border-color: var(--accent); }
.btn {
    padding: 12px 24px; border-radius: 8px; font-weight: 700; font-size: 0.95rem;
    border: none; cursor: pointer; background: var(--accent-blue); color: white;
}
.msg { padding: 14px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; }
.msg-ok { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid #34d399; }
</style>
</head>
<body>

<aside class="sidebar">
    <div class="brand">🔬 CVIP Lab CMS</div>
    <nav class="nav-links">
        <a href="dashboard.php" class="nav-link">📊 Overview</a>
        <a href="students.php" class="nav-link">👥 Students</a>
        <a href="add_student.php" class="nav-link">➕ Add Student</a>
        <a href="professor.php" class="nav-link">👨‍🏫 Faculty & Bio</a>
        <a href="add_publication.php" class="nav-link active">📚 Add Publication</a>
        <a href="../public_page.php" target="_blank" class="nav-link">🌐 View Website</a>
        <a href="logout.php" class="nav-link" style="margin-top:auto; color:#f87171;">🚪 Sign Out</a>
    </nav>
</aside>

<main class="content">
    <div class="form-card">
        <h1 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 20px;">➕ Add Scientific Publication</h1>

        <?php if (!empty($message)): ?>
            <div class="msg msg-ok"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Publication Title *</label>
                <input type="text" name="title" placeholder="e.g. Multimodal LLMs for Disease Understanding..." required>
            </div>

            <div class="form-group">
                <label>Authors *</label>
                <input type="text" name="authors" placeholder="e.g. Faezeh Safari, Abdolah Chalechale" required>
            </div>

            <div class="form-group">
                <label>Journal / Conference Venue</label>
                <input type="text" name="journal" placeholder="e.g. IEEE Transactions on Medical Imaging">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label>Year *</label>
                    <input type="number" name="year" value="<?= date('Y') ?>" required>
                </div>
                <div class="form-group">
                    <label>Publication Type</label>
                    <select name="pub_type">
                        <option value="Journal">Journal Article</option>
                        <option value="Conference">Conference Paper</option>
                        <option value="Book Chapter">Book Chapter</option>
                        <option value="Thesis">Thesis / Dissertation</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Citations Count</label>
                    <input type="number" name="citations" value="0">
                </div>
            </div>

            <div class="form-group">
                <label>DOI (e.g. 10.1109/TMI.2026.3129841)</label>
                <input type="text" name="doi" placeholder="10.xxxx/xxxx">
            </div>

            <div class="form-group">
                <label>External Paper URL</label>
                <input type="url" name="link" placeholder="https://ieeexplore.ieee.org/...">
            </div>

            <div class="form-group">
                <label>BibTeX Citation Format</label>
                <textarea name="bibtex" rows="4" placeholder="@article{author2026,...}"></textarea>
            </div>

            <div class="form-group">
                <label>Upload PDF Document</label>
                <input type="file" name="pdf_file" accept=".pdf">
            </div>

            <button type="submit" class="btn">💾 Save Publication</button>
        </form>
    </div>
</main>

</body>
</html>
