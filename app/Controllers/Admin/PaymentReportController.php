<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use TCPDF;

class PaymentReportController extends BaseController
{
    // ===============================
    // شاشة التقارير
    // ===============================
    public function index()
    {
        /* ======================
           جدول التقرير (حسب الفلترة)
        ====================== */
        $listModel = new BookingModel();

        $from   = $this->request->getGet('from');
        $to     = $this->request->getGet('to');
        $method = $this->request->getGet('method');

        $listModel->where('status', 'confirmed');

        if ($from) {
            $listModel->where('DATE(created_at) >=', $from);
        }

        if ($to) {
            $listModel->where('DATE(created_at) <=', $to);
        }

        if ($method) {
            $listModel->where('payment_method', $method);
        }

        $payments = $listModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        /* ======================
           إجمالي المدفوعات
           (نفس شاشة المدفوعات)
        ====================== */
        $statsModel = new BookingModel();

        $total = $statsModel
            ->where('status', 'confirmed')
            ->selectSum('total_price')
            ->get()
            ->getRow()
            ->total_price ?? 0;

        return view('admin/reports/payments', [
            'payments' => $payments,
            'total'    => $total,
            'count'    => count($payments),
        ]);
    }

    // ===============================
    // تصدير PDF
    // ===============================
    public function exportPdf()
    {
        /* ======================
           نفس منطق الجدول
        ====================== */
        $listModel = new BookingModel();

        $from   = $this->request->getGet('from');
        $to     = $this->request->getGet('to');
        $method = $this->request->getGet('method');

        $listModel->where('status', 'confirmed');

        if ($from) {
            $listModel->where('DATE(created_at) >=', $from);
        }

        if ($to) {
            $listModel->where('DATE(created_at) <=', $to);
        }

        if ($method) {
            $listModel->where('payment_method', $method);
        }

        $payments = $listModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        /* ======================
           نفس إجمالي شاشة المدفوعات
        ====================== */
        $statsModel = new BookingModel();

        $total = $statsModel
            ->where('status', 'confirmed')
            ->selectSum('total_price')
            ->get()
            ->getRow()
            ->total_price ?? 0;

        /* ======================
           PDF
        ====================== */
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setRTL(true);
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->AddPage();

        $html = view('admin/reports/payments_pdf', [
            'payments' => $payments,
            'total'    => $total
        ]);

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('payment_report.pdf', 'D');
        exit;
    }
}
