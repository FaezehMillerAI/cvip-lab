<?php
require_once __DIR__ . "/includes/db.php";

$page_title = "Publications";
require_once __DIR__ . "/header.php";

// Filter by year
$year_filter = isset($_GET['year']) ? intval($_GET['year']) : 0;
$type_filter = isset($_GET['type']) ? trim($_GET['type']) : '';

$where_clauses = [];
$params = [];
$types = "";

if ($year_filter > 0) {
    $where_clauses[] = "year = ?";
    $params[] = $year_filter;
    $types .= "i";
}

if (!empty($type_filter)) {
    $where_clauses[] = "pub_type = ?";
    $params[] = $type_filter;
    $types .= "s";
}

$sql = "SELECT * FROM publications";
if (count($where_clauses) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}
$sql .= " ORDER BY year DESC, id DESC";

$publications = [];
if ($conn && !$conn->connect_error) {
    if (count($params) > 0) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $res = $stmt->get_result();
    } else {
        $res = $conn->query($sql);
    }
    if ($res) {
        while ($r = $res->fetch_assoc()) {
            $publications[] = $r;
        }
    }
}

// Available years
$years = [];
if ($conn && !$conn->connect_error) {
    $res_y = $conn->query("SELECT DISTINCT year FROM publications WHERE year IS NOT NULL AND year > 0 ORDER BY year DESC");
    if ($res_y) {
        while ($y = $res_y->fetch_assoc()) {
            $years[] = (int)$y['year'];
        }
    }
}
?>

<section class="section" style="padding-top: 50px;">
    <div class="container">
        <div class="section-title-wrap">
            <span class="section-badge">Scientific Index</span>
            <h1 class="section-title"><?= $is_rtl ? 'مقالات و انتشارات علمی آزمایشگاه' : 'Scientific Publications' ?></h1>
            <p class="section-subtitle">
                <?= $is_rtl ? 'فهرست مقالات منتشر شده اعضای هیئت علمی و پژوهشگران آزمایشگاه با قابلیت جستجو، دانلود و دریافت استناد BibTeX' : 'Comprehensive archive of peer-reviewed journal articles, conference proceedings, and thesis publications.' ?>
            </p>
        </div>

        <!-- Filter and Search Bar -->
        <div class="filter-bar">
            <div class="filter-tabs">
                <a href="publications.php" class="filter-btn <?= ($year_filter === 0) ? 'active' : '' ?>">
                    <?= htmlspecialchars($tr['all']) ?>
                </a>
                <?php foreach ($years as $yr): ?>
                <a href="publications.php?year=<?= $yr ?>" class="filter-btn <?= ($year_filter === $yr) ? 'active' : '' ?>">
                    <?= $yr ?>
                </a>
                <?php endforeach; ?>
            </div>

            <div class="search-input-wrap">
                <span class="search-icon-pos">🔍</span>
                <input type="text" id="pub-search-input" placeholder="<?= $is_rtl ? 'جستجو بر اساس عنوان، نویسنده یا ژورنال...' : 'Search by title, author, or journal...' ?>">
            </div>
        </div>

        <!-- Publications List -->
        <div class="pub-list">
            <?php if (count($publications) > 0): ?>
                <?php foreach ($publications as $pub): ?>
                <div class="glass-card pub-item">
                    <div class="pub-header">
                        <span class="pub-year-badge"><?= (int)$pub['year'] ?></span>
                        <span class="pub-venue-badge"><?= htmlspecialchars($pub['pub_type']) ?></span>
                        <?php if (!empty($pub['citations']) && (int)$pub['citations'] > 0): ?>
                        <span style="font-size: 0.8rem; color: var(--accent-amber); font-weight: 700;">
                            ⭐ <?= (int)$pub['citations'] ?> <?= $is_rtl ? 'استناد' : 'Citations' ?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <h2 class="pub-title"><?= htmlspecialchars($pub['title']) ?></h2>
                    <div class="pub-authors">👥 <?= htmlspecialchars($pub['authors']) ?></div>
                    <div class="pub-journal">📖 <?= htmlspecialchars($pub['journal']) ?></div>

                    <div class="pub-actions">
                        <?php if (!empty($pub['doi'])): ?>
                        <a href="https://doi.org/<?= htmlspecialchars($pub['doi']) ?>" target="_blank" class="btn btn-outline btn-sm">
                            🔗 <?= htmlspecialchars($tr['doi_link']) ?>
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($pub['link'])): ?>
                        <a href="<?= htmlspecialchars($pub['link']) ?>" target="_blank" class="btn btn-primary btn-sm">
                            🌐 <?= $is_rtl ? 'مشاهده مقاله' : 'View Paper' ?>
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($pub['pdf_file'])): ?>
                        <a href="uploads/publications/<?= htmlspecialchars($pub['pdf_file']) ?>" target="_blank" class="btn btn-secondary btn-sm">
                            📄 <?= htmlspecialchars($tr['download_pdf']) ?>
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($pub['bibtex'])): ?>
                        <button type="button" class="btn btn-secondary btn-sm btn-bibtex" data-bibtex="<?= htmlspecialchars($pub['bibtex']) ?>">
                            📋 <?= htmlspecialchars($tr['copy_bibtex']) ?>
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="glass-card" style="padding: 40px; text-align: center; color: var(--text-muted);">
                    <?= $is_rtl ? 'مقاله‌ای برای سال یا شرایط انتخابی یافت نشد.' : 'No publications found matching your selected criteria.' ?>
                </div>
            <?php endif; ?>
        </div>

        <div id="no-pubs-msg" style="display: none; text-align: center; padding: 40px; color: var(--text-muted);">
            <?= $is_rtl ? 'مقاله‌ای با این عبارت جستجو یافت نشد.' : 'No publications found matching your search term.' ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/footer.php"; ?>
