<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'لوحة التحكم' ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('images/favicon.jpg') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
</head>

<body>

    <div class="admin-wrapper">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <!-- LOGO -->
            <div class="sidebar-logo">
                <img src="<?= base_url('images/logo.jpg') ?>" alt="Hotel Logo">
                <span>AN Hotel</span>
            </div>

            <ul>
                <li><a href="<?= base_url('admin') ?>">الرئيسية</a></li>
                <li><a href="<?= base_url('admin/users') ?>">المستخدمين</a></li>
                <li><a href="<?= base_url('admin/rooms') ?>">الغرف</a></li>
                <li><a href="<?= base_url('admin/bookings') ?>">الحجوزات</a></li>
                <li><a href="<?= base_url('admin/payments') ?>">المدفوعات</a></li>
                <li><a href="<?= base_url('admin/reports/payments') ?>">التقارير</a></li>
                <li class="logout">
                    <a href="javascript:void(0)" onclick="openLogoutModal()">تسجيل الخروج</a>
                </li>

            </ul>
        </aside>

        <!-- MAIN -->
        <main class="main-content">

            <!-- TOPBAR -->
            <!-- <header class="topbar">
                <span>مرحبا، <?= session('user_name') ?></span>
            </header> -->

            <!-- CONTENT -->
            <section class="content">
                <?= $this->renderSection('content') ?>
            </section>

        </main>
        <!-- 🔴 LOGOUT MODAL -->
        <div class="modal" id="logoutModal">
            <div class="modal-content">

                <h3 class="modal-title">تأكيد تسجيل الخروج</h3>
                <p style="text-align:center;">هل أنت متأكد أنك تريد تسجيل الخروج؟</p>

                <div class="modal-actions">
                    <a href="<?= base_url('logout') ?>" class="btn danger">نعم، خروج</a>
                    <button class="btn cancel" onclick="closeLogoutModal()">لا</button>
                </div>

            </div>
        </div>

    </div>

    <script>
        function openLogoutModal() {
            document.getElementById('logoutModal').style.display = 'flex';
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }
    </script>


</body>

</html>