<div class="booking-page">

    <a href="<?= base_url('rooms') ?>" class="back-arrow">← الرجوع للغرف</a>

    <h2 class="booking-title">
        حجز غرفة رقم <?= esc($room['room_number']) ?>
    </h2>

    <div class="booking-container">

        <!-- ===== ROOM INFO ===== -->
        <div class="room-box">
            <img src="<?= base_url('uploads/' . $room['image']) ?>" alt="room">
            <h3><?= esc($room['type']) ?></h3>
            <p><strong>السعر:</strong> <?= esc($room['price']) ?> د.ل / الليلة</p>
            <p>متاحة</p>
        </div>

        <!-- ===== FORM ===== -->
        <div class="booking-form-wrapper">
            <form id="booking-form" class="booking-form"
                method="post"
                action="<?= base_url('booking/store') ?>">

                <?= csrf_field() ?>

                <input type="hidden" name="room_id" value="<?= esc($room['id']) ?>">
                <input type="hidden" id="total_price_input" name="total_price">

                <label>الاسم الكامل</label>
                <input type="text" name="full_name" required>

                <label>رقم الهاتف</label>
                <input type="text" name="phone" required>

                <label>تاريخ ووقت الوصول</label>
                <input type="datetime-local" id="checkin" name="checkin" required>

                <label>تاريخ ووقت المغادرة</label>
                <input type="datetime-local" id="checkout" name="checkout" required>

                <!-- السعر -->
                <div class="total-box">
                    السعر الإجمالي:
                    <span id="totalPrice">0</span> د.ل
                </div>

                <label class="full">طريقة الدفع</label>
                <div class="payment-box">
                    <label>
                        <input type="radio" name="payment_method" value="cash">
                        كاش عند الوصول
                    </label>

                    <label>
                        <input type="radio" name="payment_method" value="online">
                        دفع إلكتروني
                    </label>
                </div>

                <button type="submit" class="confirm-btn">
                    تأكيد الحجز
                </button>

            </form>
        </div>
    </div>
</div>

<!-- ===== السعر لــ JS ===== -->
<div id="priceData" data-price="<?= (int)$room['price'] ?>"></div>

<!-- ================= PAYMENT MODAL ================= -->
<div class="modal" id="paymentModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closePaymentModal()">×</span>
        <h2>بيانات البطاقة</h2>

        <input type="text" name="card_name" form="booking-form"
            placeholder="اسم صاحب البطاقة">

        <input type="text" name="card_number" form="booking-form"
            placeholder="رقم البطاقة"
            maxlength="19" inputmode="numeric"
            pattern="[0-9]{13,19}"
            title="رقم البطاقة من 13 إلى 19 رقم">

        <input type="text" name="cvv" form="booking-form"
            placeholder="CVV" maxlength="3">

        <input type="month" name="exp_date" form="booking-form">

        <button type="button" class="confirm-btn" onclick="confirmOnlinePayment()">
            تم
        </button>
    </div>
</div>

<!-- ================= CONFLICT MODAL ================= -->
<?php if (session()->getFlashdata('booking_conflict')):
    $conflict = session()->getFlashdata('booking_conflict');
?>
    <div class="modal" id="conflictModal" style="display:flex;">
        <div class="modal-content">
            <h3>الفترة غير متاحة</h3>

            <p>
                هذه الغرفة محجوزة من<br>
                <strong><?= esc($conflict['from']) ?></strong><br>
                إلى<br>
                <strong><?= esc($conflict['to']) ?></strong>
            </p>

            <button class="confirm-btn" onclick="closeConflictModal()">تم</button>

            <button class="confirm-btn" onclick="openNotifyModal()">
               اذا اصبحت متاحة , إرسل لي إشعار
            </button>
        </div>
    </div>
<?php endif; ?>

<!-- ================= NOTIFY MODAL ================= -->
<?php if (session()->getFlashdata('booking_conflict')): ?>
    <div class="modal" id="notifyModal">
        <div class="modal-content">
            <h3>إشعار عند توفر الغرفة</h3>

            <input type="email" id="notifyEmail"
                placeholder="بريدك الإلكتروني">

            <button class="confirm-btn" onclick="saveNotifyRequest()">
                حفظ
            </button>
        </div>
    </div>
<?php endif; ?>

