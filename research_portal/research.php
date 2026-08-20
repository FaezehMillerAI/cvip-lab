<?php
require_once __DIR__ . "/includes/db.php";

$page_title = "Research Domains & Innovation";
require_once __DIR__ . "/header.php";
?>

<!-- Page Header -->
<div class="page-header" style="padding: 130px 0 50px 0; background: var(--gradient-hero); text-align: center; border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <span class="section-badge">Core Research Pillars</span>
        <h1 class="hero-title" style="font-size: 2.3rem; margin-bottom: 12px;">
            <?= $is_rtl ? 'محورهای پژوهشی و نوآوری‌های علمی' : 'Research Domains & Scientific Innovation' ?>
        </h1>
        <p class="hero-desc" style="max-width: 750px; margin: 0 auto;">
            <?= $is_rtl ? 'آزمایشگاه در تلاقی هوش مصنوعی، بینایی رایانه، یادگیری عمیق و معماری سیستم‌های دیجیتال فعالیت می‌کند' : 'Cutting-edge research spanning healthcare AI, multimodal LLMs, autonomous vision, neural inpainting, and approximate VLSI.' ?>
        </p>
    </div>
</div>

<section class="section">
    <div class="container">
        
        <!-- Pillar 1 -->
        <div class="glass-card" style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin-bottom: 36px; padding: 36px; align-items: center;">
            <div style="background: linear-gradient(135deg, rgba(30, 58, 138, 0.3), rgba(56, 189, 248, 0.1)); border: 1px solid var(--border-glow); border-radius: var(--radius-md); height: 220px; display: flex; align-items: center; justify-content: center; font-size: 5rem;">
                🧠
            </div>
            <div>
                <span class="tag" style="background: rgba(56, 189, 248, 0.15); color: var(--accent-cyan); margin-bottom: 10px; display: inline-block;">Medical AI & Healthcare</span>
                <h2 style="font-size: 1.6rem; color: var(--text-primary); margin-bottom: 10px;">
                    <?= $is_rtl ? '۱. پردازش تصویر پزشکی و هوش مصنوعی سلامت' : '1. Medical Image Analysis & Healthcare AI' ?>
                </h2>
                <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.7; margin-bottom: 16px;">
                    <?= $is_rtl 
                        ? 'طراحی مدل‌های یادگیری عمیق کانولوشنی ۳ بعدی و شبکه‌های توجه برای تشخیص زودهنگام آلزایمر از روی تصاویر MRI ساختاری، دسته‌بندی و تشریح ضایعات پوستی، تشخیص زودهنگام اوتیسم با شبکه‌های عصبی و آنالیز بیماری‌های ریوی و تومورهای کبدی.' 
                        : 'Developing 3D CNNs and attention networks for early Alzheimer diagnosis from structural MRI, skin lesion segmentation, neural screening for autism, and automated pulmonary and hepatic pathology analysis.' ?>
                </p>
                <div class="research-tags">
                    <span class="tag">Alzheimer MRI 3D-CNNs</span>
                    <span class="tag">Dermatology Skin Lesions</span>
                    <span class="tag">Liver Tumor Diagnosis</span>
                    <span class="tag">Autism Neural Screening</span>
                </div>
            </div>
        </div>

        <!-- Pillar 2 -->
        <div class="glass-card" style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin-bottom: 36px; padding: 36px; align-items: center;">
            <div style="background: linear-gradient(135deg, rgba(30, 58, 138, 0.3), rgba(168, 85, 247, 0.1)); border: 1px solid var(--border-glow); border-radius: var(--radius-md); height: 220px; display: flex; align-items: center; justify-content: center; font-size: 5rem;">
                🤖
            </div>
            <div>
                <span class="tag" style="background: rgba(168, 85, 247, 0.15); color: var(--accent-purple); margin-bottom: 10px; display: inline-block;">Vision-Language & Multimodal AI</span>
                <h2 style="font-size: 1.6rem; color: var(--text-primary); margin-bottom: 10px;">
                    <?= $is_rtl ? '۲. مدل‌های زبانی بزرگ چندوجهی و گراف دانش' : '2. Multimodal LLMs & Knowledge Graphs' ?>
                </h2>
                <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.7; margin-bottom: 16px;">
                    <?= $is_rtl 
                        ? 'ادغام مدل‌های زبانی بینایی (VLM) با گراف‌های دانش جهت تفسیر خودکار و قابل اتکای تصاویر رادیولوژی پزشکی، سامانه‌های کپشن‌نویسی تصاویر و تحلیل احساسات متون زبان فارسی.' 
                        : 'Integrating Vision-Language Models (VLM) with biomedical Knowledge Graphs for explainable radiology analysis, automated image captioning, and Persian natural language understanding.' ?>
                </p>
                <div class="research-tags">
                    <span class="tag">Multimodal LLMs (VLM)</span>
                    <span class="tag">Medical Knowledge Graphs</span>
                    <span class="tag">Persian NLP & Sentiment</span>
                    <span class="tag">Clinical Reasoning</span>
                </div>
            </div>
        </div>

        <!-- Pillar 3 -->
        <div class="glass-card" style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin-bottom: 36px; padding: 36px; align-items: center;">
            <div style="background: linear-gradient(135deg, rgba(30, 58, 138, 0.3), rgba(59, 130, 246, 0.1)); border: 1px solid var(--border-glow); border-radius: var(--radius-md); height: 220px; display: flex; align-items: center; justify-content: center; font-size: 5rem;">
                🚗
            </div>
            <div>
                <span class="tag" style="background: rgba(59, 130, 246, 0.15); color: var(--accent-blue); margin-bottom: 10px; display: inline-block;">Autonomous Vision & Edge AI</span>
                <h2 style="font-size: 1.6rem; color: var(--text-primary); margin-bottom: 10px;">
                    <?= $is_rtl ? '۳. بینایی ماشین و خودروهای خودران' : '3. Computer Vision for Autonomous Systems' ?>
                </h2>
                <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.7; margin-bottom: 16px;">
                    <?= $is_rtl 
                        ? 'سامانه‌های بی‌درنگ تشخیص حواس‌پرتی، خستگی و خواب‌آلودگی راننده خودرو با ترانسفورمرهای بینایی و شبکه‌های زمانی عمیق، به همراه الگوریتم‌های بازشناسی بلادرنگ علائم ترافیکی و ردیابی موانع جاده‌ای روی پردازنده‌های لبه.' 
                        : 'Real-time embedded vision pipelines for driver distraction and fatigue detection using vision transformers, alongside real-time traffic sign recognition and obstacle tracking on Nvidia Jetson boards.' ?>
                </p>
                <div class="research-tags">
                    <span class="tag">Driver Distraction Monitoring</span>
                    <span class="tag">Traffic Sign Recognition</span>
                    <span class="tag">Vision Transformers (ViT)</span>
                    <span class="tag">Real-Time Jetson Inference</span>
                </div>
            </div>
        </div>

        <!-- Pillar 4 -->
        <div class="glass-card" style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin-bottom: 36px; padding: 36px; align-items: center;">
            <div style="background: linear-gradient(135deg, rgba(30, 58, 138, 0.3), rgba(245, 158, 11, 0.1)); border: 1px solid var(--border-glow); border-radius: var(--radius-md); height: 220px; display: flex; align-items: center; justify-content: center; font-size: 5rem;">
                🏛️
            </div>
            <div>
                <span class="tag" style="background: rgba(245, 158, 11, 0.15); color: var(--accent-amber); margin-bottom: 10px; display: inline-block;">Generative AI & Cultural Heritage</span>
                <h2 style="font-size: 1.6rem; color: var(--text-primary); margin-bottom: 10px;">
                    <?= $is_rtl ? '۴. مرمت هوشمند آثار و بناهای تاریخی' : '4. AI-Driven Cultural Heritage Restoration' ?>
                </h2>
                <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.7; margin-bottom: 16px;">
                    <?= $is_rtl 
                        ? 'استفاده از شبکه‌های عصبی مولد پیشرفته (GANها و مدل‌های دیفیوژن) برای بازسازی و Inpainting هوشمند کتیبه‌های تاریخی فرسوده، مرمت خودکار بناها با حفظ هندسه و خطوط لبه معماری کهن.' 
                        : 'Leveraging context-aware deep inpainting models, Stable Diffusion, and edge-preserving GANs for non-destructive digital restoration of Persian historical inscriptions and monuments.' ?>
                </p>
                <div class="research-tags">
                    <span class="tag">Deep Neural Inpainting</span>
                    <span class="tag">Historical Texture Synthesis</span>
                    <span class="tag">Edge-Preserving GANs</span>
                    <span class="tag">Monument Restoration</span>
                </div>
            </div>
        </div>

        <!-- Pillar 5 -->
        <div class="glass-card" style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin-bottom: 36px; padding: 36px; align-items: center;">
            <div style="background: linear-gradient(135deg, rgba(30, 58, 138, 0.3), rgba(16, 185, 129, 0.1)); border: 1px solid var(--border-glow); border-radius: var(--radius-md); height: 220px; display: flex; align-items: center; justify-content: center; font-size: 5rem;">
                ⚡
            </div>
            <div>
                <span class="tag" style="background: rgba(16, 185, 129, 0.15); color: var(--accent-emerald); margin-bottom: 10px; display: inline-block;">Hardware Acceleration & Approximate Computing</span>
                <h2 style="font-size: 1.6rem; color: var(--text-primary); margin-bottom: 10px;">
                    <?= $is_rtl ? '۵. محاسبات تقریبی و شتاب‌دهنده‌های سخت‌افزاری' : '5. Approximate Computing & Hardware Accelerators' ?>
                </h2>
                <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.7; margin-bottom: 16px;">
                    <?= $is_rtl 
                        ? 'طراحی و پیاده‌سازی تراشه‌های دیجیتال و بردهای FPGA با استفاده از واحدهای محاسباتی تقریبی جهت کاهش مصرف توان و تاخیر محاسباتی در شتاب‌بخشی استنتاج شبکه‌های یادگیری عمیق در اینترنت اشیاء.' 
                        : 'Designing energy-efficient precision-scalable approximate arithmetic units and FPGA/ASIC accelerators for deep neural inference in low-power edge computing.' ?>
                </p>
                <div class="research-tags">
                    <span class="tag">Approximate Adders / ALUs</span>
                    <span class="tag">Energy-Delay Optimization</span>
                    <span class="tag">FPGA / ASIC Accelerators</span>
                    <span class="tag">Digital Testing & Verification</span>
                </div>
            </div>
        </div>

        <!-- Pillar 6 -->
        <div class="glass-card" style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin-bottom: 36px; padding: 36px; align-items: center;">
            <div style="background: linear-gradient(135deg, rgba(30, 58, 138, 0.3), rgba(236, 72, 153, 0.1)); border: 1px solid var(--border-glow); border-radius: var(--radius-md); height: 220px; display: flex; align-items: center; justify-content: center; font-size: 5rem;">
                🔍
            </div>
            <div>
                <span class="tag" style="background: rgba(236, 72, 153, 0.15); color: #ec4899; margin-bottom: 10px; display: inline-block;">Industrial Vision & Quality Inspection</span>
                <h2 style="font-size: 1.6rem; color: var(--text-primary); margin-bottom: 10px;">
                    <?= $is_rtl ? '۶. بینایی صنعتی و کنترل کیفی خودکار' : '6. Industrial Machine Vision & Quality Inspection' ?>
                </h2>
                <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.7; margin-bottom: 16px;">
                    <?= $is_rtl 
                        ? 'سامانه‌های هوشمند بینایی ماشین جهت بازرسی کیفی بدون تخریب در خطوط تولید پیوسته، شناسایی خودکار عیوب چوب و الوار و تشخیص ناهنجاری در محیط‌های صنعتی.' 
                        : 'Automated optical inspection systems for real-time defect segmentation in continuous manufacturing, wood flaw classification, and industrial sensor anomaly detection.' ?>
                </p>
                <div class="research-tags">
                    <span class="tag">Wood Defect Detection</span>
                    <span class="tag">Surface Anomaly Segmentation</span>
                    <span class="tag">Continuous Quality Control</span>
                    <span class="tag">Automated Optical Inspection</span>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once __DIR__ . "/footer.php"; ?>
