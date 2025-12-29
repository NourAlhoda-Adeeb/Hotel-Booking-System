<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h2 class="page-title">إدارة الحجوزات</h2>

<!-- 🔍 TOOLBAR -->
<form method="get" class="table-toolbar">

    <!-- البحث -->
    <input
        type="text"
        name="search"
        placeholder="بحث باسم الزبون أو رقم الغرفة"
        value="<?= esc($_GET['search'] ?? '') ?>">

    <!-- الحالة -->
    <select name="status" onchange="this.form.submit()">
        <option value="">كل الحالات</option>
        <!-- <option value="pending" <?= (($_GET['status'] ?? '') === 'pending') ? 'selected' : '' ?>>قيد الانتظار</option> -->
        <option value="confirmed" <?= (($_GET['status'] ?? '') === 'confirmed') ? 'selected' : '' ?>>مؤكد</option>
        <option value="cancelled" <?= (($_GET['status'] ?? '') === 'cancelled') ? 'selected' : '' ?>>ملغي</option>
    </select>

    

</form>

<!-- 📋 TABLE -->
<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الزبون</th>
                <th>رقم الغرفة</th>
                <th>الدخول</th>
                <th>الخروج</th>
                <th>السعر</th>
                <th>طريقة الدفع</th>
                <th>الحالة</th>
                <th>تاريخ الحجز</th>
                <th>التفاصيل</th>
            </tr>
        </thead>

        <tbody>
            <?php if (empty($bookings)): ?>
                <tr>
                    <td colspan="10" style="text-align:center;">لا توجد حجوزات</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= $booking['id'] ?></td>
                    <td><?= esc($booking['full_name']) ?></td>
                    <td><?= esc($booking['room_number']) ?></td>
                    <td><?= date('Y-m-d', strtotime($booking['checkin'])) ?></td>
                    <td><?= date('Y-m-d', strtotime($booking['checkout'])) ?></td>
                    <td><?= number_format($booking['total_price'], 2) ?> د.ل</td>
                    <td><?= esc($booking['payment_method']) ?></td>

                    <td>
                        <span class="badge <?= $booking['status'] ?>">
                            <?=
                            $booking['status'] === 'confirmed' ? 'مؤكد' :
                            ($booking['status'] === 'cancelled' ? 'ملغي' : 'قيد الانتظار')
                            ?>
                        </span>
                    </td>

                    <td><?= date('Y-m-d', strtotime($booking['created_at'])) ?></td>

                    <td class="actions">
                        <button class="btn small view"
                            onclick="openViewModal(
                                '<?= esc($booking['full_name']) ?>',
                                '<?= esc($booking['phone']) ?>',
                                '<?= esc($booking['room_number']) ?>',
                                '<?= esc($booking['checkin']) ?>',
                                '<?= esc($booking['checkout']) ?>',
                                '<?= esc($booking['total_price']) ?>',
                                '<?= esc($booking['payment_method']) ?>',
                                '<?= esc($booking['status']) ?>'
                            )">
                            عرض
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>

<!-- 👁️ VIEW MODAL -->
<div class="modal" id="viewModal">
    <div class="modal-content">

        <h3>تفاصيل الحجز</h3>

        <ul class="details-list">
            <li><strong>الاسم:</strong> <span id="m_name"></span></li>
            <li><strong>الهاتف:</strong> <span id="m_phone"></span></li>
            <li><strong>رقم الغرفة:</strong> <span id="m_room"></span></li>
            <li><strong>الدخول:</strong> <span id="m_checkin"></span></li>
            <li><strong>الخروج:</strong> <span id="m_checkout"></span></li>
            <li><strong>السعر:</strong> <span id="m_price"></span> د.ل</li>
            <li><strong>الدفع:</strong> <span id="m_payment"></span></li>
            <li><strong>الحالة:</strong> <span id="m_status"></span></li>
        </ul>

        <button class="btn cancel" onclick="closeViewModal()">إغلاق</button>
    </div>
</div>

<script>
function openViewModal(name, phone, room, checkin, checkout, price, payment, status) {

    document.getElementById('m_name').innerText = name;
    document.getElementById('m_phone').innerText = phone;
    document.getElementById('m_room').innerText = room;
    document.getElementById('m_checkin').innerText = checkin;
    document.getElementById('m_checkout').innerText = checkout;
    document.getElementById('m_price').innerText = price;
    document.getElementById('m_payment').innerText = payment;

    document.getElementById('m_status').innerText =
        status === 'confirmed' ? 'مؤكد' :
        status === 'cancelled' ? 'ملغي' : 'قيد الانتظار';

    document.getElementById('viewModal').style.display = 'flex';
}

function closeViewModal() {
    document.getElementById('viewModal').style.display = 'none';
}
</script>

<?= $this->endSection() ?>
