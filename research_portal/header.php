<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = ($_GET['lang'] === 'fa') ? 'fa' : 'en';
}

$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fa';
$is_rtl = ($lang === 'fa');

// Bilingual Dictionary
$t = [
    'fa' => [
        'lab_name' => 'آزمایشگاه پردازش تصویر و بینایی ماشین',
        'lab_sub' => 'دانشکده مهندسی - دانشگاه رازی',
        'home' => 'صفحه اصلی',
        'faculty' => 'اساتید راهنما',
        'research' => 'حوزه‌های پژوهشی',
        'team' => 'اعضای آزمایشگاه',
        'current_students' => 'دانشجویان در حال تحصیل',
        'graduated_students' => 'فارغ‌التحصیلان (Alumni)',
        'publications' => 'مقالات و دستاوردها',
        'projects' => 'پروژه‌های تحقیقاتی',
        'news' => 'اخبار و رویدادها',
        'contact' => 'پذیرش و همکاری',
        'admin' => 'پنل مدیریت',
        'search_placeholder' => 'جستجوی دانشجو، موضوع یا مقاله...',
        'toggle_lang' => 'English',
        'target_lang' => 'en',
        'explore_research' => 'بررسی پژوهش‌ها',
        'meet_team' => 'آشنایی با اعضا',
        'view_pubs' => 'مشاهده مقالات',
        'all' => 'همه',
        'phd_students' => 'دانشجویان دکتری',
        'msc_students' => 'دانشجویان ارشد',
        'alumni' => 'فارغ‌التحصیلان',
        'supervisors' => 'اساتید راهنما',
        'read_more' => 'مشاهده جزئیات',
        'view_profile' => 'مشاهده پروفایل',
        'scholar' => 'گوگل اسکالر',
        'email' => 'ایمیل',
        'supervisor' => 'استاد راهنما',
        'thesis_title' => 'عنوان پایان‌نامه / رساله',
        'research_interests' => 'علایق و زمینه‌های پژوهشی',
        'status' => 'مقطع و وضعیت',
        'active_projects' => 'پروژه‌های فعال',
        'completed_projects' => 'پروژه‌های تکمیل‌شده',
        'copy_bibtex' => 'دریافت BibTeX',
        'download_pdf' => 'دانلود PDF',
        'doi_link' => 'لینک DOI',
        'rights' => 'تمامی حقوق متعلق به آزمایشگاه پردازش تصویر و بینایی ماشین دانشگاه رازی است.'
    ],
    'en' => [
        'lab_name' => 'Computer Vision & Image Processing Lab',
        'lab_sub' => 'Faculty of Engineering - Razi University',
        'home' => 'Home',
        'faculty' => 'Supervisors & Faculty',
        'research' => 'Research Areas',
        'team' => 'Lab Members',
        'current_students' => 'Current Students',
        'graduated_students' => 'Graduated Alumni',
        'publications' => 'Publications',
        'projects' => 'Research Projects',
        'news' => 'News & Events',
        'contact' => 'Join Us / Contact',
        'admin' => 'Admin Panel',
        'search_placeholder' => 'Search members, topics, or papers...',
        'toggle_lang' => 'فارسی',
        'target_lang' => 'fa',
        'explore_research' => 'Explore Research',
        'meet_team' => 'Meet the Team',
        'view_pubs' => 'View Publications',
        'all' => 'All',
        'phd_students' => 'PhD Candidates',
        'msc_students' => 'MSc Students',
        'alumni' => 'Alumni & Graduates',
        'supervisors' => 'Faculty & Supervisors',
        'read_more' => 'Read More',
        'view_profile' => 'View Profile',
        'scholar' => 'Google Scholar',
        'email' => 'Email',
        'supervisor' => 'Supervisor',
        'thesis_title' => 'Thesis / Dissertation Title',
        'research_interests' => 'Research Interests',
        'status' => 'Status & Degree',
        'active_projects' => 'Active Projects',
        'completed_projects' => 'Completed Projects',
        'copy_bibtex' => 'Copy BibTeX',
        'download_pdf' => 'Download PDF',
        'doi_link' => 'DOI Link',
        'rights' => 'All Rights Reserved. Computer Vision & Image Processing Lab, Razi University.'
    ]
];

