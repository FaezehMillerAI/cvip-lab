-- =============================================================
--  CVIP LAB — Advanced Research Laboratory Schema
--  Computer Vision & Image Processing Research Laboratory
--  Razi University
-- =============================================================

CREATE DATABASE IF NOT EXISTS `image_lab`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `image_lab`;

-- -------------------------------------------------------------
--  Table: admins
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
    `id`       INT          NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `admins` (`id`, `username`, `password`)
VALUES (1, 'admin', MD5('admin123'));

-- -------------------------------------------------------------
--  Table: professor
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `professor` (
    `id`           INT           NOT NULL AUTO_INCREMENT,
    `name`         VARCHAR(255)  NOT NULL DEFAULT '',
    `name_fa`      VARCHAR(255)  NOT NULL DEFAULT '',
    `position`     VARCHAR(255)  NOT NULL DEFAULT '',
    `position_fa`  VARCHAR(255)  NOT NULL DEFAULT '',
    `field`        VARCHAR(255)  NOT NULL DEFAULT '',
    `field_fa`     VARCHAR(255)  NOT NULL DEFAULT '',
    `email`        VARCHAR(255)  NOT NULL DEFAULT '',
    `scholar_link` VARCHAR(500)  NOT NULL DEFAULT '',
    `linkedin`     VARCHAR(500)  NOT NULL DEFAULT '',
    `bio`          TEXT,
    `bio_fa`       TEXT,
    `image`        VARCHAR(255)           DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `professor` (`id`, `name`, `name_fa`, `position`, `position_fa`, `field`, `field_fa`, `email`, `scholar_link`, `linkedin`, `bio`, `bio_fa`, `image`) VALUES
(1, 'Dr. Abdolah Chalechale', 'دکتر عبدالله چاله چاله', 'Associate Professor / Department of Computer Engineering & IT', 'دانشیار گروه مهندسی کامپیوتر و فناوری اطلاعات', 'Artificial Intelligence, Image Processing, Deep Learning, Multimodal NLP, Distributed Systems', 'هوش مصنوعی، پردازش تصویر، یادگیری عمیق، پردازش زبان طبیعی و سیستم‌های توزیع‌شده', 'chalechale@razi.ac.ir', 'https://scholar.google.com/citations?user=ARw4FiUAAAAJ&hl=en', '', 'PhD: University of Wollongong, Australia (Computer Engineering - Artificial Intelligence, 2001-2005)\nMSc: Sharif University of Technology (Software Engineering, 1996-1998)\nBSc: Sharif University of Technology (Computer Engineering - Hardware, 1991-1995)', 'دکتری: دانشگاه ولونگونگ استرالیا (مهندسی کامپیوتر - هوش مصنوعی)\nکارشناسی ارشد: دانشگاه صنعتی شریف (مهندسی نرم‌افزار)\nکارشناسی: دانشگاه صنعتی شریف (مهندسی سخت‌افزار)', '1773629261.jpg'),
(2, 'Dr. Arezo Kamran', 'دکتر آرزو کامران', 'Assistant Professor / Department of Computer Engineering & IT', 'استادیار گروه مهندسی کامپیوتر و فناوری اطلاعات', 'Computer Systems Architecture, Approximate Computing, Digital System Testing & Design, Edge AI', 'معماری سیستم‌های کامپیوتری، محاسبات تقریبی، طراحی و آزمون سیستم‌های دیجیتال، هوش مصنوعی لبه', 'Kamran@razi.ac.ir', 'https://scholar.google.com/citations?user=M_s3_SQAAAAJ&hl=en', '', 'PhD: University of Tehran (Computer Systems Architecture)\nAcademic Rank: Assistant Professor, Faculty of Engineering, Razi University.', 'دکتری: دانشگاه تهران (مهندسی کامپیوتر - گرایش معماری سیستم‌های کامپیوتری)\nمرتبه علمی: استادیار دانشکده فنی و مهندسی دانشگاه رازی', '1773630810.jpg')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `name_fa`=VALUES(`name_fa`), `position`=VALUES(`position`), `position_fa`=VALUES(`position_fa`), `field`=VALUES(`field`), `field_fa`=VALUES(`field_fa`), `bio`=VALUES(`bio`), `bio_fa`=VALUES(`bio_fa`), `image`=VALUES(`image`);

-- -------------------------------------------------------------
--  Table: students
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `students` (
    `id`                 INT               NOT NULL AUTO_INCREMENT,
    `name`               VARCHAR(255)      NOT NULL DEFAULT '',
    `full_name`          VARCHAR(255)      NOT NULL DEFAULT '',
    `full_name_fa`       VARCHAR(255)      NOT NULL DEFAULT '',
    `email`              VARCHAR(255)      NOT NULL DEFAULT '',
    `major`              VARCHAR(255)      NOT NULL DEFAULT '',
    `degree`             ENUM('MSc','PhD') NOT NULL DEFAULT 'MSc',
    `photo`              VARCHAR(255)               DEFAULT NULL,
    `status`             VARCHAR(100)      NOT NULL DEFAULT '',
    `thesis_title`       TEXT,
    `thesis_title_fa`    TEXT,
    `research_interests` TEXT,
    `contact`            VARCHAR(255)      NOT NULL DEFAULT '',
    `scholar_link`       VARCHAR(500)      NOT NULL DEFAULT '',
    `professor_id`       INT                        DEFAULT NULL,
    `graduated`          TINYINT(1)        NOT NULL DEFAULT 0,
    `graduation_year`    INT                        DEFAULT NULL,
    `current_position`   VARCHAR(255)               DEFAULT NULL,
    `created_at`         TIMESTAMP         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
--  Table: publications
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `publications` (
    `id`           INT          NOT NULL AUTO_INCREMENT,
    `title`        TEXT         NOT NULL,
    `authors`      TEXT         NOT NULL,
    `journal`      VARCHAR(500) NOT NULL DEFAULT '',
    `year`         INT          NOT NULL,
    `doi`          VARCHAR(255)          DEFAULT NULL,
    `link`         VARCHAR(500)          DEFAULT NULL,
    `pdf_file`     VARCHAR(255)          DEFAULT NULL,
    `bibtex`       TEXT                  DEFAULT NULL,
    `pub_type`     VARCHAR(100) NOT NULL DEFAULT 'Journal',
    `citations`    INT          NOT NULL DEFAULT 0,
    `professor_id` INT                   DEFAULT NULL,
    `created_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_year` (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
--  Table: projects
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `projects` (
    `id`              INT          NOT NULL AUTO_INCREMENT,
    `title`           VARCHAR(255) NOT NULL,
    `title_fa`        VARCHAR(255) NOT NULL,
    `description`     TEXT         NOT NULL,
    `description_fa`  TEXT         NOT NULL,
    `image`           VARCHAR(255)          DEFAULT NULL,
    `category`        VARCHAR(100) NOT NULL DEFAULT 'Computer Vision',
    `status`          ENUM('active','completed') NOT NULL DEFAULT 'active',
    `tech_stack`      VARCHAR(255) NOT NULL DEFAULT '',
    `lead_researcher` VARCHAR(255) NOT NULL DEFAULT '',
    `professor_id`    INT                   DEFAULT 1,
    `link`            VARCHAR(500)          DEFAULT NULL,
    `created_at`      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
--  Table: news_events
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `news_events` (
    `id`         INT          NOT NULL AUTO_INCREMENT,
    `title`      VARCHAR(255) NOT NULL,
    `title_fa`   VARCHAR(255) NOT NULL,
    `content`    TEXT         NOT NULL,
    `content_fa` TEXT         NOT NULL,
    `type`       ENUM('news','event','defense','award') NOT NULL DEFAULT 'news',
    `event_date` DATE         NOT NULL,
    `location`   VARCHAR(255)          DEFAULT NULL,
    `link`       VARCHAR(500)          DEFAULT NULL,
    `image`      VARCHAR(255)          DEFAULT NULL,
    `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
--  Table: contact_messages
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contact_messages` (
    `id`             INT          NOT NULL AUTO_INCREMENT,
    `name`           VARCHAR(255) NOT NULL,
    `email`          VARCHAR(255) NOT NULL,
    `phone`          VARCHAR(50)           DEFAULT NULL,
    `subject`        VARCHAR(255) NOT NULL,
    `message`        TEXT         NOT NULL,
    `applicant_type` VARCHAR(100) NOT NULL DEFAULT 'General Inquiry',
    `created_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
