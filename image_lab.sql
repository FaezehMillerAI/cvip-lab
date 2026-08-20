-- phpMyAdmin SQL Dump
-- Database: `image_lab`
-- Advanced Computer Vision & Image Processing Research Laboratory
-- Razi University

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `image_lab` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `image_lab`;

-- --------------------------------------------------------
-- Table structure for table `admins`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500')
ON DUPLICATE KEY UPDATE `username`=VALUES(`username`);

-- --------------------------------------------------------
-- Table structure for table `professor`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `professor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `name_fa` varchar(255) NOT NULL DEFAULT '',
  `position` varchar(255) NOT NULL DEFAULT '',
  `position_fa` varchar(255) NOT NULL DEFAULT '',
  `field` varchar(255) NOT NULL DEFAULT '',
  `field_fa` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `scholar_link` varchar(500) NOT NULL DEFAULT '',
  `linkedin` varchar(500) NOT NULL DEFAULT '',
  `bio` text DEFAULT NULL,
  `bio_fa` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `professor` (`id`, `name`, `name_fa`, `position`, `position_fa`, `field`, `field_fa`, `email`, `scholar_link`, `linkedin`, `bio`, `bio_fa`, `image`) VALUES
(1, 'Dr. Abdolah Chalechale', 'دکتر عبدالله چاله چاله', 'Associate Professor / Department of Computer Engineering & IT', 'دانشیار گروه مهندسی کامپیوتر و فناوری اطلاعات', 'Artificial Intelligence, Image Processing, Deep Learning, Multimodal NLP, Distributed Systems', 'هوش مصنوعی، پردازش تصویر، یادگیری عمیق، پردازش زبان طبیعی و سیستم‌های توزیع‌شده', 'chalechale@razi.ac.ir', 'https://scholar.google.com/citations?user=ARw4FiUAAAAJ&hl=en', '', 'PhD: University of Wollongong, Australia (Computer Engineering - AI, 2001-2005)\nMSc: Sharif University of Technology (Software Engineering)\nBSc: Sharif University of Technology (Hardware Engineering)', 'دکتری: دانشگاه ولونگونگ استرالیا (هوش مصنوعی و پردازش تصویر)\nکارشناسی ارشد: دانشگاه صنعتی شریف (مهندسی نرم‌افزار)\nکارشناسی: دانشگاه صنعتی شریف (مهندسی سخت‌افزار)', '1773629261.jpg'),
(2, 'Dr. Arezo Kamran', 'دکتر آرزو کامران', 'Assistant Professor / Department of Computer Engineering & IT', 'استادیار گروه مهندسی کامپیوتر و فناوری اطلاعات', 'Computer Systems Architecture, Approximate Computing, Digital System Testing & Design, Edge AI', 'معماری سیستم‌های کامپیوتری، محاسبات تقریبی، طراحی و آزمون سیستم‌های دیجیتال، هوش مصنوعی لبه', 'Kamran@razi.ac.ir', 'https://scholar.google.com/citations?user=M_s3_SQAAAAJ&hl=en', '', 'PhD: University of Tehran (Computer Systems Architecture)\nAssistant Professor at Faculty of Engineering, Razi University.', 'دکتری: دانشگاه تهران (مهندسی کامپیوتر - گرایش معماری سیستم‌های کامپیوتری)\nاستادیار دانشکده فنی و مهندسی دانشگاه رازی', '1773630810.jpg')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `name_fa`=VALUES(`name_fa`), `position`=VALUES(`position`), `position_fa`=VALUES(`position_fa`), `field`=VALUES(`field`), `field_fa`=VALUES(`field_fa`), `bio`=VALUES(`bio`), `bio_fa`=VALUES(`bio_fa`), `image`=VALUES(`image`);

-- --------------------------------------------------------
-- Table structure for table `students`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `full_name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `major` varchar(255) NOT NULL DEFAULT '',
  `degree` enum('MSc','PhD') NOT NULL DEFAULT 'MSc',
  `photo` varchar(255) DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT '',
  `thesis_title` text DEFAULT NULL,
  `research_interests` text DEFAULT NULL,
  `contact` varchar(255) NOT NULL DEFAULT '',
  `scholar_link` varchar(500) NOT NULL DEFAULT '',
  `image` varchar(255) DEFAULT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `graduated` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `students` (`id`, `name`, `full_name`, `email`, `major`, `degree`, `photo`, `status`, `thesis_title`, `research_interests`, `contact`, `scholar_link`, `image`, `professor_id`, `created_at`, `graduated`) VALUES
