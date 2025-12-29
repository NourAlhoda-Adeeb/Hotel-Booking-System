<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">

    <style>
        @font-face {
            font-family: 'Tajawal';
            src: url("<?= FCPATH . 'fonts/Tajawal-Regular.ttf' ?>") format('truetype');
        }

        body {
            font-family: 'Tajawal', DejaVu Sans, sans-serif;
            direction: rtl;
            text-align: right;
        }


        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 80px;
            margin-bottom: 10px;
        }

        h2 {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

        .total {
            margin-top: 15px;
            font-weight: bold;
            font-size: 15px;
        }
    </style>
</head>

<body>

    <div class="header">
        <!-- 🖼️ اللوقو -->
        <img src="<?= FCPATH . 'images/logo.jpg' ?>" alt="AN Hotel">

        <h2 style="text-align:center">AN Hotel</h2>
        <p style="text-align:center">تقرير المدفوعات</p>

        <table border="1" cellpadding="6">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الزبون</th>
                    <th>طريقة الدفع</th>
                    <th>المبلغ</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= $p['full_name'] ?></td>
                        <td><?= $p['payment_method'] ?></td>
                        <td>
                            <span style="direction:ltr; unicode-bidi:embed;">
                                <?= number_format($p['total_price'], 2, '.', '') ?>
                            </span> د.ل
                        </td>

                        <td><?= date('Y-m-d', strtotime($p['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>
            <strong>إجمالي المدفوعات:</strong>
            <span style="direction:ltr; unicode-bidi:embed;">
                <?= number_format($total, 2, '.', '') ?>
            </span> د.ل
        </p>


    </div>

</body>

</html>