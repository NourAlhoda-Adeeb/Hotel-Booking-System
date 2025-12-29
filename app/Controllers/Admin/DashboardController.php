<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoomModel;
use App\Models\BookingModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $userModel    = new UserModel();
        $roomModel    = new RoomModel();
        $bookingModel = new BookingModel();

        /* عدد المستخدمين */
        $usersCount = $userModel->countAllResults();

        /* عدد الغرف */
        $roomsCount = $roomModel->countAllResults();

        /* عدد الحجوزات (المؤكدة فقط) */
        $bookingsCount = $bookingModel
            ->where('status', 'confirmed')
            ->countAllResults();

        /* الأرباح (المدفوعات المؤكدة فقط) */
        $profits = $bookingModel
            ->where('status', 'confirmed')
            ->selectSum('total_price')
            ->get()
            ->getRow()
            ->total_price ?? 0;

        /* مدفوعات كاش (مؤكدة فقط) */
        $cashPayments = $bookingModel
            ->where('status', 'confirmed')
            ->where('payment_method', 'cash')
            ->selectSum('total_price')
            ->get()
            ->getRow()
            ->total_price ?? 0;

        /* مدفوعات إلكترونية (مؤكدة فقط) */
        $onlinePayments = $bookingModel
            ->where('status', 'confirmed')
            ->where('payment_method !=', 'cash')
            ->selectSum('total_price')
            ->get()
            ->getRow()
            ->total_price ?? 0;

        /* عدد الغرف المحجوزة فعلياً */
        $bookedRooms = $bookingModel
            ->select('room_id')
            ->where('status', 'confirmed')
            ->groupBy('room_id')
            ->countAllResults();

        /* عدد الغرف المتاحة */
        $availableRooms = $roomsCount - $bookedRooms;

        /* حجوزات اليوم */

        $today = date('Y-m-d');

        $todayBookings = $bookingModel
            ->select('
                bookings.*,
                  rooms.room_number
                ')
            ->join('rooms', 'rooms.id = bookings.room_id')
            ->where('bookings.status', 'confirmed')
            ->groupStart()
            ->where('DATE(bookings.checkin)', $today)
            ->orWhere('DATE(bookings.checkout)', $today)
            ->groupEnd()
            ->orderBy('bookings.checkin', 'ASC')
            ->findAll();



        return view('admin/dashboard', [
            'usersCount'      => $usersCount,
            'roomsCount'      => $roomsCount,
            'bookingsCount'   => $bookingsCount,
            'profits'         => $profits,
            'availableRooms'  => $availableRooms,
            'bookedRooms'     => $bookedRooms,
            'cashPayments'    => $cashPayments,
            'onlinePayments'  => $onlinePayments,
            'todayBookings'   => $todayBookings,
        ]);
    }
}
