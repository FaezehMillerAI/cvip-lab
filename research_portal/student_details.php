<?php
require_once __DIR__ . "/includes/db.php";

if (!isset($_GET['id'])) {
    header("Location: public_page.php");
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
    SELECT s.*, p.name AS professor_name, p.name_fa AS professor_name_fa, p.id AS professor_id
    FROM students s
    LEFT JOIN professor p ON s.professor_id = p.id
    WHERE s.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
    die("Student profile not found.");
}

$full_name = !empty($student['full_name']) ? $student['full_name'] : $student['name'];
$page_title = $full_name;
require_once __DIR__ . "/header.php";

$is_phd = (stripos($student['status'], 'PhD') !== false || $student['degree'] === 'PhD');
$is_alumni = ((int)$student['graduated'] === 1);
$badge_class = $is_alumni ? 'badge-alumni' : ($is_phd ? 'badge-phd' : 'badge-msc');
$badge_label = $is_alumni 
    ? ($is_rtl ? 'فارغ‌التحصیل' : 'Graduated Alumni') 
    : ($is_phd ? ($is_rtl ? 'دانشجوی دکتری' : 'PhD Candidate') : ($is_rtl ? 'دانشجوی کارشناسی ارشد' : 'MSc Student'));
$supervisor_display = $is_rtl && !empty($student['professor_name_fa']) ? $student['professor_name_fa'] : (!empty($student['professor_name']) ? $student['professor_name'] : ($is_rtl ? 'دکتر عبدالله چاله چاله' : 'Dr. Abdolah Chalechale'));
?>

<section class="section" style="padding-top: 50px;">
    <div class="container" style="max-width: 960px;">
        <div class="glass-card" style="padding: 40px;">
            <!-- Header Profile -->
            <div style="display: flex; gap: 32px; align-items: flex-start; flex-wrap: wrap; margin-bottom: 36px; padding-bottom: 30px; border-bottom: 1px solid var(--border-color);">
                <img src="uploads/<?= !empty($student['photo']) ? htmlspecialchars($student['photo']) : 'default.png' ?>" 
                     alt="<?= htmlspecialchars($full_name) ?>"
                     style="width: 170px; height: 215px; border-radius: var(--radius-md); object-fit: cover; border: 2px solid var(--border-glow); box-shadow: var(--shadow-md);">
                
                <div style="flex: 1; min-width: 280px;">
                    <span class="student-degree-badge <?= $badge_class ?>" style="display: inline-block; font-size: 0.85rem; padding: 4px 14px; margin-bottom: 10px;">
                        <?= $badge_label ?>
                    </span>

                    <h1 style="font-size: 2.2rem; font-weight: 800; color: var(--text-primary); margin-bottom: 6px;">
                        <?= htmlspecialchars($full_name) ?>
                    </h1>

                    <p style="font-size: 1.05rem; color: var(--accent-cyan); font-weight: 600; margin-bottom: 18px;">
                        🎓 <?= htmlspecialchars($student['major']) ?>
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 10px; font-size: 0.95rem;">
                        <div>
                            <strong style="color: var(--text-primary);">👤 <?= htmlspecialchars($tr['supervisor']) ?>:</strong>
                            <?php if (!empty($student['professor_id'])): ?>
                            <a href="professor_details.php?id=<?= $student['professor_id'] ?>" style="color: var(--accent-blue); font-weight: 600; margin-left: 6px;">
                                <?= htmlspecialchars($supervisor_display) ?>
                            </a>
                            <?php else: ?>
                            <span style="color: var(--text-secondary); margin-left: 6px;"><?= htmlspecialchars($supervisor_display) ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($student['email'])): ?>
                        <div>
                            <strong style="color: var(--text-primary);">✉️ <?= htmlspecialchars($tr['email']) ?>:</strong>
                            <a href="mailto:<?= htmlspecialchars($student['email']) ?>" style="color: var(--text-secondary); margin-left: 6px;">
                                <?= htmlspecialchars($student['email']) ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($student['contact']) && $student['contact'] !== $student['email']): ?>
                        <div>
                            <strong style="color: var(--text-primary);">📞 <?= $is_rtl ? 'راه ارتباطی / تماس:' : 'Contact:' ?></strong>
                            <span style="color: var(--text-secondary); margin-left: 6px;"><?= htmlspecialchars($student['contact']) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($student['scholar_link'])): ?>
                    <div style="margin-top: 20px;">
                        <a href="<?= htmlspecialchars($student['scholar_link']) ?>" target="_blank" class="btn btn-primary btn-sm">
                            🎓 <?= htmlspecialchars($tr['scholar']) ?> Profile
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Thesis Section -->
            <?php if (!empty($student['thesis_title'])): ?>
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 1.25rem; color: var(--text-primary); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    📑 <?= htmlspecialchars($tr['thesis_title']) ?>
                </h3>
                <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-color); padding: 20px; border-radius: var(--radius-md); color: var(--text-secondary); font-size: 1.05rem; line-height: 1.8;">
                    <?= nl2br(htmlspecialchars($student['thesis_title'])) ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Research Interests Section -->
            <?php if (!empty($student['research_interests'])): ?>
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 1.25rem; color: var(--text-primary); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    🔬 <?= htmlspecialchars($tr['research_interests']) ?>
                </h3>
                <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-color); padding: 20px; border-radius: var(--radius-md); color: var(--text-secondary); font-size: 1rem; line-height: 1.8;">
                    <?= nl2br(htmlspecialchars($student['research_interests'])) ?>
                </div>
            </div>
            <?php endif; ?>

            <div style="display: flex; gap: 14px; margin-top: 36px; padding-top: 20px; border-top: 1px solid var(--border-color);">
                <a href="public_page.php#team" class="btn btn-secondary">
                    ← <?= $is_rtl ? 'بازگشت به فهرست اعضا' : 'Back to Lab Members' ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/footer.php"; ?>
