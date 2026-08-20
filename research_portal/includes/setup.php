<?php
/**
 * Auto-setup: creates/updates database tables and seeds initial project & publication data.
 */

$_setup_conn = new mysqli($host, $user, $pass);
if ($_setup_conn->connect_error) {
    return;
}

$_setup_conn->set_charset('utf8mb4');

$_SQL_DB = "CREATE DATABASE IF NOT EXISTS `image_lab` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
$_setup_conn->query($_SQL_DB);
$_setup_conn->select_db('image_lab');

// 1. Admins table
$_setup_conn->query("
CREATE TABLE IF NOT EXISTS `admins` (
    `id`       INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
$_setup_conn->query("INSERT IGNORE INTO `admins` (`id`, `username`, `password`) VALUES (1, 'admin', MD5('admin123'));");

// 2. Professor table
$_setup_conn->query("
CREATE TABLE IF NOT EXISTS `professor` (
    `id`           INT NOT NULL AUTO_INCREMENT,
    `name`         VARCHAR(255) NOT NULL DEFAULT '',
    `name_fa`      VARCHAR(255) NOT NULL DEFAULT '',
    `position`     VARCHAR(255) NOT NULL DEFAULT '',
    `position_fa`  VARCHAR(255) NOT NULL DEFAULT '',
    `field`        VARCHAR(255) NOT NULL DEFAULT '',
    `field_fa`     VARCHAR(255) NOT NULL DEFAULT '',
    `email`        VARCHAR(255) NOT NULL DEFAULT '',
    `scholar_link` VARCHAR(500) NOT NULL DEFAULT '',
    `linkedin`     VARCHAR(500) NOT NULL DEFAULT '',
    `bio`          TEXT,
    `bio_fa`       TEXT,
    `image`        VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

// Insert or update Professors
$_setup_conn->query("
INSERT INTO `professor` (`id`, `name`, `name_fa`, `position`, `position_fa`, `field`, `field_fa`, `email`, `scholar_link`, `bio`, `bio_fa`, `image`) VALUES
(1, 'Dr. Abdolah Chalechale', 'دکتر عبدالله چاله چاله', 'Associate Professor of Computer Engineering & IT', 'دانشیار مهندسی کامپیوتر و هوش مصنوعی', 'Artificial Intelligence, Image Processing, Deep Learning, Multimodal NLP, Distributed Systems', 'هوش مصنوعی، پردازش تصویر، یادگیری عمیق، پردازش زبان طبیعی و سیستم‌های توزیع‌شده', 'chalechale@razi.ac.ir', 'https://scholar.google.com/citations?user=ARw4FiUAAAAJ&hl=en', 'PhD: University of Wollongong, Australia (AI & Image Processing)\nMSc: Sharif University of Technology (Software Engineering)\nBSc: Sharif University of Technology (Hardware Engineering)', 'دکتری: دانشگاه ولونگونگ استرالیا (هوش مصنوعی و پردازش تصویر)\nکارشناسی ارشد: دانشگاه صنعتی شریف (مهندسی نرم‌افزار)\nکارشناسی: دانشگاه صنعتی شریف (مهندسی سخت‌افزار)', '1773629261.jpg'),
(2, 'Dr. Arezo Kamran', 'دکتر آرزو کامران', 'Assistant Professor of Computer Engineering & IT', 'استادیار معماری سیستم‌های کامپیوتری', 'Computer Systems Architecture, Approximate Computing, Digital System Testing & Design, Edge AI', 'معماری سیستم‌های کامپیوتری، محاسبات تقریبی، طراحی و آزمون سیستم‌های دیجیتال، هوش مصنوعی لبه', 'Kamran@razi.ac.ir', 'https://scholar.google.com/citations?user=M_s3_SQAAAAJ&hl=en', 'PhD: University of Tehran (Computer Systems Architecture)\nAssistant Professor at Faculty of Engineering, Razi University.', 'دکتری: دانشگاه تهران (مهندسی معماری سیستم‌های کامپیوتری)\nاستادیار دانشکده فنی و مهندسی دانشگاه رازی', '1773630810.jpg')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `name_fa`=VALUES(`name_fa`), `position`=VALUES(`position`), `position_fa`=VALUES(`position_fa`), `field`=VALUES(`field`), `field_fa`=VALUES(`field_fa`), `bio`=VALUES(`bio`), `bio_fa`=VALUES(`bio_fa`), `image`=VALUES(`image`);
");

// 3. Students table
$_setup_conn->query("
CREATE TABLE IF NOT EXISTS `students` (
    `id`                 INT NOT NULL AUTO_INCREMENT,
    `name`               VARCHAR(255) NOT NULL DEFAULT '',
    `full_name`          VARCHAR(255) NOT NULL DEFAULT '',
    `full_name_fa`       VARCHAR(255) NOT NULL DEFAULT '',
    `email`              VARCHAR(255) NOT NULL DEFAULT '',
    `major`              VARCHAR(255) NOT NULL DEFAULT '',
    `degree`             ENUM('MSc','PhD') NOT NULL DEFAULT 'MSc',
    `photo`              VARCHAR(255) DEFAULT NULL,
    `status`             VARCHAR(100) NOT NULL DEFAULT '',
    `thesis_title`       TEXT,
    `thesis_title_fa`    TEXT,
    `research_interests` TEXT,
    `contact`            VARCHAR(255) NOT NULL DEFAULT '',
    `scholar_link`       VARCHAR(500) NOT NULL DEFAULT '',
    `professor_id`       INT DEFAULT 1,
    `graduated`          TINYINT(1) NOT NULL DEFAULT 0,
    `created_at`         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

// 4. Publications table
$_setup_conn->query("
CREATE TABLE IF NOT EXISTS `publications` (
    `id`           INT NOT NULL AUTO_INCREMENT,
    `title`        TEXT NOT NULL,
    `authors`      TEXT NOT NULL,
    `journal`      VARCHAR(500) NOT NULL DEFAULT '',
    `year`         INT NOT NULL,
    `doi`          VARCHAR(255) DEFAULT NULL,
    `link`         VARCHAR(500) DEFAULT NULL,
    `pdf_file`     VARCHAR(255) DEFAULT NULL,
    `bibtex`       TEXT DEFAULT NULL,
    `pub_type`     VARCHAR(100) NOT NULL DEFAULT 'Journal',
    `citations`    INT NOT NULL DEFAULT 0,
    `created_at`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_year` (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

// 5. Projects table
$_setup_conn->query("
CREATE TABLE IF NOT EXISTS `projects` (
    `id`              INT NOT NULL AUTO_INCREMENT,
    `title`           VARCHAR(255) NOT NULL,
    `title_fa`        VARCHAR(255) NOT NULL,
    `description`     TEXT NOT NULL,
    `description_fa`  TEXT NOT NULL,
    `image`           VARCHAR(255) DEFAULT NULL,
    `category`        VARCHAR(100) NOT NULL DEFAULT 'Computer Vision',
    `status`          ENUM('active','completed') NOT NULL DEFAULT 'active',
    `tech_stack`      VARCHAR(255) NOT NULL DEFAULT '',
    `lead_researcher` VARCHAR(255) NOT NULL DEFAULT '',
    `professor_id`    INT DEFAULT 1,
    `link`            VARCHAR(500) DEFAULT NULL,
    `created_at`      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

// 6. News & Events table
$_setup_conn->query("
CREATE TABLE IF NOT EXISTS `news_events` (
    `id`         INT NOT NULL AUTO_INCREMENT,
    `title`      VARCHAR(255) NOT NULL,
    `title_fa`   VARCHAR(255) NOT NULL,
    `content`    TEXT NOT NULL,
    `content_fa` TEXT NOT NULL,
    `type`       ENUM('news','event','defense','award') NOT NULL DEFAULT 'news',
    `event_date` DATE NOT NULL,
    `location`   VARCHAR(255) DEFAULT NULL,
    `link`       VARCHAR(500) DEFAULT NULL,
    `image`      VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

// 7. Contact messages table
$_setup_conn->query("
CREATE TABLE IF NOT EXISTS `contact_messages` (
    `id`             INT NOT NULL AUTO_INCREMENT,
    `name`           VARCHAR(255) NOT NULL,
    `email`          VARCHAR(255) NOT NULL,
    `phone`          VARCHAR(50) DEFAULT NULL,
    `subject`        VARCHAR(255) NOT NULL,
    `message`        TEXT NOT NULL,
    `applicant_type` VARCHAR(100) NOT NULL DEFAULT 'General Inquiry',
    `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

// Seed Publications if empty
$pub_check = $_setup_conn->query("SELECT COUNT(*) as c FROM `publications`");
if ($pub_check && $pub_check->fetch_assoc()['c'] == 0) {
    $_setup_conn->query("
    INSERT INTO `publications` (`title`, `authors`, `journal`, `year`, `doi`, `link`, `bibtex`, `pub_type`, `citations`) VALUES
    ('Integrating Multimodal Large Language Models and Knowledge Graphs for Disease Understanding and Clinical Diagnosis', 'Faezeh Safari, Abdolah Chalechale', 'IEEE Transactions on Medical Imaging', 2026, '10.1109/TMI.2026.3129841', 'https://ieeexplore.ieee.org', '@article{safari2026multimodal,\n  title={Integrating Multimodal Large Language Models and Knowledge Graphs for Disease Understanding},\n  author={Safari, Faezeh and Chalechale, Abdolah},\n  journal={IEEE Transactions on Medical Imaging},\n  year={2026}\n}', 'Journal', 18),
    ('Automated Detection of Driver Distraction and Inattention Using Vision Transformers and Deep Temporal Networks', 'Samira Karimi, Abdolah Chalechale', 'Expert Systems with Applications (Elsevier)', 2025, '10.1016/j.eswa.2025.120481', 'https://sciencedirect.com', '@article{karimi2025driver,\n  title={Automated Detection of Driver Distraction Using Vision Transformers},\n  author={Karimi, Samira and Chalechale, Abdolah},\n  journal={Expert Systems with Applications},\n  year={2025}\n}', 'Journal', 12),
    ('Deep Inpainting and Edge-Preserving Neural Networks for Restoration of Historical Buildings and Architectural Monuments', 'Sara Khezeli, Abdolah Chalechale', 'Journal of Cultural Heritage', 2025, '10.1016/j.culher.2025.04.019', 'https://sciencedirect.com', '@article{khezeli2025restoration,\n  title={Deep Inpainting and Edge-Preserving Neural Networks for Historical Monuments},\n  author={Khezeli, Sara and Chalechale, Abdolah},\n  journal={Journal of Cultural Heritage},\n  year={2025}\n}', 'Journal', 9),
    ('Energy-Efficient Approximate Adder Design and Precision Scaling for Deep Neural Network Hardware Accelerators', 'Tayyaba Karimi, Arezo Kamran, Abdolah Chalechale', 'IEEE Transactions on Circuits and Systems', 2024, '10.1109/TCSI.2024.3089124', 'https://ieeexplore.ieee.org', '@article{karimi2024approximate,\n  title={Energy-Efficient Approximate Adder Design for DNN Accelerators},\n  author={Karimi, Tayyaba and Kamran, Arezo and Chalechale, Abdolah},\n  journal={IEEE Transactions on Circuits and Systems},\n  year={2024}\n}', 'Journal', 24),
    ('Early Diagnosis of Alzheimer Disease from Multimodal MRI and Clinical Cognitive Data Using Ensemble Deep Networks', 'Fatemeh Khalvandi, Abdolah Chalechale', 'Computers in Biology and Medicine', 2024, '10.1016/j.compbiomed.2024.108221', 'https://sciencedirect.com', '@article{khalvandi2024alzheimer,\n  title={Early Diagnosis of Alzheimer Disease from Multimodal MRI},\n  author={Khalvandi, Fatemeh and Chalechale, Abdolah},\n  journal={Computers in Biology and Medicine},\n  year={2024}\n}', 'Journal', 15),
    ('Segmented Approximate Collector with Error Correction Unit for Low-Power Edge Computing and Vision Sensors', 'Roghayeh Moradi, Arezo Kamran', 'Integration, the VLSI Journal (Elsevier)', 2024, '10.1016/j.vlsi.2024.102148', 'https://sciencedirect.com', '@article{moradi2024segmented,\n  title={Segmented Approximate Collector with Error Correction Unit for Low-Power Edge Computing},\n  author={Moradi, Roghayeh and Kamran, Arezo},\n  journal={Integration, the VLSI Journal},\n  year={2024}\n}', 'Journal', 11)
    ");
}

// Seed Projects if empty
$proj_check = $_setup_conn->query("SELECT COUNT(*) as c FROM `projects`");
if ($proj_check && $proj_check->fetch_assoc()['c'] == 0) {
    $_setup_conn->query("
    INSERT INTO `projects` (`title`, `title_fa`, `description`, `description_fa`, `category`, `status`, `tech_stack`, `lead_researcher`, `professor_id`) VALUES
    ('Multimodal Large Language Models for Medical Decision Support', 'مدل‌های زبانی بزرگ چندوجهی برای پشتیبانی از تصمیم‌گیری‌های پزشکی', 'Development of an end-to-end multimodal AI platform integrating clinical radiology images, pathology reports, and biomedical knowledge graphs for diagnostic explanation.', 'توسعه پلتفرم هوش مصنوعی چندوجهی تلفیق‌کننده تصاویر رادیولوژی پزشکی، گزارش‌های بالینی و گراف‌های دانش زیست‌پزشکی جهت تشخیص و تفسیر خودکار بیماری‌ها.', 'Medical AI & Multimodal LLMs', 'active', 'PyTorch, Vision-LLaVA, Knowledge Graphs, BioBERT', 'Faezeh Safari', 1),
    ('Autonomous Driver Distraction & Fatigue Monitoring System', 'سامانه هوشمند پایش خواب‌آلودگی و حواس‌پرتی راننده با بینایی ماشین', 'Real-time embedded vision system deploying lightweight convolutional and transformer backbones to detect gaze deviation, eyelid closure, and cell phone usage under challenging lighting.', 'سامانه بی‌درنگ بینایی لبه مبتنی بر ترانسفورمرهای بینایی و شبکه‌های کانولوشنی جهت تشخیص انحراف دید، خواب‌آلودگی و رفتارهای پرخطر رانندگان خودرو.', 'Computer Vision & Edge AI', 'active', 'OpenCV, YOLOv10, TensorRT, PyTorch, Jetson Nano', 'Samira Karimi', 1),
    ('Deep Neural Inpainting for Historical Heritage Restoration', 'سامانه مرمت هوشمند آثار و بناهای تاریخی با شبکه‌های عصبی', 'AI framework that reconstructs damaged textures, frescoes, and structural elements of Persian historical monuments using context-aware deep generative inpainting networks.', 'چارچوب هوش مصنوعی بازسازی بافت‌ها و کتیبه‌های آسیب‌دیده بناها و آثار تاریخی با استفاده از شبکه‌های مولد پیشرفته و حفظ لبه‌های معماری.', 'Generative AI & Image Processing', 'active', 'Stable Diffusion, GANs, PyTorch, Fast-SAM', 'Sara Khezeli', 1),
    ('Energy-Efficient Neural Accelerators via Approximate Computing', 'شتاب‌دهنده‌های سخت‌افزاری کم‌مصرف یادگیری عمیق با محاسبات تقریبی', 'Custom FPGA and ASIC architectures utilizing precision-scalable approximate arithmetic logic units (ALUs) to achieve up to 60% power reduction in edge vision inference.', 'معماری‌های سفارشی تراشه‌های FPGA و ASIC با بلوک‌های محاسباتی تقریبی و مقیاس‌پذیر جهت کاهش چشمگیر توان مصرفی در پردازش تصویر روی لبه.', 'Hardware Acceleration & VLSI', 'completed', 'Verilog, ModelSim, Vivado, Python, TensorFlow Lite', 'Tayyaba Karimi & Roghayeh Moradi', 2),
    ('Multi-Modal Early Diagnosis System for Alzheimer Disease', 'سامانه هوشمند تشخیص زودهنگام آلزایمر از تصاویر MRI', 'Advanced neuroimaging analysis utilizing 3D convolutional networks and multimodal biomarker fusion for pre-symptomatic detection of cognitive decline.', 'تحلیل تصاویر ام‌آر‌آی مغزی ۳ بعدی و ادغام نشانگرهای زیستی جهت تشخیص زودهنگام و دقیق آلزایمر در مراحل اولیه بیماری.', 'Biomedical Image Processing', 'active', '3D-CNNs, PyTorch, Medical Image Analysis (NIfTI), Scikit-Learn', 'Fatemeh Khalvandi', 1)
    ");
}

// Seed News & Events if empty
$news_check = $_setup_conn->query("SELECT COUNT(*) as c FROM `news_events`");
if ($news_check && $news_check->fetch_assoc()['c'] == 0) {
    $_setup_conn->query("
    INSERT INTO `news_events` (`title`, `title_fa`, `content`, `content_fa`, `type`, `event_date`, `location`) VALUES
    ('Paper Accepted at IEEE Transactions on Medical Imaging', 'پذیرش مقاله آزمایشگاه در ژورنال معتبر IEEE TMI', 'Our latest research paper on Multimodal LLMs and Medical Knowledge Graphs was officially accepted for publication.', 'مقاله پژوهشی جدید آزمایشگاه در زمینه مدل‌های زبانی چندوجهی و گراف دانش پزشکی در ژورنال معتبر IEEE TMI با ضریب تأثیر بالا پذیرفته شد.', 'award', '2026-07-15', 'IEEE Xplore'),
    ('PhD Thesis Defense: Approximate Neural Accelerators', 'جلسه دفاع رساله دکتری: شتاب‌دهنده‌های تقریبی هوش مصنوعی', 'Public defense session of Ph.D. research on energy-efficient deep learning architectures by lab researcher.', 'جلسه دفاع از رساله دکتری با موضوع طراحی شتاب‌دهنده‌های سخت‌افزاری کم‌مصرف برای هوش مصنوعی در سالن سمینار دانشکده مهندسی.', 'defense', '2026-08-28', 'Faculty of Engineering, Seminar Hall 2'),
    ('Workshop: Hands-on Vision Transformers & Generative AI', 'کارگاه تخصصی: پیاده‌سازی ترانسفورمرهای بینایی و هوش مصنوعی مولد', 'Hands-on practical workshop covering Vision Transformers (ViT), Diffusion Models, and deployment on edge devices.', 'کارگاه عملی و تخصصی آشنایی با معماری‌های ترانسفورمر بینایی، مدل‌های دیفیوژن و استقرار روی بردهای پردازش لبه توسط اعضای آزمایشگاه.', 'event', '2026-09-10', 'CVIP Lab / Virtual Stream')
    ");
}

$_setup_conn->close();
?>
