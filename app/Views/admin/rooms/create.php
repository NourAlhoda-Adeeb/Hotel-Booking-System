<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert error">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<h2 class="page-title">إضافة غرفة جديدة</h2>

<div class="add-room-wrapper">

    <form method="post" action="<?= base_url('admin/rooms/store') ?>" enctype="multipart/form-data">

        <div class="form-group">
            <label>رقم الغرفة</label>
            <input type="number" name="room_number"
                max="999" min="100" required>
        </div>

        <div class="form-group">
            <label>نوع الغرفة</label>
            <input type="text" name="type" required>
        </div>

        <div class="form-group">
            <label>السعر (د.ل)</label>
            <input type="number" step="0.01" name="price" required>
        </div>

        <div class="form-group">
            <label>الحالة</label>
            <select name="status">
                <option value="available">متاحة</option>
                <option value="booked">محجوزة</option>
            </select>
        </div>

        <div class="form-group">
            <label>صورة الغرفة</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <div class="modal-actions">
            <button type="submit" class="btn success">حفظ</button>
            <a href="<?= base_url('admin/rooms') ?>" class="btn cancel">إلغاء</a>
        </div>

    </form>

</div>

<?= $this->endSection() ?>