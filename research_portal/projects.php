<?php
require_once __DIR__ . "/includes/db.php";

$page_title = "Research Projects";
require_once __DIR__ . "/header.php";

$status_filter = isset($_GET['status']) ? trim($_GET['status']) : 'all';

$sql = "SELECT * FROM projects";
if ($status_filter === 'active' || $status_filter === 'completed') {
    $sql .= " WHERE status = '" . $conn->real_escape_string($status_filter) . "'";
}
$sql .= " ORDER BY id ASC";

$projects = [];
if ($conn && !$conn->connect_error) {
    $res = $conn->query($sql);
    if ($res) {
        while ($p = $res->fetch_assoc()) {
            $projects[] = $p;
        }
    }
}
?>

<section class="section" style="padding-top: 50px;">
    <div class="container">
        <div class="section-title-wrap">
            <span class="section-badge">Lab Innovations</span>
            <h1 class="section-title"><?= $is_rtl ? 'پروژه‌های تحقیقاتی و پایان‌نامه‌ها' : 'Research Projects & Applied Systems' ?></h1>
            <p class="section-subtitle">
                <?= $is_rtl ? 'سامانه‌ها و پلتفرم‌های توسعه‌یافته در آزمایشگاه در حوزه‌های بینایی ماشین، یادگیری عمیق و سخت‌افزارهای پردازش تصویر' : 'Explore cutting-edge projects and thesis initiatives developed by our researchers.' ?>
            </p>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <div class="filter-tabs">
                <a href="projects.php" class="filter-btn <?= ($status_filter === 'all') ? 'active' : '' ?>">
                    <?= htmlspecialchars($tr['all']) ?>
                </a>
                <a href="projects.php?status=active" class="filter-btn <?= ($status_filter === 'active') ? 'active' : '' ?>">
                    🟢 <?= htmlspecialchars($tr['active_projects']) ?>
                </a>
                <a href="projects.php?status=completed" class="filter-btn <?= ($status_filter === 'completed') ? 'active' : '' ?>">
                    🔵 <?= htmlspecialchars($tr['completed_projects']) ?>
                </a>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="projects-grid">
            <?php foreach ($projects as $project): ?>
            <div class="glass-card project-card">
                <div class="project-img-wrap">
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(30, 58, 138, 0.4), rgba(15, 23, 42, 0.8)); font-size: 3.5rem;">
                        🔬
                    </div>
                    <span class="project-status-tag <?= $project['status'] === 'active' ? 'status-active' : 'status-completed' ?>">
                        <?= $project['status'] === 'active' ? ($is_rtl ? 'در حال اجرا' : 'Active') : ($is_rtl ? 'تکمیل شده' : 'Completed') ?>
                    </span>
                </div>
                <div class="project-body">
                    <div style="font-size: 0.82rem; color: var(--accent-cyan); font-weight: 700; margin-bottom: 8px;">
                        <?= htmlspecialchars($project['category']) ?>
                    </div>
                    
                    <h2 class="project-title">
                        <?= htmlspecialchars($is_rtl && !empty($project['title_fa']) ? $project['title_fa'] : $project['title']) ?>
                    </h2>
                    
                    <p class="project-desc">
                        <?= htmlspecialchars($is_rtl && !empty($project['description_fa']) ? $project['description_fa'] : $project['description']) ?>
                    </p>

                    <div class="project-tech">
                        <?php 
                        $techs = explode(',', $project['tech_stack']);
                        foreach ($techs as $tech): 
                            if (trim($tech)): ?>
                            <span class="tech-tag"><?= htmlspecialchars(trim($tech)) ?></span>
                        <?php endif; endforeach; ?>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 14px; border-top: 1px solid var(--border-color); font-size: 0.88rem;">
                        <span style="color: var(--text-secondary);">
                            👤 <strong><?= $is_rtl ? 'پژوهشگر: ' : 'Lead: ' ?></strong><?= htmlspecialchars($project['lead_researcher']) ?>
                        </span>
                        <?php if (!empty($project['link'])): ?>
                        <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank" class="btn btn-outline btn-sm">
                            🔗 <?= $is_rtl ? 'کد / دمو' : 'Code / Demo' ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/footer.php"; ?>
