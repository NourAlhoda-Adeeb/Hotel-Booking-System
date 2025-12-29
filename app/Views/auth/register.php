<?= $this->include('layout/header') ?>

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

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>

<body>

    <div class="auth-page">
        <div class="auth-card">

            <h2>إنشاء حساب</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="auth-error">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="post">

                <label>الاسم</label>
                <div class="input-group">
                    <i class="icon lock"></i>
                    <input type="text" name="name"
                    placeholder="NourAlhoda" required>
                </div>

                <label>البريد الإلكتروني</label>
                <div class="input-group">
                    <i class="icon email"></i>
                    <input type="email" name="email"
                     placeholder=" ✉️ example@email.com" required>
                </div>

                <label>كلمة المرور</label>
                <div class="input-group">
                    <i class="icon lock"></i>
                    <input type="password" name="password"
                    placeholder=" 🔒 ••••••••" required>
                </div>

                <button type="submit">إنشاء الحساب</button>
            </form>

            <div class="auth-footer">
                لديك حساب؟
                <a href="<?= base_url('login') ?>">تسجيل الدخول</a>
            </div>

        </div>
    </div>

    <?= $this->include('layout/footer') ?>

</body>

</html>