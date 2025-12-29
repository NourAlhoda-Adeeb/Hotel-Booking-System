<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;

class PaymentController extends BaseController
{
    public function index()
    {
        $bookingModel = new BookingModel();

        $method = $this->request->getGet('method');
        $date   = $this->request->getGet('date');

        /* ======================
           جدول المدفوعات
           (مؤكدة فقط)
        ====================== */

        $bookingModel->where('status', 'confirmed');

        if ($method) {
            $bookingModel->where('payment_method', $method);
        }

        if ($date) {
            $bookingModel->where('DATE(created_at)', $date);
        }

        $payments = $bookingModel
            ->orderBy('created_at', 'ASC')
            ->findAll();

        /* ======================
           الإحصائيات (مؤكدة فقط)
        ====================== */

        $statsModel = new BookingModel();

        $totalPayments = $statsModel
            ->where('status', 'confirmed')
            ->selectSum('total_price')
            ->get()
            ->getRow()
            ->total_price ?? 0;

        $cashPayments = $statsModel
            ->where('status', 'confirmed')
            ->where('payment_method', 'cash')
            ->selectSum('total_price')
            ->get()
            ->getRow()
            ->total_price ?? 0;

        $onlinePayments = $statsModel
            ->where('status', 'confirmed')
            ->where('payment_method !=', 'cash')
            ->selectSum('total_price')
            ->get()
            ->getRow()
            ->total_price ?? 0;

        return view('admin/payments/index', [
            'payments'       => $payments,
            'totalPayments'  => $totalPayments,
            'cashPayments'   => $cashPayments,
            'onlinePayments' => $onlinePayments,
        ]);
    }
}
