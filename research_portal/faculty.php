<?php
require_once __DIR__ . "/includes/db.php";

$page_title = "Supervisors & Faculty";
require_once __DIR__ . "/header.php";

// Fetch professors from DB
$professors = [];
if ($conn && !$conn->connect_error) {
    $p_res = $conn->query("SELECT * FROM professor ORDER BY id ASC");
    if ($p_res) {
        while ($row = $p_res->fetch_assoc()) {
            $professors[] = $row;
        }
    }
}
?>

<!-- Page Header -->
<div class="page-header" style="padding: 130px 0 50px 0; background: var(--gradient-hero); text-align: center; border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <span class="section-badge">Supervisors & Leadership</span>
        <h1 class="hero-title" style="font-size: 2.3rem; margin-bottom: 12px;">
            <?= $is_rtl ? 'اساتید راهنما و هدایت علمی آزمایشگاه' : 'Faculty Leadership & Supervisors' ?>
        </h1>
        <p class="hero-desc" style="max-width: 750px; margin: 0 auto;">
            <?= $is_rtl ? 'هدایت علمی طرح‌های پژوهشی و راهنمایی دانشجویان تحصیلات تکمیلی توسط اعضای هیئت علمی آزمایشگاه' : 'Guiding advanced graduate research and directing doctoral and master theses at Razi University.' ?>
        </p>
    </div>
</div>

<section class="section">
    <div class="container">
        
        <?php if (!empty($professors)): ?>
            <?php foreach ($professors as $p): 
                $name = $is_rtl && !empty($p['name_fa']) ? $p['name_fa'] : $p['name'];
                $pos  = $is_rtl && !empty($p['position_fa']) ? $p['position_fa'] : $p['position'];
                $field = $is_rtl && !empty($p['field_fa']) ? $p['field_fa'] : $p['field'];
                $bio = $is_rtl && !empty($p['bio_fa']) ? $p['bio_fa'] : $p['bio'];
                $img = !empty($p['image']) ? $p['image'] : 'default.png';
            ?>
            <div class="glass-card" style="margin-bottom: 40px; padding: 36px;">
                <div class="prof-featured-card" style="border: none; background: transparent; padding: 0;">
                    <div class="prof-img-wrap" style="width: 230px; height: 280px;">
                        <img src="uploads/<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($name) ?>">
                    </div>
                    <div class="prof-info">
                        <span class="prof-badge"><?= $is_rtl ? 'عضو هیئت علمی دانشگاه رازی' : 'Faculty Member' ?></span>
                        <h2 class="prof-name" style="font-size: 1.8rem; margin-bottom: 4px;"><?= htmlspecialchars($name) ?></h2>
                        <p class="prof-title" style="font-size: 1rem; color: var(--accent-cyan);"><?= htmlspecialchars($pos) ?></p>
                        
                        <p class="prof-field" style="margin: 14px 0;">
                            <strong><?= $is_rtl ? 'زمینه‌های تخصصی پژوهش: ' : 'Research Focus: ' ?></strong>
                            <span><?= htmlspecialchars($field) ?></span>
                        </p>

                        <?php if (!empty($bio)): ?>
                        <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-top: 16px;">
                            <strong style="color: var(--text-primary); display: block; margin-bottom: 10px;"><?= $is_rtl ? '🎓 سوابق تحصیلی و دانشگاهی:' : '🎓 Educational Background:' ?></strong>
                            <div style="color: var(--text-secondary); font-size: 0.92rem; line-height: 1.8; white-space: pre-line;">
                                <?= htmlspecialchars($bio) ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="prof-links" style="margin-top: 24px;">
                            <?php if (!empty($p['scholar_link'])): ?>
                            <a href="<?= htmlspecialchars($p['scholar_link']) ?>" target="_blank" class="btn btn-primary">
                                🎓 <?= $is_rtl ? 'پروفایل گوگل اسکالر' : 'Google Scholar Profile' ?>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($p['email'])): ?>
                            <a href="mailto:<?= htmlspecialchars($p['email']) ?>" class="btn btn-outline">
                                ✉️ <?= htmlspecialchars($p['email']) ?>
                            </a>
                            <?php endif; ?>
                            <a href="professor_details.php?id=<?= $p['id'] ?>" class="btn btn-secondary">
                                👥 <?= $is_rtl ? 'دانشجویان و سوابق تکمیلی' : 'Supervised Students & Details' ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</section>

<?php require_once __DIR__ . "/footer.php"; ?>
