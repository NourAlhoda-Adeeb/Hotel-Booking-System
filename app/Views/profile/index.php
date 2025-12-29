<div class="profile-page">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="toast-success" id="toastSuccess">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- ====== USER CARD ====== -->
    <div class="profile-card">
        <img src="<?= base_url('images/user.png') ?>" class="profile-avatar">

        <form method="post" action="<?= base_url('profile/update') ?>" id="profileForm">

            <div class="field">
                <label for="name">الاسم الكامل : </label>
                <input type="text"
                    name="name"
                    id="name"
                    value="<?= esc(session()->get('user_name')) ?>"
                    disabled
                    required>
            </div>

            <div class="field">
                <label for="email">البريد الإلكتروني : </label>
                <input type="email"
                    name="email"
                    id="email"
                    value="<?= esc(session()->get('user_email')) ?>"
                    disabled
                    required>
            </div>

            <div class="field">
                <label for="phone">رقم الهاتف : </label>
                <input type="text"
                    name="phone"
                    id="phone"
                    value="<?= esc(session()->get('user_phone')) ?>"
                    disabled
                    required>
            </div>
            <div class="profile-actions">

                <button type="button"
                    class="profile-btn"
                    id="editBtn"
                    onclick="enableEdit()">
                    تعديل البيانات
                </button>

                <button type="submit"
                    class="profile-btn success"
                    id="saveBtn"
                    style="display:none;">
                    حفظ
                </button>

                <button type="button"
                    class="profile-btn-danger"
                    onclick="openLogoutModal()">
                    تسجيل الخروج
                </button>

            </div>
        </form>
    </div>


    <!-- ====== BOOKINGS ====== -->
    <div class="profile-bookings">
        <h3>حجوزاتي</h3>

        <?php if (empty($bookings)): ?>
            <p class="empty">لا توجد حجوزات</p>
        <?php endif; ?>

        <?php foreach ($bookings as $booking): ?>
            <div class="booking-item">

                <div>
                    <strong>غرفة رقم:</strong> <?= esc($booking['room_number']) ?><br>
                    <small>
                        <?= esc($booking['checkin']) ?> →
                        <?= esc($booking['checkout']) ?>
                    </small>
                </div>

                <div class="booking-actions">
                    <span class="status <?= esc($booking['status']) ?>">
                        <?= esc($booking['status']) ?>
                    </span>

                    <?php if ($booking['status'] !== 'cancelled'): ?>
                        <button class="cancel-btn"
                            onclick="openCancelModal(<?= $booking['id'] ?>)">
                            إلغاء الحجز
                        </button>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</div>

<!-- ====== CANCEL MODAL ====== -->
<div class="modal" id="cancelModal">
    <div class="modal-content">
        <h3>هل أنت متأكد من إلغاء الحجز؟</h3>

        <div class="modal-actions">
            <button id="confirmCancel" class="danger">نعم</button>
            <button onclick="closeCancelModal()">إلغاء</button>


        </div>
    </div>
</div>

<!-- ====== LOGOUT MODAL ====== -->
<div class="modal" id="logoutModal">
    <div class="modal-content">
        <h3>هل أنت متأكد من تسجيل الخروج؟</h3>

        <div class="modal-actions">
            <a href="<?= base_url('logout') ?>" class="danger">نعم</a>
            <button onclick="closeLogoutModal()">إلغاء</button>
        </div>
    </div>
</div>

<script>
    let bookingId = null;

    function openCancelModal(id) {
        bookingId = id;
        document.getElementById('cancelModal').style.display = 'flex';
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').style.display = 'none';
    }

    document.getElementById('confirmCancel').onclick = function() {
        window.location.href = "<?= base_url('booking/cancel/') ?>" + bookingId;

    };

    function openLogoutModal() {
        document.getElementById('logoutModal').style.display = 'flex';
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').style.display = 'none';
    }

    function enableEdit() {
        document.getElementById('name').disabled = false;
        document.getElementById('phone').disabled = false;
        document.getElementById('email').disabled = false; // ✅ الجديد

        document.getElementById('profileForm').classList.add('editing');

        document.getElementById('editBtn').style.display = 'none';
        document.getElementById('saveBtn').style.display = 'inline-block';
    }
    setTimeout(() => {
        const toast = document.getElementById('toastSuccess');
        if (toast) {
            toast.style.opacity = '0';
            toast.style.transform = 'translate(-50%, -45%)';
            setTimeout(() => toast.remove(), 400);
        }
    }, 2500);
</script>