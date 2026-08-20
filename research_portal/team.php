<?php
require_once __DIR__ . "/includes/db.php";

$page_title = "Lab Members & Scholars";
require_once __DIR__ . "/header.php";

// Fetch all students with professor name
$students_list = [];
if ($conn && !$conn->connect_error) {
    $s_res = $conn->query("
        SELECT s.*, p.name AS professor_name, p.name_fa AS professor_name_fa 
        FROM students s 
        LEFT JOIN professor p ON s.professor_id = p.id 
        ORDER BY s.graduated ASC, s.degree DESC, s.id DESC
    ");
    if ($s_res) {
        while ($row = $s_res->fetch_assoc()) {
            $students_list[] = $row;
        }
    }
}

$total_count = count($students_list);
$phd_count = count(array_filter($students_list, fn($s) => ($s['degree'] === 'PhD' || stripos($s['status'], 'PhD') !== false) && (int)$s['graduated'] === 0));
$msc_count = count(array_filter($students_list, fn($s) => ($s['degree'] === 'MSc' || stripos($s['status'], 'MSc') !== false) && (int)$s['graduated'] === 0));
$alumni_count = count(array_filter($students_list, fn($s) => (int)$s['graduated'] === 1));
?>

<!-- Page Header -->
<div class="page-header" style="padding: 130px 0 50px 0; background: var(--gradient-hero); text-align: center; border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <span class="section-badge">Scholars & Graduates</span>
        <h1 class="hero-title" style="font-size: 2.3rem; margin-bottom: 8px;">
            <?= $is_rtl ? 'اعضای آزمایشگاه و پژوهشگران' : 'Lab Members & Graduate Scholars' ?>
        </h1>
        <div style="margin: 12px 0 16px 0;">
            <span style="display: inline-block; background: rgba(56, 189, 248, 0.1); border: 1px solid rgba(56, 189, 248, 0.35); border-radius: var(--radius-full); padding: 8px 24px; font-size: 1.05rem; color: var(--accent-cyan); font-weight: 600; box-shadow: var(--shadow-glow); backdrop-filter: blur(8px);">
                ✨ <?= $is_rtl ? '«هر انسان، داستانی دارد؛ هر تخصص، جهانی.»' : '“Every human has a story; every expertise, a universe.”' ?>
            </span>
        </div>
        <p class="hero-desc" style="max-width: 750px; margin: 0 auto;">
            <?= $is_rtl ? 'دانشجویان دکتری تخصصی، کارشناسی ارشد و فارغ‌التحصیلان برجسته آزمایشگاه پردازش تصویر و بینایی ماشین' : 'Doctoral researchers, master students, and alumni contributing to computer vision and machine intelligence.' ?>
        </p>
    </div>
</div>

<section class="section">
    <div class="container">
        
        <!-- Filter & Search Bar -->
        <div class="filter-bar">
            <div class="filter-tabs">
                <button type="button" class="filter-btn active" data-filter="all">
                    <?= $is_rtl ? 'همه اعضا' : 'All Members' ?> (<?= $total_count ?>)
                </button>
                <button type="button" class="filter-btn" data-filter="phd">
                    <?= $is_rtl ? 'دانشجویان دکتری' : 'PhD Candidates' ?> (<?= $phd_count ?>)
                </button>
                <button type="button" class="filter-btn" data-filter="msc">
                    <?= $is_rtl ? 'دانشجویان ارشد' : 'MSc Students' ?> (<?= $msc_count ?>)
                </button>
                <button type="button" class="filter-btn" data-filter="alumni">
                    <?= $is_rtl ? 'فارغ‌التحصیلان' : 'Graduated Alumni' ?> (<?= $alumni_count ?>)
                </button>
            </div>

            <div class="search-input-wrap">
                <span class="search-icon-pos">🔍</span>
                <input type="text" id="student-search-input" placeholder="<?= htmlspecialchars($tr['search_placeholder']) ?>">
            </div>
        </div>

        <!-- Students Grid -->
        <div class="students-grid" id="students-container">
            <?php foreach ($students_list as $student): 
                $name = !empty($student['full_name']) ? $student['full_name'] : $student['name'];
                $is_phd = (stripos($student['status'], 'PhD') !== false || $student['degree'] === 'PhD');
                $is_alumni = ((int)$student['graduated'] === 1);
                $badge_class = $is_alumni ? 'badge-alumni' : ($is_phd ? 'badge-phd' : 'badge-msc');
                $badge_label = $is_alumni 
                    ? ($is_rtl ? 'فارغ‌التحصیل' : 'Alumni') 
                    : ($is_phd ? ($is_rtl ? 'دانشجوی دکتری' : 'PhD Candidate') : ($is_rtl ? 'دانشجوی ارشد' : 'MSc Student'));
                $supervisor_name = !empty($student['professor_name_fa']) && $is_rtl ? $student['professor_name_fa'] : (!empty($student['professor_name']) ? $student['professor_name'] : ($is_rtl ? 'دکتر عبدالله چاله چاله' : 'Dr. Abdolah Chalechale'));
            ?>
            <div class="glass-card student-card student-card-item"
                 data-degree="<?= $student['degree'] ?> <?= $student['status'] ?>"
                 data-graduated="<?= $student['graduated'] ?>"
                 data-name="<?= htmlspecialchars($name) ?>"
                 data-interests="<?= htmlspecialchars($student['research_interests'] ?? '') ?>"
                 data-thesis="<?= htmlspecialchars($student['thesis_title'] ?? '') ?>"
                 data-supervisor="<?= htmlspecialchars($supervisor_name) ?>">
                
                <img class="student-avatar" 
                     src="uploads/<?= !empty($student['photo']) ? htmlspecialchars($student['photo']) : 'default.png' ?>" 
                     alt="<?= htmlspecialchars($name) ?>"
                     onerror="this.src='uploads/default.png'">
                
                <span class="student-degree-badge <?= $badge_class ?>"><?= $badge_label ?></span>
                
                <h3 class="student-name"><?= htmlspecialchars($name) ?></h3>
                
                <div class="student-major"><?= htmlspecialchars($student['major'] ?? '') ?></div>
                
                <?php if (!empty($student['thesis_title'])): ?>
                <div class="student-thesis">
                    <strong><?= htmlspecialchars($tr['thesis_title']) ?>: </strong>
                    <?= htmlspecialchars($student['thesis_title']) ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($supervisor_name)): ?>
                <div style="font-size: 0.82rem; color: var(--accent-cyan); margin-bottom: 14px;">
                    <strong><?= htmlspecialchars($tr['supervisor']) ?>: </strong><?= htmlspecialchars($supervisor_name) ?>
                </div>
                <?php endif; ?>

                <div class="student-card-actions">
                    <a href="student_details.php?id=<?= $student['id'] ?>" class="btn btn-primary btn-sm" style="flex: 1;">
                        <?= htmlspecialchars($tr['view_profile']) ?>
                    </a>
                    
                    <?php if (!empty($student['scholar_link'])): ?>
                    <a href="<?= htmlspecialchars($student['scholar_link']) ?>" target="_blank" class="btn btn-secondary btn-sm" title="Google Scholar">
                        🎓
                    </a>
                    <?php endif; ?>

                    <?php if (!empty($student['email'])): ?>
                    <a href="mailto:<?= htmlspecialchars($student['email']) ?>" class="btn btn-outline btn-sm" title="<?= htmlspecialchars($student['email']) ?>">
                        ✉️
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div id="no-students-msg" style="display: none; text-align: center; padding: 60px 20px; color: var(--text-muted); font-size: 1.1rem;">
            <?= $is_rtl ? 'هیچ پژوهشگری با مشخصات جستجو یافت نشد.' : 'No members found matching your search query.' ?>
        </div>

    </div>
</section>

<?php require_once __DIR__ . "/footer.php"; ?>
