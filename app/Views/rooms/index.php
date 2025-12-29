<?= $this->include('layout/header') ?>

<!-- 🔔 تنبيه تسجيل الدخول -->
<?php if (session()->getFlashdata('login_required')): ?>
    <div class="login-modal-overlay" id="loginAlert">
        <div class="login-modal">
            <h3>تنبيه</h3>
            <p>يجب تسجيل الدخول قبل الحجز</p>

            <div class="login-modal-actions">
                <a href="<?= base_url('login') ?>" class="btn-login">
                    تسجيل الدخول
                </a>
                <button class="btn-cancel" onclick="closeLoginAlert()">إلغاء</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="success-alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>


<h2 class="section-title">الغرف المتوفرة</h2>

<!-- 🔍 فلترة حسب السعر -->
<form method="get" class="price-filter">
    <div class="filter-box">

        <input type="number"
            name="min_price"
            placeholder="السعر من"
            min="100"
            step="100"
            value="<?= esc($min_price ?? '') ?>">

        <input type="number"
            name="max_price"
            placeholder="السعر إلى"
            min="100"
            step="100"
            value="<?= esc($max_price ?? '') ?>">

        <button type="submit">تصفية</button>

        <?php if (!empty($min_price) || !empty($max_price)): ?>
            <a href="<?= base_url('rooms') ?>" class="reset-filter">إعادة تعيين</a>
        <?php endif; ?>

    </div>
</form>

<!-- 🛏️ عرض الغرف -->
<div class="rooms-container">

    <?php if (empty($rooms)): ?>
        <p class="no-results">لا توجد غرف ضمن هذا النطاق السعري</p>
    <?php endif; ?>

    <?php foreach ($rooms as $room): ?>
        <div class="room-card">

            <img src="<?= base_url('uploads/' . $room['image']) ?>" alt="صورة الغرفة">

            <h3>غرفة رقم <?= esc($room['room_number']) ?></h3>
            <p class="room-type"><?= esc($room['type']) ?></p>

            <p class="price"><?= esc($room['price']) ?> د.ل / ليلة</p>

            <?php if ($room['status'] === 'available'): ?>
                <!-- <a href="<?= base_url('booking/create/' . $room['id']) ?>" class="book-btn">
                    احجز الآن
                </a> -->
                <a href="<?= base_url('booking/' . $room['id']) ?>"  class="book-btn">
                    احجز الآن
                </a>

            <?php else: ?>
                <span class="book-btn disabled">غير متاحة</span>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>

</div>

<?= $this->include('layout/footer') ?>

<script>
    function closeLoginAlert() {
        document.getElementById('loginAlert').style.display = 'none';
    }
</script>