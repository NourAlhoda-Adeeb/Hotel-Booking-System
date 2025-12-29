<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h2 class="page-title">تقارير المدفوعات</h2>

<!-- 🔍 FILTER -->
<form method="get" class="table-toolbar">

    <input type="date" name="from" value="<?= esc($_GET['from'] ?? '') ?>">
    <input type="date" name="to" value="<?= esc($_GET['to'] ?? '') ?>">

    <select name="method">
        <option value="">كل طرق الدفع</option>
        <option value="cash" <?= ($_GET['method'] ?? '') == 'cash' ? 'selected' : '' ?>>كاش</option>
        <option value="online" <?= ($_GET['method'] ?? '') == 'online' ? 'selected' : '' ?>>إلكتروني</option>
    </select>

    <button class="btn success">عرض التقرير</button>

    <!-- 📄 PDF -->
    <a href="<?= base_url('admin/reports/payments/pdf') ?>" class="btn success">
        تصدير PDF
    </a>



</form>

<!-- 🔢 SUMMARY -->
<div class="cards" style="margin-bottom:20px;">
    <div class="card">
        إجمالي المدفوعات
        <strong><?= number_format($total, 2) ?> د.ل</strong>
    </div>
    <div class="card">
        عدد العمليات
        <strong><?= $count ?></strong>
    </div>
</div>

<!-- 📋 TABLE -->
<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الزبون</th>
                <th>طريقة الدفع</th>
                <th>المبلغ</th>
                <th>تاريخ الدفع</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $pay): ?>
                <tr>
                    <td><?= $pay['id'] ?></td>
                    <td><?= esc($pay['full_name']) ?></td>
                    <td><?= $pay['payment_method'] == 'cash' ? 'كاش' : 'إلكتروني' ?></td>
                    <td><?= number_format($pay['total_price'], 2) ?> د.ل</td>
                    <td><?= date('Y-m-d', strtotime($pay['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($payments)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">لا توجد بيانات</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>