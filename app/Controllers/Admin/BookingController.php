<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\RoomModel;

class BookingController extends BaseController
{
    public function index()
    {
        $bookingModel = new BookingModel();

        // 🔍 Filters
        $status = $this->request->getGet('status');
        $search = $this->request->getGet('search');

        $bookingModel
            ->select('
                bookings.id,
                bookings.full_name,
                bookings.phone,
                bookings.checkin,
                bookings.checkout,
                bookings.total_price,
                bookings.payment_method,
                bookings.status,
                bookings.created_at,
                rooms.room_number
            ')
            ->join('rooms', 'rooms.id = bookings.room_id', 'left');

        // فلترة بالحالة
        if ($status) {
            $bookingModel->where('bookings.status', $status);
        }

        // بحث بالاسم أو رقم الغرفة
        if ($search) {
            $bookingModel->groupStart()
                ->like('bookings.full_name', $search)
                ->orLike('rooms.room_number', $search)
                ->groupEnd();
        }

        // ترتيب من الأحدث
        $data['bookings'] = $bookingModel
            ->orderBy('bookings.id', 'ASC')
            ->findAll();

        return view('admin/bookings/index', $data);
    }
}