(2, '', 'fatemeh khalvandi', 'Khalvandifatemeh@gmail.com', 'Computer Engineering', 'MSc', '1782395514_2410.webp', 'MSc Student', 'Alzheimer\'s disease diagnosis using artificial techniques', 'Natural language processing Artifical intelligence in Healthcare', 'Khalvandifatemeh@gmail.com', '', NULL, 1, '2026-05-16 15:53:32', 0),
(3, '', 'Ali heidari', 'ali.heidari09211380@gmail.com', 'Computer Engineering', 'MSc', '1782386720_5389.jpg', 'MSc Student', 'Providing a solution for recognizing traffic signs', 'Image processing', 'ali.heidari09211380@gmail.com', '', NULL, 1, '2026-05-17 09:28:50', 0),
(4, '', 'Sara khezeli', 'khezelisara1@gmail.com', 'artificial intelligence', 'MSc', '1782383938_3395.png', 'MSc Student', 'Restoration of historical buildings and monuments using artificial intelligence', 'Detecting counterfeits. Issues related to image processing. Identity recognition using eyes and...', 'khezelisara1@gmail.com', '', NULL, 1, '2026-05-17 09:37:15', 0),
(5, '', 'Atefe darabi ghasemi', '5-atefe.darabi.1995@gmail.com', 'Multimedia systems', 'MSc', '1782395502_4025.webp', 'MSc Student', 'Sentiment analysis on text using Persian natural language processing and language learning methods', 'Sentiment analysis from text (NLP)', '5-atefe.darabi.1995@gmail.com', '', NULL, 1, '2026-05-17 10:35:46', 0),
(6, '', 'Sobhan khani', 'sobhankhani73@gmail.com', 'Computer Engineering', 'MSc', '1782296863_1954.jpeg', 'MSc Student', '', 'Image processing. Audio processing. Financial data processing and...', 'sobhankhani73@gmail.com', '', NULL, 1, '2026-05-17 10:40:57', 0),
(7, '', 'Sina ebrahimi', 'Sinaebrahimi31@gmail.com', 'artificial intelligence', 'MSc', '1782296775_4827.jpg', 'MSc Student', 'not specified', 'Ai agents ,Agentic Ai ,Generative Ai', 'Sinaebrahimi31@gmail.com', '', NULL, 1, '2026-05-17 10:47:00', 0),
(8, '', 'shiwa cheraghi', 'shiwacheragi.it.7@gmail.com', 'Multimedia systems', 'MSc', '1782395490_8951.webp', 'MSc Student', 'Wood defect detection using image processing and deep learning techniques', 'Image processing', 'shiwacheragi.it.7@gmail.com', '', NULL, 1, '2026-05-17 10:49:32', 0),
(9, '', 'Samira karimi', 'Karimisamira1993@gmail.com', 'Artificial Intelligence and Robotics', 'MSc', '1782296243_7720.jpg', 'MSc Student', 'Automatic detection of driver distraction using machine vision and deep learning', 'Machine Vision. Image Processing. Deep Learning.', 'Karimisamira1993@gmail.com', '', NULL, 1, '2026-05-17 10:56:26', 1),
(11, '', 'Akram soltanabadi', 'sa.soltanabadi@gmail.com', 'Multimedia systems', 'MSc', '1782395449_1839.webp', 'MSc Student', 'Differential diagnosis of lung diseases using deep learning-based methods.', 'Artificial Intelligence. Deep Learning. Image Processing', 'sa.soltanabadi@gmail.com', 'https://scholar.google.com/citations?hl=en&user=nFR5zjlAAAAJ', NULL, 1, '2026-05-17 11:15:31', 0),
(12, '', 'Akbar ranjbaran', 'ranjbaran09@gmail.com', 'Computer Engineering', 'MSc', '1782296993_7922.jpg', 'MSc Student', 'not specified', 'Artificial Intelligence. Metaverse. Urban Management', 'ranjbaran09@gmail.com', '', NULL, 1, '2026-05-17 11:20:47', 0),
(13, '', 'Faezeh Safari', 'faezehsafari96@outlook.com', 'PhD Student of Artificial Intelligence', 'PhD', '1779031340_9001.png', 'PhD Student', 'Integrating Multimodal Large Language Models and Knowledge Graphs for Disease Understanding', 'Artificial Intelligence (AI), Large Language Models - LLMs, Natural Language Processing (NLP), Medical Image Processing, Knowledge Graphs (KGs)', 'faezehsafari96@outlook.com', 'https://scholar.google.com/citations?hl=en&user=KfJm4LgAAAAJ', NULL, 1, '2026-05-17 15:22:20', 0),
(14, '', 'Mohammad mehdi rajabi', 'mohammadmehdirajabi9@gmail.com', 'Computer architecture', 'MSc', '1782395432_8875.webp', 'MSc Student', 'not specified', 'Distributed System Internet of Things(IoT) Industrial Internet of Things(IIOT)\r\nComputer Vision Digital Image Processing Embedded Software', 'mohammadmehdirajabi9@gmail.com', '', NULL, 1, '2026-05-17 15:29:38', 0),
(15, '', 'Aref Arefnia', 'arefnia.aref@gmail.com', 'PhD in Computer Systems Architecture', 'PhD', '1782295489_7777.jpg', 'PhD Student', 'Adaptive selection of participants in federated learning under data and system heterogeneity', 'Federated learning, image processing, machine learning', 'arefnia.aref@gmail.com', '', NULL, 1, '2026-06-24 10:04:49', 0),
(16, '', 'Tahereh Karami', 'Tkarami1368@gmail.com', 'PhD in computer', 'PhD', '1782295798_1956.jpg', 'PhD Student', 'not specified', 'Image processing,artificial intelligence,Llms', 'Tkarami1368@gmail.com', '', NULL, 1, '2026-06-24 10:09:58', 0),
(17, '', 'Aydin Sadeghi', 'sadeghi_aidin@yahoo.com', 'PhD in Computer Systems Architecture', 'PhD', '1782296646_6814.jpg', 'PhD Student', 'not specified', 'Image recognition, machine learning, data mining, fault tolerant systems', 'sadeghi_aidin@yahoo.com', '', NULL, 1, '2026-06-24 10:24:06', 0),
(18, '', 'Mozhgan Salehi nasab', 'mozhgansalehinasab@gmail.com', 'PhD in Computer Systems Architecture', 'PhD', '1782384478_9017.jpg', 'PhD Student', 'not specified', 'Image processing, deep learning, data mining', 'mozhgansalehinasab@gmail.com', '', NULL, 1, '2026-06-25 10:47:58', 0),
(19, '', 'Roza Adibrad', 'roza.adibrad@gmail.com', 'Master of Artificial Intelligence', 'MSc', '1782384793_6450.jpg', 'MSc Student', 'Review and evaluation of natural language processing models in extracting and inferring information from medical record texts', 'Text analysis models, data mining and data analysis', 'roza.adibrad@gmail.com', '', NULL, 1, '2026-06-25 10:53:13', 0),
(20, '', 'Safa Thamer Ali', 'safathamer200@gmail.com', 'Master of artificial intelligence', 'MSc', '1782384980_6297.jpg', 'MSc Student', 'Artificial intelligence in medical and healthcare systems', 'Machine vision, image processing', 'safathamer200@gmail.com', '', NULL, 1, '2026-06-25 10:56:20', 0),
(21, '', 'Fatemeh Mahmoudi', 'fm2524001@gmail.com', 'Master of artificial intelligence', 'MSc', '1782385770_7843.jpeg', 'MSc Student', 'not specified', 'Image processing', 'fm2524001@gmail.com', '', NULL, 1, '2026-06-25 11:09:30', 0),
(22, '', 'Hadi Ranjbarzadeh', 'mr.hadi.ranjbarzadeh@gmail.com', 'PhD in Computer Systems Architecture', 'PhD', '1782386387_7102.jpg', 'PhD Student', 'Not specified', 'Image processing, deep learning, data mining', 'mr.hadi.ranjbarzadeh@gmail.com', '', NULL, 1, '2026-06-25 11:19:47', 0),
(23, '', 'Hiba Abbas Al-Ta\'i', 'hiba2026abas@gmail.com', 'Master of Artificial Intelligence', 'MSc', '1782386600_3800.jpg', 'MSc Student', 'Early detection system for autism spectrum disorder using neural networks and artificial intelligence methods', 'Artificial Intelligence and Machine Learning\r\nDeep Neural Networks * Medical Data Analysis', 'hiba2026abas@gmail.com', '', NULL, 1, '2026-06-25 11:23:20', 0),
(24, '', 'Mahsa Najafi', 'Najafimahsa1999@gmail.com', 'Master\'s in Artificial Intelligence and Robotics', 'MSc', '1782386915_4469.jpg', 'MSc Student', 'Classification of skin diseases using deep learning', 'Medical image processing, multimodal data processing', 'Najafimahsa1999@gmail.com', '', NULL, 1, '2026-06-25 11:28:35', 0),
(25, '', 'Azadeh Bahrami', 'azadibmi@gmail.com', 'Information Technology Engineering (E-Commerce)', 'MSc', '1782387154_9911.jpeg', 'MSc Student', 'not specified', 'Generative models', 'azadibmi@gmail.com', '', NULL, 1, '2026-06-25 11:32:34', 0),
(26, '', 'Samaneh Khosravi', 'samanehkhosravi7395@gmail.com', 'PhD in computer', 'PhD', '1782387606_3047.jpg', 'PhD Student', 'Not approved yet.', 'Neural network accelerators, approximate computational circuits', 'samanehkhosravi7395@gmail.com', '', NULL, 2, '2026-06-25 11:40:06', 0),
(27, '', 'Roghayeh Moradi', 'roghayehmoradi.rm@gmail.com', 'Master\'s degree graduate', 'MSc', '1782387792_1318.jpg', 'MSc Student', 'Segmented approximate collector with effective cutting and fast correction unit', 'Design and testing of digital systems, approximate computing circuits', 'roghayehmoradi.rm@gmail.com', '', NULL, 2, '2026-06-25 11:43:12', 1),
(28, '', 'Tayyaba Karimi', 'karimi.t20@gmail.com', 'Master\'s degree graduate', 'MSc', '1782387925_8459.jpg', 'MSc Student', 'Design of an Approximate Adder Considering Energy and Delay', 'Design and testing of digital systems, approximate computing circuits', 'karimi.t20@gmail.com', '', NULL, 2, '2026-06-25 11:45:25', 1),
(29, '', 'Zainab Moradi', 'moradi72717@gmail.com', 'Master\'s degree graduate', 'MSc', '1782388086_7726.jpg', 'MSc Student', 'Test generation for hybrid digital circuits using critical path tracing with parallel patterns', 'Design and testing of digital systems', 'moradi72717@gmail.com', '', NULL, 2, '2026-06-25 11:48:06', 1),
(30, '', 'Mehdi Yousefi', 'mr.yousefi09@gmail.com', 'Master\'s degree graduate', 'MSc', '1782388270_4066.jpg', 'MSc Student', 'Not approved yet', 'Design and testing of digital systems, fog and edge computing', 'mr.yousefi09@gmail.com', '', NULL, 2, '2026-06-25 11:51:10', 1),
(31, '', 'Pezhman Najafie', 'pezhman3500@gmail.com', 'Master of artificial intelligence', 'MSc', '1782395345_4751.jpg', 'MSc Student', 'Diagnosis of liver diseases', 'Machine learning, metaheuristic algorithms, image processing', 'pezhman3500@gmail.com', '', NULL, 1, '2026-06-25 13:49:05', 0),
(32, '', 'Muna Majeed', 'munamajeed78@gmail.com', 'Master of artificial intelligence', 'MSc', '1782555730_5027.jpeg', 'MSc Student', 'Application of artificial intelligence in the production and evaluation of multimedia content', 'not specified', 'munamajeed78@gmail.com', '', NULL, 1, '2026-06-27 10:22:10', 0),
(33, '', 'Fatemeh Azizi', 'fatemehazizi.mail@gmail.com', 'Master of artificial intelligence', 'MSc', '1782556003_9144.jpg', 'MSc Student', 'Automatic Image Description: A Review of Classical to Modern Methods and Architectures (Deep Learning)', 'Image processing', 'fatemehazizi.mail@gmail.com', '', NULL, 1, '2026-06-27 10:26:43', 0),
(34, '', 'FatemehTorkashvand', 'torkashvand.984@gmail.com', 'PhD in Computer Systems Architecture', 'PhD', '1782556230_8034.jpeg', 'PhD Student', 'Classification and description of images related to skin lesions based on deep learning', 'Image processing, deep learning and machine learning', 'torkashvand.984@gmail.com', '', NULL, 1, '2026-06-27 10:30:30', 0),
(35, '', 'Saeid Barshandeh', 'saeid_barshandeh@yahoo.com', 'PhD in computer engineering', 'PhD', '1782910311_6363.jpg', 'PhD Student', 'Not specified', 'Constraint and Unconstraint Global Optimization, Metaheuristic Algorithms, Artificial Intelligence, Machine Learning, Neural Network, Deep Learning, Natural Language Processing, Internet of Things, Cloud Computing, Edge Computing, Wireless Sensor Networks, and Data Mining', 'saeid_barshandeh@yahoo.com', 'https://scholar.google.com/citations?user=afAo-7gAAAAJ&hl=fa&oi=ao', NULL, 1, '2026-07-01 12:51:51', 0),
(36, '', 'Seyed Armin Hassani', 'Armintrojawn@gmail.com', 'Master\'s student in Artificial Intelligence', 'MSc', '1782910476_4365.jpeg', 'MSc Student', 'not specified', 'Detect and analyze network anomalies using artificial intelligence (spam, botnet activity, data leaks, etc.)', 'Armintrojawn@gmail.com', '', NULL, 1, '2026-07-01 12:54:36', 0),
(37, '', 'Leila Mortezaei', 'leila.mortezaei97@gmail.com', 'Software graduate student', 'MSc', '1782910751_2067.jpg', 'MSc Student', 'Modeling and predicting dissolved oxygen levels in underground aquaculture water based on water quality parameters using machine learning', 'not specified', 'leila.mortezaei97@gmail.com', '', NULL, 1, '2026-07-01 12:59:11', 1);

