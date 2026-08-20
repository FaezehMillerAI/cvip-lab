<?php
require_once __DIR__ . "/includes/db.php";

$page_title = "Home";
require_once __DIR__ . "/header.php";

// Fetch counts
$counts = ['students' => 35, 'phd' => 9, 'msc' => 22, 'pubs' => 50, 'projects' => 6];
if ($conn && !$conn->connect_error) {
    $res = $conn->query("SELECT COUNT(*) AS total, SUM(CASE WHEN degree='PhD' OR status LIKE '%PhD%' THEN 1 ELSE 0 END) AS phd, SUM(CASE WHEN degree='MSc' OR status LIKE '%MSc%' THEN 1 ELSE 0 END) AS msc FROM students");
    if ($res && $r = $res->fetch_assoc()) {
        $counts['students'] = $r['total'] ?: 35;
        $counts['phd'] = $r['phd'] ?: 9;
        $counts['msc'] = $r['msc'] ?: 22;
    }
}

// Fetch professors
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

<!-- ==========================================================================
     HERO SECTION
     ========================================================================== -->
<section class="hero-section" id="hero">
    <canvas id="vision-canvas"></canvas>
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    <div class="container hero-content">
        <div class="hero-tag">
            <span>⚡</span>
            <span><?= $is_rtl ? 'مرکز تحقیقات پیشرفته پردازش تصویر و هوش مصنوعی' : 'Advanced Computer Vision & AI Research Center' ?></span>
        </div>

        <h1 class="hero-title">
            <span><?= $is_rtl ? 'پیشگام در پژوهش‌های ' : 'Pushing the Frontiers of ' ?></span>
            <span class="gradient-text"><?= $is_rtl ? 'بینایی ماشین، یادگیری عمیق و پردازش تصویر' : 'Computer Vision, Deep Learning & Multimedia' ?></span>
        </h1>

        <p class="hero-desc">
            <?= $is_rtl 
                ? 'آزمایشگاه پردازش تصویر و بینایی ماشین دانشگاه رازی؛ پیشرو در پژوهش‌های هوش مصنوعی پزشکی، سامانه‌های بینایی خودروهای خودران، مدل‌های زبانی چندوجهی و شتاب‌دهنده‌های سخت‌افزاری کم‌مصرف.' 
                : 'Pioneering innovative research in medical image computing, autonomous vehicle perception, multimodal vision-language models, and energy-efficient edge neural accelerators.' ?>
        </p>

        <div style="margin-bottom: 26px;">
            <span style="display: inline-block; background: rgba(56, 189, 248, 0.1); border: 1px solid rgba(56, 189, 248, 0.35); border-radius: var(--radius-full); padding: 8px 24px; font-size: 1.05rem; color: var(--accent-cyan); font-weight: 600; box-shadow: var(--shadow-glow); backdrop-filter: blur(8px);">
                ✨ <?= $is_rtl ? '«هر انسان، داستانی دارد؛ هر تخصص، جهانی.»' : '“Every human has a story; every expertise, a universe.”' ?>
            </span>
        </div>

        <div class="hero-actions">
            <a href="research.php" class="btn btn-primary">
                <?= $is_rtl ? 'بررسی حوزه‌های پژوهشی' : 'Explore Research Areas' ?>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
            <a href="team.php" class="btn btn-secondary"><?= $is_rtl ? 'اعضای آزمایشگاه' : 'Lab Members' ?></a>
            <a href="publications.php" class="btn btn-outline"><?= $is_rtl ? 'مقالات علمی' : 'Publications' ?></a>
        </div>

        <!-- Metrics -->
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-number"><?= $counts['students'] ?>+</div>
                <div class="stat-label"><?= $is_rtl ? 'پژوهشگران و دانشجویان' : 'Scholars & Students' ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?= $counts['phd'] ?>+</div>
                <div class="stat-label"><?= $is_rtl ? 'دانشجویان دکتری' : 'PhD Candidates' ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?= $counts['msc'] ?>+</div>
                <div class="stat-label"><?= $is_rtl ? 'دانشجویان کارشناسی ارشد' : 'MSc Students' ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100+</div>
                <div class="stat-label"><?= $is_rtl ? 'مقالات و دستاوردهای علمی' : 'Research Publications' ?></div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     PORTAL SECTIONS DIRECT CARDS
     ========================================================================== -->
