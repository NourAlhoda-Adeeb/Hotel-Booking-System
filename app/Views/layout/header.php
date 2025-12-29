<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>Hotel Booking</title>
    <link rel="icon" type="image/png" href="<?= base_url('images/favicon.jpg') ?>">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>

<body>
    <?php if (session()->getFlashdata('auth_success')): ?>
        <div class="success-modal-overlay" id="successModal">
            <div class="success-modal">
                <div class="success-icon">✔</div>

                <h3>تم بنجاح</h3>

                <p><?= session()->getFlashdata('auth_success') ?></p>

                <button class="success-btn" onclick="closeSuccessModal()">تم</button>
            </div>
        </div>

        <script>
            function closeSuccessModal() {
                document.getElementById('successModal').style.display = 'none';
            }
        </script>
    <?php endif; ?>

    <nav class="navbar">

        <div class="right-side">
            <div class="logo">
                <img src="<?= base_url('images/logo.jpg') ?>" alt="logo">
            </div>

            <?php if (session()->get('user_id')): ?>
                <a href="<?= base_url('profile') ?>" class="profile-btn">
                    حسابي
                </a>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="profile-btn">
                    تسجيل الدخول
                </a>
            <?php endif; ?>

        </div>

        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <ul class="nav-links">
            <li><a href="<?= base_url('/') ?>" class="active">الرئيسية</a></li>
            <li><a href="#faq">الأسئلة الشائعة</a></li>
            <li><a href="#contact">تواصل معنا</a></li>
        </ul>

    </nav>