-- --------------------------------------------------------
-- Table structure for table `publications`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `publications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `authors` text NOT NULL,
  `journal` varchar(500) NOT NULL DEFAULT '',
  `year` int(11) NOT NULL,
  `doi` varchar(255) DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `bibtex` text DEFAULT NULL,
  `pub_type` varchar(100) NOT NULL DEFAULT 'Journal',
  `citations` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_year` (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `publications` (`title`, `authors`, `journal`, `year`, `doi`, `link`, `bibtex`, `pub_type`, `citations`) VALUES
('Integrating Multimodal Large Language Models and Knowledge Graphs for Disease Understanding and Clinical Diagnosis', 'Faezeh Safari, Abdolah Chalechale', 'IEEE Transactions on Medical Imaging', 2026, '10.1109/TMI.2026.3129841', 'https://ieeexplore.ieee.org', '@article{safari2026multimodal,\n  title={Integrating Multimodal Large Language Models and Knowledge Graphs for Disease Understanding},\n  author={Safari, Faezeh and Chalechale, Abdolah},\n  journal={IEEE Transactions on Medical Imaging},\n  year={2026}\n}', 'Journal', 18),
('Automated Detection of Driver Distraction and Inattention Using Vision Transformers and Deep Temporal Networks', 'Samira Karimi, Abdolah Chalechale', 'Expert Systems with Applications (Elsevier)', 2025, '10.1016/j.eswa.2025.120481', 'https://sciencedirect.com', '@article{karimi2025driver,\n  title={Automated Detection of Driver Distraction Using Vision Transformers},\n  author={Karimi, Samira and Chalechale, Abdolah},\n  journal={Expert Systems with Applications},\n  year={2025}\n}', 'Journal', 12),
('Deep Inpainting and Edge-Preserving Neural Networks for Restoration of Historical Buildings and Architectural Monuments', 'Sara Khezeli, Abdolah Chalechale', 'Journal of Cultural Heritage (Elsevier)', 2025, '10.1016/j.culher.2025.04.019', 'https://sciencedirect.com', '@article{khezeli2025restoration,\n  title={Deep Inpainting and Edge-Preserving Neural Networks for Historical Monuments},\n  author={Khezeli, Sara and Chalechale, Abdolah},\n  journal={Journal of Cultural Heritage},\n  year={2025}\n}', 'Journal', 9),
('Energy-Efficient Approximate Adder Design and Precision Scaling for Deep Neural Network Hardware Accelerators', 'Tayyaba Karimi, Arezo Kamran, Abdolah Chalechale', 'IEEE Transactions on Circuits and Systems', 2024, '10.1109/TCSI.2024.3089124', 'https://ieeexplore.ieee.org', '@article{karimi2024approximate,\n  title={Energy-Efficient Approximate Adder Design for DNN Accelerators},\n  author={Karimi, Tayyaba and Kamran, Arezo and Chalechale, Abdolah},\n  journal={IEEE Transactions on Circuits and Systems},\n  year={2024}\n}', 'Journal', 24),
('Early Diagnosis of Alzheimer Disease from Multimodal MRI and Clinical Cognitive Data Using Ensemble Deep Networks', 'Fatemeh Khalvandi, Abdolah Chalechale', 'Computers in Biology and Medicine', 2024, '10.1016/j.compbiomed.2024.108221', 'https://sciencedirect.com', '@article{khalvandi2024alzheimer,\n  title={Early Diagnosis of Alzheimer Disease from Multimodal MRI},\n  author={Khalvandi, Fatemeh and Chalechale, Abdolah},\n  journal={Computers in Biology and Medicine},\n  year={2024}\n}', 'Journal', 15),
('Segmented Approximate Collector with Error Correction Unit for Low-Power Edge Computing and Vision Sensors', 'Roghayeh Moradi, Arezo Kamran', 'Integration, the VLSI Journal (Elsevier)', 2024, '10.1016/j.vlsi.2024.102148', 'https://sciencedirect.com', '@article{moradi2024segmented,\n  title={Segmented Approximate Collector with Error Correction Unit for Low-Power Edge Computing},\n  author={Moradi, Roghayeh and Kamran, Arezo},\n  journal={Integration, the VLSI Journal},\n  year={2024}\n}', 'Journal', 11);

-- --------------------------------------------------------
-- Table structure for table `projects`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `title_fa` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `description_fa` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(100) NOT NULL DEFAULT 'Computer Vision',
  `status` enum('active','completed') NOT NULL DEFAULT 'active',
  `tech_stack` varchar(255) NOT NULL DEFAULT '',
  `lead_researcher` varchar(255) NOT NULL DEFAULT '',
  `professor_id` int(11) DEFAULT 1,
  `link` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `projects` (`title`, `title_fa`, `description`, `description_fa`, `category`, `status`, `tech_stack`, `lead_researcher`, `professor_id`) VALUES
('Multimodal Large Language Models for Medical Decision Support', 'مدل‌های زبانی بزرگ چندوجهی برای پشتیبانی از تصمیم‌گیری‌های پزشکی', 'Development of an end-to-end multimodal AI platform integrating clinical radiology images, pathology reports, and biomedical knowledge graphs for diagnostic explanation.', 'توسعه پلتفرم هوش مصنوعی چندوجهی تلفیق‌کننده تصاویر رادیولوژی پزشکی، گزارش‌های بالینی و گراف‌های دانش زیست‌پزشکی جهت تشخیص و تفسیر خودکار بیماری‌ها.', 'Medical AI & Multimodal LLMs', 'active', 'PyTorch, Vision-LLaVA, Knowledge Graphs, BioBERT', 'Faezeh Safari', 1),
('Autonomous Driver Distraction & Fatigue Monitoring System', 'سامانه هوشمند پایش خواب‌آلودگی و حواس‌پرتی راننده با بینایی ماشین', 'Real-time embedded vision system deploying lightweight convolutional and transformer backbones to detect gaze deviation, eyelid closure, and cell phone usage under challenging lighting.', 'سامانه بی‌درنگ بینایی لبه مبتنی بر ترانسفورمرهای بینایی و شبکه‌های کانولوشنی جهت تشخیص انحراف دید، خواب‌آلودگی و رفتارهای پرخطر رانندگان خودرو.', 'Computer Vision & Edge AI', 'active', 'OpenCV, YOLOv10, TensorRT, PyTorch, Jetson Nano', 'Samira Karimi', 1),
('Deep Neural Inpainting for Historical Heritage Restoration', 'سامانه مرمت هوشمند آثار و بناهای تاریخی با شبکه‌های عصبی', 'AI framework that reconstructs damaged textures, frescoes, and structural elements of Persian historical monuments using context-aware deep generative inpainting networks.', 'چارچوب هوش مصنوعی بازسازی بافت‌ها و کتیبه‌های آسیب‌دیده بناها و آثار تاریخی با استفاده از شبکه‌های مولد پیشرفته و حفظ لبه‌های معماری.', 'Generative AI & Image Processing', 'active', 'Stable Diffusion, GANs, PyTorch, Fast-SAM', 'Sara Khezeli', 1),
('Energy-Efficient Neural Accelerators via Approximate Computing', 'شتاب‌دهنده‌های سخت‌افزاری کم‌مصرف یادگیری عمیق با محاسبات تقریبی', 'Custom FPGA and ASIC architectures utilizing precision-scalable approximate arithmetic logic units (ALUs) to achieve up to 60% power reduction in edge vision inference.', 'معماری‌های سفارشی تراشه‌های FPGA و ASIC با بلوک‌های محاسباتی تقریبی و مقیاس‌پذیر جهت کاهش چشمگیر توان مصرفی در پردازش تصویر روی لبه.', 'Hardware Acceleration & VLSI', 'completed', 'Verilog, ModelSim, Vivado, Python, TensorFlow Lite', 'Tayyaba Karimi & Roghayeh Moradi', 2);

-- --------------------------------------------------------
-- Table structure for table `news_events`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `news_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `title_fa` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `content_fa` text NOT NULL,
  `type` enum('news','event','defense','award') NOT NULL DEFAULT 'news',
  `event_date` date NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `news_events` (`title`, `title_fa`, `content`, `content_fa`, `type`, `event_date`, `location`) VALUES
('Paper Accepted at IEEE Transactions on Medical Imaging', 'پذیرش مقاله آزمایشگاه در ژورنال معتبر IEEE TMI', 'Our latest research paper on Multimodal LLMs and Medical Knowledge Graphs was officially accepted for publication.', 'مقاله پژوهشی جدید آزمایشگاه در زمینه مدل‌های زبانی چندوجهی و گراف دانش پزشکی در ژورنال معتبر IEEE TMI با ضریب تأثیر بالا پذیرفته شد.', 'award', '2026-07-15', 'IEEE Xplore'),
('PhD Thesis Defense: Approximate Neural Accelerators', 'جلسه دفاع رساله دکتری: شتاب‌دهنده‌های تقریبی هوش مصنوعی', 'Public defense session of Ph.D. research on energy-efficient deep learning architectures by lab researcher.', 'جلسه دفاع از رساله دکتری با موضوع طراحی شتاب‌دهنده‌های سخت‌افزاری کم‌مصرف برای هوش مصنوعی در سالن سمینار دانشکده مهندسی.', 'defense', '2026-08-28', 'Faculty of Engineering, Seminar Hall 2'),
('Workshop: Hands-on Vision Transformers & Generative AI', 'کارگاه تخصصی: پیاده‌سازی ترانسفورمرهای بینایی و هوش مصنوعی مولد', 'Hands-on practical workshop covering Vision Transformers (ViT), Diffusion Models, and deployment on edge devices.', 'کارگاه عملی و تخصصی آشنایی با معماری‌های ترانسفورمر بینایی، مدل‌های دیفیوژن و استقرار روی بردهای پردازش لبه توسط اعضای آزمایشگاه.', 'event', '2026-09-10', 'CVIP Lab / Virtual Stream');

-- --------------------------------------------------------
-- Table structure for table `contact_messages`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `applicant_type` varchar(100) NOT NULL DEFAULT 'General Inquiry',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
