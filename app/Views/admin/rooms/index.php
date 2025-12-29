<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h2 class="page-title">إدارة الغرف</h2>

<div class="rooms-toolbar">

    <!-- زر إضافة غرفة -->
    <a href="<?= base_url('admin/rooms/create') ?>" class="btn success add-room-btn">
        + إضافة غرفة
    </a>

    <!-- فلترة الغرف -->
    <form method="get" class="rooms-filter-form">
        <select name="status" onchange="this.form.submit()" class="room-filter">
            <option value="">كل الغرف</option>
            <option value="available" <?= ($_GET['status'] ?? '') == 'available' ? 'selected' : '' ?>>
                متاحة
            </option>
            <option value="booked" <?= ($_GET['status'] ?? '') == 'booked' ? 'selected' : '' ?>>
                محجوزة
            </option>
        </select>
    </form>

</div>




<div class="table-wrapper" style="margin-top:20px;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>رقم الغرفة</th>
                <th>النوع</th>
                <th>السعر</th>
                <th>الحالة</th>
                <th>عدد مرات الحجز</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?= $room['id'] ?></td>
                    <td><?= esc($room['room_number']) ?></td>
                    <td><?= esc($room['type']) ?></td>
                    <td><?= number_format($room['price'], 2) ?> د.ل</td>
                    <td>
                        <span class="badge <?= $room['status'] ?>">
                            <?= $room['status'] == 'available' ? 'متاحة' : 'محجوزة' ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge info">
                            <?= $room['bookings_count'] ?>
                        </span>
                    </td>

                    <td class="actions">
                        <a href="<?= base_url('admin/rooms/edit/' . $room['id']) ?>"
                            class="btn edit">
                            تعديل
                        </a>

                        <button
                            class="btn delete"
                            onclick="openDeleteRoom(<?= $room['id'] ?>)">
                            حذف
                        </button>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal" id="deleteRoomModal">
    <div class="modal-content">
        <h3>تأكيد الحذف</h3>
        <p>هل أنت متأكد من حذف هذه الغرفة؟</p>

        <div class="modal-actions">
            <button class="btn danger" id="confirmRoomDelete">نعم، حذف</button>
            <button class="btn cancel" onclick="closeDeleteRoom()">لا</button>
        </div>
    </div>
</div>

<script>
    let deleteRoomId = null;

    function openDeleteRoom(id) {
        deleteRoomId = id;
        document.getElementById('deleteRoomModal').style.display = 'flex';
    }

    function closeDeleteRoom() {
        deleteRoomId = null;
        document.getElementById('deleteRoomModal').style.display = 'none';
    }

    document.getElementById('confirmRoomDelete').onclick = function() {
        window.location.href = "<?= base_url('admin/rooms/delete/') ?>" + deleteRoomId;
    };
</script>

<?= $this->endSection() ?>