<section class="section">
    <div class="container">
        <div class="section-title-wrap">
            <span class="section-badge"><?= $is_rtl ? 'بخش‌های وب‌سایت' : 'Portal Sections' ?></span>
            <h2 class="section-title"><?= $is_rtl ? 'بخش‌ها و صفحات اختصاصی آزمایشگاه' : 'Explore Laboratory Sections' ?></h2>
            <p class="section-subtitle"><?= $is_rtl ? 'دسترسی سریع به صفحات مستقل اساتید، پژوهش‌ها، اعضا، پروژه‌ها، مقالات و اخبار' : 'Direct access to dedicated pages for faculty, research areas, scholars, projects, publications, and news.' ?></p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; margin-top: 30px;">
            <!-- Faculty -->
            <a href="faculty.php" class="glass-card" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between; text-decoration: none; color: inherit;">
                <div>
                    <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(56, 189, 248, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 16px; border: 1px solid var(--border-glow);">👨‍🏫</div>
                    <h3 style="font-size: 1.25rem; color: var(--text-primary); margin-bottom: 8px;"><?= $is_rtl ? 'اساتید راهنما و هدایت علمی' : 'Faculty & Supervisors' ?></h3>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6;"><?= $is_rtl ? 'سوابق تحصیلی و دانشگاهی دکتر عبدالله چاله چاله و دکتر آرزو کامران، افتخارات علمی و رزومه پژوهشی.' : 'Academic backgrounds, doctoral degrees, and research leadership.' ?></p>
                </div>
                <div style="margin-top: 18px; color: var(--accent-cyan); font-weight: 700; font-size: 0.9rem;">
                    <?= $is_rtl ? 'مشاهده صفحه اساتید ←' : 'View Faculty Profile →' ?>
                </div>
            </a>

            <!-- Research -->
            <a href="research.php" class="glass-card" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between; text-decoration: none; color: inherit;">
                <div>
                    <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(168, 85, 247, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 16px; border: 1px solid var(--border-glow);">🔬</div>
                    <h3 style="font-size: 1.25rem; color: var(--text-primary); margin-bottom: 8px;"><?= $is_rtl ? 'حوزه‌های پژوهشی و نوآوری' : 'Research Domains' ?></h3>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6;"><?= $is_rtl ? '۶ محور کلیدی از جمله هوش مصنوعی پزشکی، مدل‌های چندوجهی VLM، بینایی خودروهای خودران و شتاب‌دهنده‌های FPGA.' : 'Six core pillars in medical AI, multimodal LLMs, edge autonomous vision, and VLSI.' ?></p>
                </div>
                <div style="margin-top: 18px; color: var(--accent-cyan); font-weight: 700; font-size: 0.9rem;">
                    <?= $is_rtl ? 'مشاهده محورهای پژوهش ←' : 'View Research Areas →' ?>
                </div>
            </a>

            <!-- Team -->
            <a href="team.php" class="glass-card" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between; text-decoration: none; color: inherit;">
                <div>
                    <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(59, 130, 246, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 16px; border: 1px solid var(--border-glow);">👥</div>
                    <h3 style="font-size: 1.25rem; color: var(--text-primary); margin-bottom: 8px;"><?= $is_rtl ? 'اعضای آزمایشگاه و دانشجویان' : 'Lab Members & Scholars' ?></h3>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6;"><?= $is_rtl ? 'دایرکتوری کامل ۳۵+ دانشجوی دکتری، کارشناسی ارشد و فارغ‌التحصیلان به همراه فیلتر و جستجوی زنده.' : 'Full directory of PhD candidates, MSc students, and alumni with thesis details.' ?></p>
                </div>
                <div style="margin-top: 18px; color: var(--accent-cyan); font-weight: 700; font-size: 0.9rem;">
                    <?= $is_rtl ? 'مشاهده فهرست اعضا ←' : 'View Team Directory →' ?>
                </div>
            </a>

            <!-- Projects -->
            <a href="projects.php" class="glass-card" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between; text-decoration: none; color: inherit;">
                <div>
                    <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(245, 158, 11, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 16px; border: 1px solid var(--border-glow);">🚀</div>
                    <h3 style="font-size: 1.25rem; color: var(--text-primary); margin-bottom: 8px;"><?= $is_rtl ? 'پروژه‌های تحقیقاتی و صنعتی' : 'Research Projects' ?></h3>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6;"><?= $is_rtl ? 'سامانه‌ها و پلتفرم‌های کاربردی در حال اجرا و تکمیل شده، تکنولوژی‌های مورد استفاده و پژوهشگران مجری.' : 'Active and completed prototypes, deep learning toolkits, and hardware implementations.' ?></p>
                </div>
                <div style="margin-top: 18px; color: var(--accent-cyan); font-weight: 700; font-size: 0.9rem;">
                    <?= $is_rtl ? 'مشاهده پروژه‌ها ←' : 'View Projects →' ?>
                </div>
            </a>

            <!-- Publications -->
            <a href="publications.php" class="glass-card" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between; text-decoration: none; color: inherit;">
                <div>
                    <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 16px; border: 1px solid var(--border-glow);">📚</div>
                    <h3 style="font-size: 1.25rem; color: var(--text-primary); margin-bottom: 8px;"><?= $is_rtl ? 'مقالات و انتشارات علمی' : 'Publications' ?></h3>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6;"><?= $is_rtl ? 'کاتالوگ مقالات چاپ شده در IEEE TMI، Elsevier و کنفرانس‌ها با لینک DOI و کپی استناد BibTeX.' : 'Catalog of peer-reviewed articles with DOI links, PDF downloads, and BibTeX citations.' ?></p>
                </div>
                <div style="margin-top: 18px; color: var(--accent-cyan); font-weight: 700; font-size: 0.9rem;">
                    <?= $is_rtl ? 'مشاهده مقالات علمی ←' : 'View Publications →' ?>
                </div>
            </a>

            <!-- News & Events -->
            <a href="news.php" class="glass-card" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between; text-decoration: none; color: inherit;">
                <div>
                    <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(236, 72, 153, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 16px; border: 1px solid var(--border-glow);">📰</div>
                    <h3 style="font-size: 1.25rem; color: var(--text-primary); margin-bottom: 8px;"><?= $is_rtl ? 'اخبار، جلسات دفاع و رویدادها' : 'News & Events' ?></h3>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6;"><?= $is_rtl ? 'اطلاعیه زمان دفاع رساله‌های دکتری و پایان‌نامه‌ها، اخبار پذیرش مقالات و کارگاه‌های آموزشی.' : 'Defense schedules, paper acceptance announcements, and workshop alerts.' ?></p>
                </div>
                <div style="margin-top: 18px; color: var(--accent-cyan); font-weight: 700; font-size: 0.9rem;">
                    <?= $is_rtl ? 'مشاهده رویدادها ←' : 'View News & Events →' ?>
                </div>
            </a>

            <!-- About & Contact -->
            <a href="contact.php" class="glass-card" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between; text-decoration: none; color: inherit;">
                <div>
                    <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(56, 189, 248, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 16px; border: 1px solid var(--border-glow);">🏢</div>
                    <h3 style="font-size: 1.25rem; color: var(--text-primary); margin-bottom: 8px;"><?= $is_rtl ? 'درباره ما، امکانات و تماس' : 'About Us & Contact' ?></h3>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6;"><?= $is_rtl ? 'معرفی سرورهای GPU آزمایشگاه، تجهیزات پردازش لبه، موقعیت مکانی و فرم درخواست همکاری پژوهشی.' : 'GPU computing clusters, edge vision testbeds, directions, and admissions form.' ?></p>
                </div>
                <div style="margin-top: 18px; color: var(--accent-cyan); font-weight: 700; font-size: 0.9rem;">
                    <?= $is_rtl ? 'مشاهده درباره ما و تماس ←' : 'View About & Contact →' ?>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- ==========================================================================
     FACULTY SPOTLIGHT
     ========================================================================== -->
<section class="section section-alt">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; flex-wrap: wrap; gap: 16px;">
            <div>
                <span class="section-badge"><?= $is_rtl ? 'هدایت علمی' : 'Leadership' ?></span>
                <h2 class="section-title" style="margin-bottom: 6px;"><?= $is_rtl ? 'اساتید راهنمای آزمایشگاه' : 'Supervisors & Faculty' ?></h2>
                <p class="section-subtitle" style="margin: 0;"><?= $is_rtl ? 'هدایت علمی پروژه‌ها و راهنمایی دانشجویان تحصیلات تکمیلی' : 'Leading academic excellence and doctoral supervision' ?></p>
            </div>
            <a href="faculty.php" class="btn btn-secondary btn-sm"><?= $is_rtl ? 'مشاهده جزئیات کامل اساتید ←' : 'View Full Faculty Page →' ?></a>
        </div>

        <div class="professors-grid">
            <?php foreach ($professors as $p): 
                $name = $is_rtl && !empty($p['name_fa']) ? $p['name_fa'] : $p['name'];
                $pos  = $is_rtl && !empty($p['position_fa']) ? $p['position_fa'] : $p['position'];
                $field = $is_rtl && !empty($p['field_fa']) ? $p['field_fa'] : $p['field'];
                $img = !empty($p['image']) ? $p['image'] : 'default.png';
            ?>
            <div class="glass-card prof-featured-card">
                <div class="prof-img-wrap">
                    <img src="uploads/<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($name) ?>">
                </div>
                <div class="prof-info">
                    <span class="prof-badge"><?= $is_rtl ? 'عضو هیئت علمی دانشگاه رازی' : 'Faculty Member' ?></span>
                    <h3 class="prof-name"><?= htmlspecialchars($name) ?></h3>
                    <p class="prof-title"><?= htmlspecialchars($pos) ?></p>
                    <p class="prof-field">
                        <strong><?= $is_rtl ? 'حوزه‌های تخصصی: ' : 'Research Focus: ' ?></strong>
                        <span><?= htmlspecialchars($field) ?></span>
                    </p>
                    <div class="prof-links">
                        <?php if (!empty($p['scholar_link'])): ?>
                        <a href="<?= htmlspecialchars($p['scholar_link']) ?>" target="_blank" class="btn btn-primary btn-sm">
                            🎓 <?= $is_rtl ? 'گوگل اسکالر' : 'Google Scholar' ?>
                        </a>
                        <?php endif; ?>
                        <a href="faculty.php" class="btn btn-outline btn-sm">
                            📄 <?= $is_rtl ? 'رزومه و سوابق' : 'Full CV' ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/footer.php"; ?>