<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h1 class="page-title">لوحة التحكم</h1>

<div class="cards">
    <div class="card">
        عدد المستخدمين
        <strong><?= $usersCount ?></strong>
    </div>

    <div class="card">
        الغرف
        <strong><?= $roomsCount ?></strong>
    </div>

    <div class="card">
        الحجوزات
        <strong><?= $bookingsCount ?></strong>
    </div>

    <div class="card">
        الأرباح
        <strong><?= number_format($profits, 2) ?> د.ل</strong>
    </div>
</div>

<div style="display:flex; gap:30px; flex-wrap:wrap; margin-top:30px;">

    <!-- رسم الغرف -->
    <div class="card" style="max-width:300px;">
        <h4 style="margin-bottom:10px;">حالة الغرف</h4>
        <canvas id="roomsChart" height="90"></canvas>
    </div>

    <!-- رسم المدفوعات -->
    <div class="card" style="max-width:300px;">
        <h4 style="margin-bottom:10px;">المدفوعات</h4>
        <canvas id="paymentsChart" height="90"></canvas>
    </div>

</div>

<div class="card" style="margin-top:35px;">

    <h3 style="margin-bottom:15px;">حجوزات اليوم</h3>

    <table class="admin-table">
        <thead>
            <tr>
                <th>الزبون</th>
                <th>الغرفة</th>
                <th>الدخول</th>
                <th>الخروج</th>
                <th>الحالة</th>
            </tr>
        </thead>
        <tbody>

            <?php if (empty($todayBookings)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">لا توجد حجوزات اليوم</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($todayBookings as $booking): ?>
                <?php
                $isCheckinToday = date('Y-m-d', strtotime($booking['checkin'])) === date('Y-m-d');
                $isCheckoutToday = date('Y-m-d', strtotime($booking['checkout'])) === date('Y-m-d');

                ?>

                <tr class="
                     <?= $isCheckinToday ? 'checkin-today' : '' ?>
                       <?= $isCheckoutToday ? 'checkout-today' : '' ?>
                            ">
                    <td><?= esc($booking['full_name']) ?></td>
                    <td><?= esc($booking['room_number']) ?></td>
                    <td><?= $booking['checkin'] ?></td>
                    <td><?= $booking['checkout'] ?></td>
                    <td>
                        <?php if ($isCheckinToday): ?>
                            <span class="badge confirmed">دخول اليوم</span>
                        <?php elseif ($isCheckoutToday): ?>
                            <span class="badge pending">خروج اليوم</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>


        </tbody>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('roomsChart');

    new Chart(ctx, {
        type: 'doughnut', // ممكن تغيرها bar لو تبي
        data: {
            labels: ['غرف متاحة', 'غرف محجوزة'],
            datasets: [{
                data: [<?= $availableRooms ?>, <?= $bookedRooms ?>],
                backgroundColor: [
                    '#16a34a', // أخضر
                    '#dc2626' // أحمر
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    /* رسم المدفوعات */
    const paymentsCtx = document.getElementById('paymentsChart');

    new Chart(paymentsCtx, {
        type: 'doughnut',
        data: {
            labels: ['كاش', 'إلكتروني'],
            datasets: [{
                data: [<?= $cashPayments ?>, <?= $onlinePayments ?>],
                backgroundColor: [
                    '#16a34a', // أخضر كاش
                    '#2563eb' // أزرق إلكتروني
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>


<?= $this->endSection() ?>