# 🔬 آزمایشگاه پردازش تصویر و بینایی ماشین دانشگاه رازی
### Computer Vision & Image Processing (CVIP) Research Laboratory | Razi University

پرتال جامع، مدرن و دوزبانه آزمایشگاه پردازش تصویر و بینایی ماشین دانشگاه رازی با طراحی فوق‌العاده شکیل (Glassmorphism)، انیمیشن تعاملی Neural Vision، پشتیبانی از دو زبان فارسی و انگلیسی و حالت تاریک و روشن (Dark / Light Mode).

---

## 🌟 ویژگی‌ها و صفحات وب‌سایت (Website Features)

1. 🏠 **صفحه اصلی (Home - `index.html`)**: بنر هیرو تعاملی به همراه انیمیشن کانواس پردازش تصویر و شمارنده‌های زنده دستاوردها.
2. 👨‍🏫 **اساتید راهنما (Faculty - `faculty.html`)**: پروفایل تفصیلی **دکتر عبدالله چاله چاله** و **دکتر آرزو کامران**.
3. 🔬 **حوزه‌های پژوهشی (Research - `research.html`)**: معرفی ۶ محور تخصصی آزمایشگاه (هوش مصنوعی پزشکی، مدل‌های چندوجهی VLM، بینایی خودروهای خودران، مرمت بناهای تاریخی، محاسبات تقریبی و شتاب‌دهنده‌های FPGA).
4. 👥 **اعضای آزمایشگاه (Team - `team.html`)**: دایرکتوری ۳۵+ پژوهشگر با فیلتر تب‌ها (دکتری، ارشد، فارغ‌التحصیلان) و جستجوی لحظه‌ای.
5. 🚀 **پروژه‌ها (Projects - `projects.html`)**: پروژه‌های تحقیقاتی جاری و تکمیل‌شده.
6. 📚 **مقالات علمی (Publications - `publications.html`)**: مقالات چاپ شده با لینک DOI و کپی استناد BibTeX.
7. 📰 **اخبار و رویدادها (News - `news.html`)**: اطلاعیه‌های زمان دفاع پایان‌نامه‌ها و رویدادها.
8. 🏢 **درباره ما و تماس (Contact - `contact.html`)**: معرفی تجهیزات GPU، نشانی و فرم درخواست همکاری.

---

## 🚀 راه‌اندازی و انتشار رایگان روی گیت‌هاب (GitHub Pages)

برای استقرار و دریافت لینک عمومی آنلاین:

1. وارد اکانت **[GitHub](https://github.com)** خود شوید.
2. یک مخزن جدید (New Repository) با نام دلخواه (مثلاً `image-lab-portal`) بسازید.
3. فایل‌های این پروژه را پوش (Push) کنید:
   ```bash
   git init
   git add .
   git commit -m "Deploy CVIP Research Lab Portal"
   git branch -M main
   git remote add origin https://github.com/<YOUR_USERNAME>/<REPO_NAME>.git
   git push -u origin main
   ```
4. در صفحه ریپازیتوری، وارد تب **Settings** شده و از منوی سمت چپ روی **Pages** کلیک کنید.
5. در بخش **Build and deployment**، گزینه **Source** را روی `Deploy from a branch` بگذارید و شاخه `main` / `root` را انتخاب و **Save** کنید.
6. پس از ۱ دقیقه، لینک آنلاین وب‌سایت شما آماده خواهد بود:
   ```text
   https://<YOUR_USERNAME>.github.io/<REPO_NAME>/
   ```

---

## 💻 اجرای نسخه کامل با پایگاه داده PHP/MySQL (Localhost)

برای اجرای نسخه متصل به پایگاه‌داده داینامیک:
1. پوشه پروژه را در مسیر وب‌سرور خود (مانند `htdocs` در زمپ) کپی کنید.
2. فایل `image_lab.sql` را در دیتابیس `image_lab` در phpMyAdmin ایمپورت کنید.
3. آدرس `http://localhost/research_portal/public_page.php` را در مرورگر باز نمایید.
4. ورود به پنل مدیریت: `http://localhost/research_portal/admin/login.php` (کاربر: `admin` | رمز: `admin123`).