$tr = $t[$lang];

// Current page detection
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $is_rtl ? 'rtl' : 'ltr' ?>" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' | ' : '' ?><?= htmlspecialchars($tr['lab_name']) ?></title>
    
    <!-- Modern Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Vazirmatn:wght@300;400;500;600;700;800;900&family=Fira+Code:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Modern Theme CSS -->
    <link rel="stylesheet" href="css/modern-theme.css">
</head>
<body>

<!-- High-Tech Navigation Bar -->
<header class="navbar">
    <div class="container navbar-container">
        <!-- Brand Logo -->
        <a href="public_page.php" class="nav-brand">
            <div class="nav-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </div>
            <div class="nav-brand-text">
                <span class="nav-brand-title"><?= htmlspecialchars($tr['lab_name']) ?></span>
                <span class="nav-brand-sub"><?= htmlspecialchars($tr['lab_sub']) ?></span>
            </div>
        </a>

        <!-- Desktop Navigation Links -->
        <nav>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="public_page.php" class="nav-link <?= ($current_page === 'public_page.php' || $current_page === 'index.php') ? 'active' : '' ?>">
                        <?= htmlspecialchars($tr['home']) ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="faculty.php" class="nav-link <?= ($current_page === 'faculty.php' || $current_page === 'professor_details.php') ? 'active' : '' ?>">
                        <?= htmlspecialchars($tr['faculty']) ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="research.php" class="nav-link <?= ($current_page === 'research.php') ? 'active' : '' ?>">
                        <?= htmlspecialchars($tr['research']) ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="team.php" class="nav-link <?= ($current_page === 'team.php' || $current_page === 'student_details.php' || $current_page === 'graduated_students.php') ? 'active' : '' ?>">
                        <?= htmlspecialchars($tr['team']) ?>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                    </a>
                    <div class="nav-dropdown">
                        <a href="team.php" class="nav-dropdown-item">🎓 <?= htmlspecialchars($tr['current_students']) ?></a>
                        <a href="graduated_students.php" class="nav-dropdown-item">🏛️ <?= htmlspecialchars($tr['graduated_students']) ?></a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="projects.php" class="nav-link <?= ($current_page === 'projects.php') ? 'active' : '' ?>">
                        <?= htmlspecialchars($tr['projects']) ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="publications.php" class="nav-link <?= ($current_page === 'publications.php') ? 'active' : '' ?>">
                        <?= htmlspecialchars($tr['publications']) ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="news.php" class="nav-link <?= ($current_page === 'news.php') ? 'active' : '' ?>">
                        <?= htmlspecialchars($tr['news']) ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="contact.php" class="nav-link <?= ($current_page === 'contact.php') ? 'active' : '' ?>">
                        <?= htmlspecialchars($tr['contact']) ?>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Actions (Language, Theme, Admin) -->
        <div class="nav-actions">
            <!-- Language Switcher -->
            <a href="?lang=<?= $tr['target_lang'] ?>" class="lang-toggle" title="Switch Language">
                🌐 <?= $tr['toggle_lang'] ?>
            </a>

            <!-- Dark/Light Theme Switcher -->
            <button class="theme-toggle" type="button" aria-label="Toggle Theme">
                ☀️
            </button>

            <!-- Admin Button -->
            <a href="admin/login.php" class="btn btn-primary btn-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <?= htmlspecialchars($tr['admin']) ?>
            </a>

            <!-- Mobile Menu Toggle Button -->
            <button class="mobile-toggle" aria-label="Toggle Mobile Menu">
                ☰
            </button>
        </div>
    </div>
</header>
