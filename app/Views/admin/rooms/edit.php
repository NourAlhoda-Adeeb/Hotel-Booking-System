<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h2 class="page-title">تعديل بيانات الغرفة</h2>

<div class="table-wrapper" style="max-width:600px;margin:auto;">

<form method="post" action="<?= base_url('admin/rooms/update') ?>" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $room['id'] ?>">

    <div class="form-group">
        <label>رقم الغرفة</label>
        <input type="number"
               name="room_number"
               min="100"
               max="999"
               value="<?= esc($room['room_number']) ?>"
               required>
    </div>

    <div class="form-group">
        <label>نوع الغرفة</label>
        <input type="text" name="type" value="<?= esc($room['type']) ?>" required>
    </div>

    <div class="form-group">
        <label>السعر</label>
        <input type="number" step="0.01" name="price" value="<?= esc($room['price']) ?>" required>
    </div>

    <div class="form-group">
        <label>الحالة</label>
        <select name="status">
            <option value="available" <?= $room['status']=='available'?'selected':'' ?>>متاحة</option>
            <option value="booked" <?= $room['status']=='booked'?'selected':'' ?>>محجوزة</option>
        </select>
    </div>

    <div class="form-group">
        <label>صورة الغرفة (اختياري)</label>
        <input type="file" name="image">
    </div>

    <div class="modal-actions">
        <button class="btn success">حفظ التعديلات</button>
        <a href="<?= base_url('admin/rooms') ?>" class="btn cancel">إلغاء</a>
    </div>

</form>

</div>

<?= $this->endSection() ?>
