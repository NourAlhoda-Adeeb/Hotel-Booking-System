<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h2 class="page-title">إدارة المستخدمين</h2>

<!-- 🔍 TOOLBAR -->
<form method="get" class="table-toolbar">

    <!-- 🔍 بحث -->
    <input
        type="text"
        name="search"
        placeholder="بحث بالاسم أو البريد"
        value="<?= esc($_GET['search'] ?? '') ?>">

    <!-- 🧑‍💼 الدور -->
    <select name="role" onchange="this.form.submit()">
        <option value="">الدور</option>
        <option value="admin" <?= (($_GET['role'] ?? '') === 'admin') ? 'selected' : '' ?>>أدمن</option>
        <option value="user" <?= (($_GET['role'] ?? '') === 'user') ? 'selected' : '' ?>>مستخدم</option>
    </select>

    <!-- 📅 التاريخ -->
    <input
        type="date"
        name="date"
        value="<?= esc($_GET['date'] ?? '') ?>"
        onchange="this.form.submit()">

</form>


<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>رقم الهاتف</th>
                <th>الدور</th>
                <th>تاريخ التسجيل</th>
                <th>الإجراءات</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= esc($user['name']) ?></td>
                    <td><?= esc($user['email']) ?></td>
                    <td><?= esc($user['phone'] ?? '-') ?></td>
                    <td>
                        <span class="role <?= $user['role'] ?>">
                            <?= $user['role'] === 'admin' ? 'أدمن' : 'مستخدم' ?>
                        </span>
                    </td>
                    <td><?= date('Y-m-d', strtotime($user['created_at'])) ?></td>
                    <td class="actions">
                        <button class="btn edit"
                            onclick="openEditModal(
                                <?= $user['id'] ?>,
                                '<?= esc($user['name']) ?>',
                                '<?= esc($user['email']) ?>',
                                '<?= esc($user['phone']) ?>',
                                 '<?= $user['role'] ?>'
                            )">تعديل</button>

                        <button class="btn delete"
                            onclick="openDeleteModal(<?= $user['id'] ?>)">
                            حذف
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- ✏️ EDIT MODAL -->
<!-- ✏️ EDIT MODAL -->
<div class="modal" id="editModal">
    <div class="modal-content edit-modal">

        <h3 class="modal-title">تعديل بيانات المستخدم</h3>

        <form method="post" action="<?= base_url('admin/users/update') ?>">

            <input type="hidden" name="id" id="edit_id">

            <div class="form-group">
                <label>الاسم الكامل</label>
                <input type="text" name="name" id="edit_name" required>
            </div>

            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" id="edit_email" required>
            </div>

            <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" id="edit_phone">
            </div>

            <div class="form-group">
                <label>الدور</label>
                <select name="role" id="edit_role" required>
                    <option value="user">مستخدم</option>
                    <option value="admin">أدمن</option>
                </select>
            </div>


            <div class="modal-actions">
                <button type="submit" class="btn success">حفظ التعديلات</button>
                <button type="button" class="btn cancel" onclick="closeEditModal()">إلغاء</button>
            </div>

        </form>
    </div>
</div>


<!-- 🗑️ DELETE MODAL -->
<div class="modal" id="deleteModal">
    <div class="modal-content">
        <h3>تأكيد الحذف</h3>
        <p>هل أنت متأكد من حذف هذا المستخدم؟</p>

        <div class="modal-actions">
            <button class="btn danger" id="confirmDelete">نعم، حذف</button>
            <button class="btn cancel" onclick="closeDeleteModal()">لا</button>
        </div>
    </div>
</div>

<script>
    let deleteUserId = null;

    function openEditModal(id, name, email, phone, role) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_phone').value = phone ?? '';
        document.getElementById('edit_role').value = role;

        document.getElementById('editModal').style.display = 'flex';
    }


    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    function openDeleteModal(id) {
        deleteUserId = id;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        deleteUserId = null;
        document.getElementById('deleteModal').style.display = 'none';
    }

    document.getElementById('confirmDelete').onclick = function() {
        window.location.href = "<?= base_url('admin/users/delete/') ?>" + deleteUserId;
    };
</script>

<?= $this->endSection() ?>