<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h2 class="page-title">إدارة المدفوعات</h2>

<!-- 🔢 STATS -->
<div class="cards payments-cards">

    <div class="card">
        <span>إجمالي المدفوعات</span>
        <strong><?= number_format($totalPayments, 2) ?> د.ل</strong>
    </div>

    <div class="card">
        <span>مدفوعات كاش</span>
        <strong><?= number_format($cashPayments, 2) ?> د.ل</strong>
    </div>

    <div class="card">
        <span>مدفوعات إلكترونية</span>
        <strong><?= number_format($onlinePayments, 2) ?> د.ل</strong>
    </div>

</div>

<!-- 🔍 FILTER -->
<form method="get" class="table-toolbar">

    <select name="method" onchange="this.form.submit()">
        <option value="">كل طرق الدفع</option>
        <option value="cash" <?= ($_GET['method'] ?? '') == 'cash' ? 'selected' : '' ?>>كاش</option>
        <option value="online" <?= ($_GET['method'] ?? '') == 'online' ? 'selected' : '' ?>>إلكتروني</option>
    </select>

    <input type="date" name="date" value="<?= esc($_GET['date'] ?? '') ?>" onchange="this.form.submit()">

</form>

<!-- 📋 TABLE -->
<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الزبون</th>
                <th>الهاتف</th>
                <th>طريقة الدفع</th>
                <th>المبلغ</th>
                <th>الحالة</th>
                <th>تاريخ الدفع</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($payments as $pay): ?>
                <tr>
                    <td><?= $pay['id'] ?></td>
                    <td><?= esc($pay['full_name']) ?></td>
                    <td><?= esc($pay['phone']) ?></td>
                    <td><?= $pay['payment_method'] == 'cash' ? 'كاش' : 'إلكتروني' ?></td>
                    <td><?= number_format($pay['total_price'], 2) ?> د.ل</td>
                    <td>
                        <span class="status <?= $pay['status'] ?>">
                            <?= $pay['status'] === 'confirmed' ? 'مؤكد' : 'ملغي' ?>
                        </span>
                    </td>
                    <td><?= date('Y-m-d', strtotime($pay['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
