<?php
require_once __DIR__ . "/includes/db.php";

$page_title = "News & Events";
require_once __DIR__ . "/header.php";

$news_items = [];
if ($conn && !$conn->connect_error) {
    $res = $conn->query("SELECT * FROM news_events ORDER BY event_date DESC, id DESC");
    if ($res) {
        while ($n = $res->fetch_assoc()) {
            $news_items[] = $n;
        }
    }
}
?>

<section class="section" style="padding-top: 50px;">
    <div class="container">
        <div class="section-title-wrap">
            <span class="section-badge">Lab Bulletin</span>
            <h1 class="section-title"><?= $is_rtl ? 'اخبار، رویدادها و اطلاعیه‌ها' : 'News & Lab Announcements' ?></h1>
            <p class="section-subtitle">
                <?= $is_rtl ? 'جلسات دفاع پایان‌نامه و رساله دکتری، پذیرش مقالات علمی، برگزاری کارگاه‌های تخصصی و رویدادهای آزمایشگاه' : 'Stay informed with upcoming defense sessions, newly accepted papers, seminar announcements, and achievements.' ?>
            </p>
        </div>

        <div class="news-grid">
            <?php foreach ($news_items as $item): 
                $badge_icon = '📢';
                if ($item['type'] === 'defense') $badge_icon = '🎓';
                if ($item['type'] === 'award') $badge_icon = '🏆';
                if ($item['type'] === 'event') $badge_icon = '🗓️';
            ?>
            <div class="glass-card news-card">
                <div class="news-date">
                    <span><?= $badge_icon ?></span>
                    <span><?= htmlspecialchars($item['event_date']) ?></span>
                    <?php if (!empty($item['location'])): ?>
                        • <span>📍 <?= htmlspecialchars($item['location']) ?></span>
                    <?php endif; ?>
                </div>

                <h2 class="news-title">
                    <?= htmlspecialchars($is_rtl && !empty($item['title_fa']) ? $item['title_fa'] : $item['title']) ?>
                </h2>

                <p class="news-excerpt">
                    <?= nl2br(htmlspecialchars($is_rtl && !empty($item['content_fa']) ? $item['content_fa'] : $item['content'])) ?>
                </p>

                <?php if (!empty($item['link'])): ?>
                <div style="margin-top: auto; padding-top: 16px;">
                    <a href="<?= htmlspecialchars($item['link']) ?>" target="_blank" class="btn btn-outline btn-sm">
                        🔗 <?= $is_rtl ? 'اطلاعات بیشتر / پیوند' : 'More Details / Link' ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/footer.php"; ?>
