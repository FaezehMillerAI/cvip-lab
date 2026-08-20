<?php
require_once __DIR__ . "/includes/db.php";

$page_title = "Graduated Alumni";
require_once __DIR__ . "/header.php";

$sql = "
SELECT 
    s.*,
    p.name AS professor_name,
    p.name_fa AS professor_name_fa
FROM students s
LEFT JOIN professor p ON s.professor_id = p.id
WHERE s.graduated = 1
ORDER BY s.id DESC
";

$alumni = [];
if ($conn && !$conn->connect_error) {
    $res = $conn->query($sql);
    if ($res) {
        while ($a = $res->fetch_assoc()) {
            $alumni[] = $a;
        }
    }
}
?>

<section class="section" style="padding-top: 50px;">
    <div class="container">
        <div class="section-title-wrap">
            <span class="section-badge">Hall of Fame</span>
            <h1 class="section-title"><?= $is_rtl ? 'فارغ‌التحصیلان آزمایشگاه (Alumni)' : 'Graduated Alumni Hall' ?></h1>
            <p class="section-subtitle">
                <?= $is_rtl ? 'پژوهشگران و دانش‌آموختگان مقاطع دکتری و کارشناسی ارشد آزمایشگاه پردازش تصویر و بینایی ماشین' : 'Honoring our distinguished graduates making an impact in academic and industrial frontiers worldwide.' ?>
            </p>
        </div>

        <?php if (count($alumni) > 0): ?>
        <div class="students-grid">
            <?php foreach ($alumni as $student): 
                $name = !empty($student['full_name']) ? $student['full_name'] : $student['name'];
                $is_phd = (stripos($student['status'], 'PhD') !== false || $student['degree'] === 'PhD');
                $supervisor_name = $is_rtl && !empty($student['professor_name_fa']) ? $student['professor_name_fa'] : (!empty($student['professor_name']) ? $student['professor_name'] : 'Dr. Chalechale / Dr. Kamran');
            ?>
            <div class="glass-card student-card">
                <img class="student-avatar" src="uploads/<?= !empty($student['photo']) ? htmlspecialchars($student['photo']) : 'default.png' ?>" alt="<?= htmlspecialchars($name) ?>">
                <span class="student-degree-badge badge-alumni">
                    🏛️ <?= $is_rtl ? 'فارغ‌التحصیل' : 'Alumni' ?>
                </span>
                <h3 class="student-name"><?= htmlspecialchars($name) ?></h3>
                <div class="student-major"><?= htmlspecialchars($student['major']) ?></div>
                
                <div style="font-size: 0.82rem; color: var(--accent-cyan); margin-bottom: 8px;">
                    👤 <?= htmlspecialchars($supervisor_name) ?>
                </div>

                <div class="student-thesis">
                    <?= htmlspecialchars(!empty($student['thesis_title']) ? $student['thesis_title'] : $student['research_interests']) ?>
                </div>

                <div class="student-card-actions">
                    <a href="student_details.php?id=<?= $student['id'] ?>" class="btn btn-primary btn-sm" style="flex: 1;">
                        <?= htmlspecialchars($tr['view_profile']) ?>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="glass-card" style="padding: 40px; text-align: center; color: var(--text-muted);">
            <?= $is_rtl ? 'اطلاعاتی در این بخش ثبت نشده است.' : 'No graduated alumni recorded yet.' ?>
        </div>
        <?php endif; ?>

        <div style="margin-top: 36px; text-align: center;">
            <a href="public_page.php" class="btn btn-secondary">
                ← <?= $is_rtl ? 'بازگشت به صفحه اصلی' : 'Back to Home' ?>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/footer.php"; ?>