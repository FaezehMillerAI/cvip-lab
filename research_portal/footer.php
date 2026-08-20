<!-- Footer Component -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Col 1: Brand & About -->
            <div>
                <div class="nav-brand">
                    <div class="nav-logo-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </div>
                    <span class="nav-brand-title"><?= htmlspecialchars($tr['lab_name']) ?></span>
                </div>
                <p class="footer-brand-desc">
                    <?= $is_rtl 
                        ? 'مرکز تحقیقات پیشرفته در حوزه بینایی ماشین، یادگیری عمیق، پردازش تصویر، سیستم‌های چندوجهی و شتاب‌دهنده‌های سخت‌افزاری هوش مصنوعی در دانشگاه رازی.' 
                        : 'Advanced Research Center for Computer Vision, Deep Learning, Medical Image Processing, Multimodal Systems, and Hardware AI Accelerators at Razi University.' ?>
                </p>
            </div>

            <!-- Col 2: Quick Links -->
            <div>
                <h4 class="footer-heading"><?= $is_rtl ? 'صفحات وب‌سایت' : 'Website Pages' ?></h4>
                <ul class="footer-links">
                    <li><a href="public_page.php"><?= htmlspecialchars($tr['home']) ?></a></li>
                    <li><a href="faculty.php"><?= htmlspecialchars($tr['faculty']) ?></a></li>
                    <li><a href="research.php"><?= htmlspecialchars($tr['research']) ?></a></li>
                    <li><a href="team.php"><?= htmlspecialchars($tr['team']) ?></a></li>
                    <li><a href="projects.php"><?= htmlspecialchars($tr['projects']) ?></a></li>
                    <li><a href="publications.php"><?= htmlspecialchars($tr['publications']) ?></a></li>
                    <li><a href="news.php"><?= htmlspecialchars($tr['news']) ?></a></li>
                    <li><a href="contact.php"><?= htmlspecialchars($tr['contact']) ?></a></li>
                </ul>
            </div>

            <!-- Col 3: Research Themes -->
            <div>
                <h4 class="footer-heading"><?= $is_rtl ? 'محورهای پژوهشی' : 'Research Themes' ?></h4>
                <ul class="footer-links">
                    <li><a href="research.php"><?= $is_rtl ? 'پردازش تصویر پزشکی' : 'Medical Imaging' ?></a></li>
                    <li><a href="research.php"><?= $is_rtl ? 'بینایی ماشین و خودرو خودران' : 'Autonomous Vision' ?></a></li>
                    <li><a href="research.php"><?= $is_rtl ? 'مدل‌های زبانی چندوجهی' : 'Multimodal LLMs' ?></a></li>
                    <li><a href="research.php"><?= $is_rtl ? 'شتاب‌دهنده‌های سخت‌افزاری' : 'Hardware Accelerators' ?></a></li>
                    <li><a href="research.php"><?= $is_rtl ? 'مرمت هوشمند آثار تاریخی' : 'Heritage Inpainting' ?></a></li>
                </ul>
            </div>

            <!-- Col 4: Contact & Location -->
            <div>
                <h4 class="footer-heading"><?= $is_rtl ? 'ارتباط با آزمایشگاه' : 'Contact & Location' ?></h4>
                <ul class="footer-links">
                    <li style="color: var(--text-secondary); font-size: 0.9rem;">
                        📍 <?= $is_rtl ? 'کرمانشاه، طاق‌بستان، دانشگاه رازی، دانشکده فنی و مهندسی، گروه مهندسی کامپیوتر' : 'Faculty of Engineering, Department of Computer Engineering, Razi University, Kermanshah, Iran' ?>
                    </li>
                    <li>
                        <a href="mailto:chalechale@razi.ac.ir">✉️ chalechale@razi.ac.ir</a>
                    </li>
                    <li>
                        <a href="mailto:Kamran@razi.ac.ir">✉️ Kamran@razi.ac.ir</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>
                © <?= date("Y") ?> <?= htmlspecialchars($tr['lab_name']) ?>. <?= htmlspecialchars($tr['rights']) ?>
            </div>
            <div>
                <a href="admin/login.php" style="color: var(--text-muted); font-size: 0.82rem;">Portal CMS</a>
            </div>
        </div>
    </div>
</footer>

<!-- BibTeX Modal Dialog -->
<div class="modal-overlay" id="bibtex-modal">
    <div class="modal-card">
        <button class="modal-close" type="button">✕</button>
        <h3 style="color: var(--text-primary); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            📚 <?= $is_rtl ? 'ارجاع به مقاله (BibTeX Citation)' : 'BibTeX Citation' ?>
        </h3>
        <p style="font-size: 0.88rem; color: var(--text-secondary); margin-bottom: 12px;">
            <?= $is_rtl ? 'می‌توانید استناد زیر را مستقیماً کپی کرده و در مقالات و پایان‌نامه خود استفاده نمایید:' : 'Copy this citation directly into your LaTeX bibliography or paper references:' ?>
        </p>
        <pre class="bibtex-box" id="bibtex-content"></pre>
        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" class="btn btn-primary btn-sm" id="btn-copy-bibtex">
                📋 <?= $is_rtl ? 'کپی استناد' : 'Copy Citation' ?>
            </button>
        </div>
    </div>
</div>

<!-- Interactive Scripts -->
<script src="js/main.js"></script>
</body>
</html>
