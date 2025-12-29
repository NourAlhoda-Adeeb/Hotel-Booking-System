<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\RoomModel;
use App\Models\UserModel;   // 🔥 مهم جداً
use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        // تهيئة الموديل مرة وحدة
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $bookingModel = new BookingModel();

        $bookings = $bookingModel
            ->select('bookings.*, rooms.room_number')
            ->join('rooms', 'rooms.id = bookings.room_id')
            ->where('bookings.user_id', session()->get('user_id'))
            ->where('bookings.status !=', 'cancelled')
            ->orderBy('bookings.id', 'DESC')
            ->findAll();

        return view('layout/header')
            . view('profile/index', [
                'bookings' => $bookings
            ])
            . view('layout/footer');
    }

    public function cancelBooking($id)
    {
        $bookingModel = new BookingModel();
        $roomModel    = new RoomModel();

        $booking = $bookingModel->find($id);

        if ($booking && $booking['user_id'] == session()->get('user_id')) {

            // تحديث حالة الحجز
            $bookingModel->update($id, [
                'status' => 'cancelled'
            ]);

            // إرجاع الغرفة متاحة
            $roomModel->update($booking['room_id'], [
                'status' => 'available'
            ]);
        }

        return redirect()->to('/profile')
            ->with('cancel_success', true);
    }

    public function update()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');

        $data = [
            'name'  => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
        ];

        // تحديث الداتابيز
        $this->userModel->update($userId, $data);

        // تحديث السيشن
        session()->set([
            'user_name'  => $data['name'],
            'user_phone' => $data['phone'],
            'user_email' => $data['email'],
        ]);

        return redirect()->back()->with('success', 'تم تحديث البيانات بنجاح');
    }
}