<!-- ================= SUCCESS MODAL ================= -->
<!-- ===== NOTIFY SUCCESS MODAL ===== -->
<div class="modal" id="notifySuccessModal">
    <div class="modal-content">
        <div style="font-size:40px; color:#6b4a54;">✔</div>

        <h3>تم حفظ طلبك</h3>
        <p>سنقوم بإعلامك فور توفر الغرفة في الفترة المطلوبة.</p>

        <button class="confirm-btn" onclick="closeNotifySuccess()">
            تم
        </button>
    </div>
</div>
<!-- رسالة الحجز  -->
<?php if (session()->getFlashdata('booking_success')): ?>
    <div class="modal" style="display:flex;">
        <div class="modal-content">
            <div style="font-size:42px; color:#6b4a54;">✔</div>

            <h3>تم تأكيد الحجز بنجاح</h3>
            <p>شكراً لك، تم تأكيد الحجز بنجاح.</p>

            <button class="confirm-btn"
                onclick="window.location.href='<?= base_url('profile') ?>'">
                تم
            </button>
        </div>
    </div>
<?php endif; ?>

<!-- ================= JAVASCRIPT ================= -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const pricePerNight = parseInt(
            document.getElementById('priceData').dataset.price
        );

        const form = document.getElementById('booking-form');
        const checkin = document.getElementById('checkin');
        const checkout = document.getElementById('checkout');
        const totalEl = document.getElementById('totalPrice');
        const totalInp = document.getElementById('total_price_input');

        function calculateTotal() {
            if (!checkin.value || !checkout.value) return;

            const inDate = new Date(checkin.value);
            const outDate = new Date(checkout.value);

            if (outDate <= inDate) {
                totalEl.innerText = 0;
                totalInp.value = 0;
                return;
            }

            const nights = Math.ceil(
                (outDate - inDate) / (1000 * 60 * 60 * 24)
            );

            const total = nights * pricePerNight;

            totalEl.innerText = total;
            totalInp.value = total;
        }

        checkin.addEventListener('change', calculateTotal);
        checkout.addEventListener('change', calculateTotal);

        // فتح الدفع الإلكتروني تلقائياً
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'online') {
                    openPaymentModal();
                }
            });
        });

        // منع إرسال خاطئ
        form.addEventListener('submit', function(e) {

            const payment = document.querySelector(
                'input[name="payment_method"]:checked'
            );

            const total = parseInt(totalInp.value || 0);

            if (!payment) {
                alert('يرجى اختيار طريقة الدفع');
                e.preventDefault();
                return;
            }

            if (total <= 0) {
                alert('يرجى اختيار تاريخ صحيح');
                e.preventDefault();
                return;
            }

            if (payment.value === 'online') {
                e.preventDefault();
                openPaymentModal();
            }
        });
    });

    // ===== MODAL FUNCTIONS =====
    function openPaymentModal() {
        document.getElementById('paymentModal').style.display = 'flex';
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').style.display = 'none';
    }

    function confirmOnlinePayment() {
        closePaymentModal();
        document.getElementById('booking-form').submit();
    }

    function closeConflictModal() {
        document.getElementById('conflictModal').style.display = 'none';
    }

    function openNotifyModal() {
        document.getElementById('notifyModal').style.display = 'flex';
    }

    <?php if (session()->getFlashdata('booking_conflict')): ?>

        function saveNotifyRequest() {
            const email = document.getElementById('notifyEmail').value;

            if (!email) {
                alert('يرجى إدخال البريد الإلكتروني');
                return;
            }

            fetch("<?= base_url('booking/notify') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({
                        room_id: <?= (int)$room['id'] ?>,
                        email: email,
                        checkin: "<?= esc($conflict['from']) ?>",
                        checkout: "<?= esc($conflict['to']) ?>"
                    })
                })
                .then(() => {
                    // نسكر مودال الإدخال
                    document.getElementById('notifyModal').style.display = 'none';

                    // نفتح مودال النجاح
                    document.getElementById('notifySuccessModal').style.display = 'flex';
                });
        }
    <?php endif; ?>

    function closeNotifySuccess() {

        // نسكر رسالة "تم حفظ طلبك"
        const success = document.getElementById('notifySuccessModal');
        if (success) success.style.display = 'none';

        // 🔥 نسكر رسالة التداخل
        const conflict = document.getElementById('conflictModal');
        if (conflict) conflict.style.display = 'none';

        // (اختياري) نسكر مودال إدخال الإيميل
        const notify = document.getElementById('notifyModal');
        if (notify) notify.style.display = 'none';
    }
</script>