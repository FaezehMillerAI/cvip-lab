<?php
require_once __DIR__ . "/includes/db.php";

$msg_feedback = "";
$msg_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $phone = trim($_POST["phone"] ?? '');
    $subject = trim($_POST["subject"] ?? 'Lab Application');
    $applicant_type = trim($_POST["applicant_type"] ?? 'General Inquiry');
    $message = trim($_POST["message"] ?? '');

    if (!empty($name) && !empty($email) && !empty($message)) {
        if ($conn && !$conn->connect_error) {
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, applicant_type, message) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $name, $email, $phone, $subject, $applicant_type, $message);
            if ($stmt->execute()) {
                $msg_feedback = "درخواست و پیام شما با موفقیت ثبت گردید. با تشکر از ارتباط شما با آزمایشگاه.";
                $msg_type = "success";
            } else {
                $msg_feedback = "خطا در ثبت پیام: " . $stmt->error;
                $msg_type = "error";
            }
        } else {
            $msg_feedback = "پیام شما دریافت شد (حالت آفلاین).";
            $msg_type = "success";
        }
    } else {
        $msg_feedback = "لطفاً تمامی فیلدهای الزامی را تکمیل نمایید.";
        $msg_type = "error";
    }
}

$page_title = "Contact & Admissions";
require_once __DIR__ . "/header.php";
?>

