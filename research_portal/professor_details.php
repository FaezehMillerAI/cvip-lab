<?php
require_once __DIR__ . "/includes/db.php";

$prof_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$stmt = $conn->prepare("SELECT * FROM professor WHERE id = ?");
$stmt->bind_param("i", $prof_id);
$stmt->execute();
$prof = $stmt->get_result()->fetch_assoc();

if (!$prof) {
    die("Professor not found!");
}

$page_title = $prof['name'];
require_once __DIR__ . "/header.php";

// Fetch supervised active students
$stmt_stu = $conn->prepare("SELECT * FROM students WHERE professor_id = ? AND graduated = 0 ORDER BY CASE WHEN status LIKE '%PhD%' OR degree='PhD' THEN 1 ELSE 2 END ASC, id ASC");
$stmt_stu->bind_param("i", $prof_id);
$stmt_stu->execute();
$active_students = $stmt_stu->get_result();

// Fetch supervised alumni
$stmt_alumni = $conn->prepare("SELECT * FROM students WHERE professor_id = ? AND graduated = 1 ORDER BY id DESC");
$stmt_alumni->bind_param("i", $prof_id);
$stmt_alumni->execute();
$graduated_students = $stmt_alumni->get_result();
?>

<section class="section" style="padding-top: 50px;">
    <div class="container">
        <!-- Professor Main Card -->
        <div class="glass-card" style="padding: 40px; margin-bottom: 40px;">
            <div style="display: flex; gap: 36px; align-items: flex-start; flex-wrap: wrap;">
                <div class="prof-img-wrap" style="width: 200px; height: 250px; border-radius: var(--radius-md);">
                    <img src="uploads/<?= !empty($prof['image']) ? htmlspecialchars($prof['image']) : 'default.png' ?>" alt="<?= htmlspecialchars($prof['name']) ?>">
                </div>

                <div style="flex: 1; min-width: 280px;">
                    <span class="prof-badge"><?= $is_rtl ? 'عضو هیئت علمی و استاد راهنما' : 'Faculty Member & Research Supervisor' ?></span>
                    <h1 style="font-size: 2.2rem; font-weight: 800; color: var(--text-primary); margin: 6px 0 10px 0;">
                        <?= htmlspecialchars($is_rtl && !empty($prof['name_fa']) ? $prof['name_fa'] : $prof['name']) ?>
                    </h1>
                    <p style="font-size: 1.05rem; color: var(--accent-cyan); font-weight: 600; margin-bottom: 16px;">
                        <?= htmlspecialchars($is_rtl && !empty($prof['position_fa']) ? $prof['position_fa'] : $prof['position']) ?>
                    </p>
                    
                    <div style="background: rgba(255, 255, 255, 0.03); padding: 18px; border-radius: var(--radius-md); border: 1px solid var(--border-color); margin-bottom: 20px;">
                        <div style="margin-bottom: 8px;">
                            <strong style="color: var(--text-primary);">🔬 <?= $is_rtl ? 'زمینه‌های تخصصی پژوهش:' : 'Research Fields:' ?></strong>
                            <span style="color: var(--text-secondary); margin-left: 6px;">
                                <?= htmlspecialchars($is_rtl && !empty($prof['field_fa']) ? $prof['field_fa'] : $prof['field']) ?>
                            </span>
                        </div>
                        <div>
                            <strong style="color: var(--text-primary);">✉️ <?= $is_rtl ? 'پست الکترونیکی:' : 'Email Address:' ?></strong>
                            <a href="mailto:<?= htmlspecialchars($prof['email']) ?>" style="color: var(--accent-blue); margin-left: 6px;">
                                <?= htmlspecialchars($prof['email']) ?>
                            </a>
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <?php if (!empty($prof['scholar_link'])): ?>
                        <a href="<?= htmlspecialchars($prof['scholar_link']) ?>" target="_blank" class="btn btn-primary btn-sm">
                            🎓 <?= htmlspecialchars($tr['scholar']) ?>
                        </a>
                        <?php endif; ?>
                        <a href="mailto:<?= htmlspecialchars($prof['email']) ?>" class="btn btn-secondary btn-sm">
                            ✉️ <?= $is_rtl ? 'ارسال ایمیل' : 'Send Email' ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Biography & Academic Background -->
            <div style="margin-top: 36px; padding-top: 24px; border-top: 1px solid var(--border-color);">
                <h3 style="font-size: 1.3rem; color: var(--text-primary); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                    🎓 <?= $is_rtl ? 'سوابق تحصیلی و بیوگرافی علمی' : 'Academic Background & Bio' ?>
                </h3>
                <div style="color: var(--text-secondary); line-height: 1.8; white-space: pre-line; background: rgba(0,0,0,0.15); padding: 20px; border-radius: var(--radius-md);">
                    <?= htmlspecialchars($is_rtl && !empty($prof['bio_fa']) ? $prof['bio_fa'] : $prof['bio']) ?>
                </div>
            </div>
        </div>

        <!-- Supervised Current Students -->
        <div class="glass-card" style="padding: 36px; margin-bottom: 40px;">
            <h2 style="font-size: 1.4rem; color: var(--text-primary); margin-bottom: 24px;">
                👥 <?= $is_rtl ? 'دانشجویان در حال تحصیل تحت راهنمایی' : 'Current Supervised Students' ?>
            </h2>

            <?php if ($active_students && $active_students->num_rows > 0): ?>
            <div class="students-grid">
                <?php while ($st = $active_students->fetch_assoc()): 
                    $name = !empty($st['full_name']) ? $st['full_name'] : $st['name'];
                    $is_phd = (stripos($st['status'], 'PhD') !== false || $st['degree'] === 'PhD');
                ?>
                <div class="glass-card student-card">
                    <img class="student-avatar" src="uploads/<?= !empty($st['photo']) ? htmlspecialchars($st['photo']) : 'default.png' ?>" alt="<?= htmlspecialchars($name) ?>">
                    <span class="student-degree-badge <?= $is_phd ? 'badge-phd' : 'badge-msc' ?>">
                        <?= $is_phd ? ($is_rtl ? 'دانشجوی دکتری' : 'PhD Student') : ($is_rtl ? 'دانشجوی ارشد' : 'MSc Student') ?>
                    </span>
                    <h4 class="student-name"><?= htmlspecialchars($name) ?></h4>
                    <div class="student-major"><?= htmlspecialchars($st['major']) ?></div>
                    <div class="student-thesis">
                        <?= htmlspecialchars(!empty($st['thesis_title']) ? $st['thesis_title'] : $st['research_interests']) ?>
                    </div>
                    <a href="student_details.php?id=<?= $st['id'] ?>" class="btn btn-primary btn-sm" style="width: 100%; margin-top: auto;">
                        <?= htmlspecialchars($tr['view_profile']) ?>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
            <?php else: ?>
            <p style="color: var(--text-muted);"><?= $is_rtl ? 'اطلاعاتی ثبت نشده است.' : 'No active students listed.' ?></p>
            <?php endif; ?>
        </div>

        <!-- Supervised Graduated Alumni -->
        <?php if ($graduated_students && $graduated_students->num_rows > 0): ?>
        <div class="glass-card" style="padding: 36px;">
            <h2 style="font-size: 1.4rem; color: var(--text-primary); margin-bottom: 24px;">
                🏛️ <?= $is_rtl ? 'فارغ‌التحصیلان تحت راهنمایی (Alumni)' : 'Supervised Alumni & Graduates' ?>
            </h2>
            <div class="students-grid">
                <?php while ($al = $graduated_students->fetch_assoc()): 
                    $name = !empty($al['full_name']) ? $al['full_name'] : $al['name'];
                ?>
                <div class="glass-card student-card">
                    <img class="student-avatar" src="uploads/<?= !empty($al['photo']) ? htmlspecialchars($al['photo']) : 'default.png' ?>" alt="<?= htmlspecialchars($name) ?>">
                    <span class="student-degree-badge badge-alumni"><?= $is_rtl ? 'فارغ‌التحصیل' : 'Alumni' ?></span>
                    <h4 class="student-name"><?= htmlspecialchars($name) ?></h4>
                    <div class="student-major"><?= htmlspecialchars($al['major']) ?></div>
                    <div class="student-thesis">
                        <?= htmlspecialchars(!empty($al['thesis_title']) ? $al['thesis_title'] : $al['research_interests']) ?>
                    </div>
                    <a href="student_details.php?id=<?= $al['id'] ?>" class="btn btn-secondary btn-sm" style="width: 100%; margin-top: auto;">
                        <?= htmlspecialchars($tr['view_profile']) ?>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>

        <div style="margin-top: 30px;">
            <a href="public_page.php" class="btn btn-secondary">
                ← <?= $is_rtl ? 'بازگشت به صفحه اصلی' : 'Back to Home' ?>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/footer.php"; ?>