<section class="section" style="padding-top: 50px;">
    <div class="container">
        <div class="section-title-wrap">
            <span class="section-badge">Connect With Us</span>
            <h1 class="section-title"><?= $is_rtl ? 'پذیرش دانشجو و ارتباط با آزمایشگاه' : 'Join the Lab & Get in Touch' ?></h1>
            <p class="section-subtitle">
                <?= $is_rtl ? 'جهت همکاری در پروژه‌های تحقیقاتی، گذراندن دوره کارشناسی ارشد یا دکتری و فرصت‌های پژوهشی با ما در ارتباط باشید.' : 'Get in touch for MSc and PhD thesis opportunities, research collaborations, and lab visits.' ?>
            </p>
        </div>

        <?php if (!empty($msg_feedback)): ?>
        <div style="max-width: 800px; margin: 0 auto 30px auto; padding: 18px; border-radius: var(--radius-md); background: <?= $msg_type === 'success' ? 'rgba(16, 185, 129, 0.15)' : 'rgba(239, 68, 68, 0.15)' ?>; border: 1px solid <?= $msg_type === 'success' ? 'rgba(16, 185, 129, 0.4)' : 'rgba(239, 68, 68, 0.4)' ?>; color: <?= $msg_type === 'success' ? '#10b981' : '#ef4444' ?>; text-align: center; font-weight: 700;">
            <?= htmlspecialchars($msg_feedback) ?>
        </div>
        <?php endif; ?>

        <div class="contact-wrap">
            <div class="glass-card contact-info-card">
                <h2 style="font-size: 1.4rem; color: var(--text-primary); margin-bottom: 12px;">
                    🏢 <?= $is_rtl ? 'درباره ما و راه‌های ارتباطی' : 'About Us & Contacts' ?>
                </h2>

                <div class="contact-item">
                    <div class="contact-icon">🏛️</div>
                    <div>
                        <div class="contact-label"><?= $is_rtl ? 'مکان فیزیکی' : 'Location' ?></div>
                        <div class="contact-val">
                            <?= $is_rtl ? 'کرمانشاه، طاق‌بستان، دانشگاه رازی، دانشکده مهندسی، طبقه سوم، آزمایشگاه پردازش تصویر' : 'Faculty of Engineering, Department of Computer Engineering, Razi University, Kermanshah, Iran' ?>
                        </div>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">✉️</div>
                    <div>
                        <div class="contact-label"><?= $is_rtl ? 'پست الکترونیکی اساتید' : 'Faculty Emails' ?></div>
                        <div class="contact-val">
                            <a href="mailto:chalechale@razi.ac.ir" style="color: var(--accent-cyan);">chalechale@razi.ac.ir</a><br>
                            <a href="mailto:Kamran@razi.ac.ir" style="color: var(--accent-cyan);">Kamran@razi.ac.ir</a>
                        </div>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">🕒</div>
                    <div>
                        <div class="contact-label"><?= $is_rtl ? 'ساعات حضور' : 'Working Hours' ?></div>
                        <div class="contact-val"><?= $is_rtl ? 'شنبه الی چهارشنبه: ۸:۰۰ صبح الی ۱۶:۰۰ بعدازظهر' : 'Sat - Wed: 8:00 AM - 4:00 PM' ?></div>
                    </div>
                </div>

                <div style="margin-top: 10px; padding-top: 20px; border-top: 1px solid var(--border-color);">
                    <h4 style="font-size: 1rem; color: var(--text-primary); margin-bottom: 8px;">
                        💡 <?= $is_rtl ? 'شرایط پذیرش دانشجویان' : 'Admissions Criteria' ?>
                    </h4>
                    <p style="font-size: 0.88rem; color: var(--text-secondary); line-height: 1.6;">
                        <?= $is_rtl 
                            ? 'تسلط به مبانی پایتون، فریم‌ورک‌های یادگیری عمیق (PyTorch / TensorFlow)، ریاضیات مهندسی و اشتیاق به پژوهش در زمینه پردازش تصویر و هوش مصنوعی.' 
                            : 'Solid background in Python, Deep Learning frameworks (PyTorch/TensorFlow), linear algebra, and genuine passion for visual AI research.' ?>
                    </p>
                </div>
            </div>

            <!-- Form -->
            <div class="glass-card contact-form">
                <h2 style="font-size: 1.4rem; color: var(--text-primary); margin-bottom: 18px;">
                    📝 <?= $is_rtl ? 'فرم ارسال درخواست پژوهشی' : 'Research Application Form' ?>
                </h2>

                <form method="POST">
                    <div class="form-group">
                        <label class="form-label"><?= $is_rtl ? 'نام و نام خانوادگی' : 'Full Name' ?> *</label>
                        <input type="text" name="name" class="form-control" placeholder="<?= $is_rtl ? 'نام کامل خود را وارد کنید' : 'Enter your full name' ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= $is_rtl ? 'آدرس ایمیل' : 'Email Address' ?> *</label>
                        <input type="email" name="email" class="form-control" placeholder="example@razi.ac.ir" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= $is_rtl ? 'شماره تماس' : 'Phone Number' ?></label>
                        <input type="text" name="phone" class="form-control" placeholder="0912...">
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= $is_rtl ? 'نوع درخواست' : 'Application Purpose' ?> *</label>
                        <select name="applicant_type" class="form-control">
                            <option value="MSc Research"><?= $is_rtl ? 'درخواست پایان‌نامه کارشناسی ارشد' : 'MSc Thesis Supervision' ?></option>
                            <option value="PhD Research"><?= $is_rtl ? 'درخواست رساله دکتری تخصصی' : 'PhD Dissertation Supervision' ?></option>
                            <option value="Research Assistant"><?= $is_rtl ? 'همکاری به عنوان دستیار پژوهشی' : 'Research Assistantship' ?></option>
                            <option value="Industrial Collaboration"><?= $is_rtl ? 'همکاری صنعتی و پروژه‌های کاربردی' : 'Industrial Collaboration' ?></option>
                            <option value="General"><?= $is_rtl ? 'ارتباط عمومی' : 'General Inquiry' ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= $is_rtl ? 'متن پیام، سوابق و مهارت‌ها' : 'Message & Background' ?> *</label>
                        <textarea name="message" class="form-control" rows="5" placeholder="<?= $is_rtl ? 'معدل، دانشگاه مقطع قبلی، مهارت‌های برنامه‌نویسی و موضوعات مورد علاقه...' : 'Briefly describe your GPA, previous university, programming skills, and research areas...' ?>" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        🚀 <?= $is_rtl ? 'ارسال درخواست' : 'Submit Application' ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/footer.php"; ?>
