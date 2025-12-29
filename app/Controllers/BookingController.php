<?php

namespace App\Controllers;

use App\Models\RoomModel;
use App\Models\BookingModel;

class BookingController extends BaseController
{
    /* ===============================
        عرض صفحة الحجز
    ================================ */
    public function create($id)
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/rooms')
                ->with('login_required', true);
        }

        $roomModel = new RoomModel();
        $room = $roomModel->find($id);

        if (!$room) {
            return redirect()->to('/rooms');
        }

        return view('layout/header')
            . view('booking/create', ['room' => $room])
            . view('layout/footer');
    }

    /* ===============================
        حفظ الحجز
    ================================ */
    public function store()
    {
        $bookingModel = new BookingModel();

        $roomId        = $this->request->getPost('room_id');
        $checkIn       = $this->request->getPost('checkin');
        $checkOut      = $this->request->getPost('checkout');
        $totalPrice    = $this->request->getPost('total_price');
        $paymentMethod = $this->request->getPost('payment_method');

        $cardName   = $this->request->getPost('card_name');
        $cardNumber = $this->request->getPost('card_number');
        $cvv        = $this->request->getPost('cvv');
        $expDate    = $this->request->getPost('exp_date');

        /* ===== فحص التواريخ ===== */
        if ($checkOut <= $checkIn) {
            return redirect()->back()
                ->with('error', 'تاريخ المغادرة يجب أن يكون بعد تاريخ الوصول')
                ->withInput();
        }

        /* ===== فحص التداخل ===== */
        $conflict = $bookingModel
            ->where('room_id', $roomId)
            ->where('status !=', 'cancelled')
            ->where('checkin <', $checkOut)
            ->where('checkout >', $checkIn)
            ->first();

        if ($conflict) {
            return redirect()->back()
                ->with('booking_conflict', [
                    'from' => $conflict['checkin'],
                    'to'   => $conflict['checkout']
                ])
                ->withInput();
        }

        /* ===== تحقق الدفع الإلكتروني ===== */
        if ($paymentMethod === 'online') {

            if (!$cardNumber || !preg_match('/^[0-9]{13,19}$/', $cardNumber)) {
                return redirect()->back()
                    ->with('error', 'رقم البطاقة يجب أن يكون من 13 إلى 19 رقم')
                    ->withInput();
            }

            if (!$cvv || !preg_match('/^[0-9]{3}$/', $cvv)) {
                return redirect()->back()
                    ->with('error', 'CVV يجب أن يكون 3 أرقام')
                    ->withInput();
            }

            if (!$cardName || !$expDate) {
                return redirect()->back()
                    ->with('error', 'يرجى إدخال جميع بيانات البطاقة')
                    ->withInput();
            }
        } else {
            $cardName = $cardNumber = $cvv = $expDate = null;
        }

        /* ===== حفظ الحجز ===== */
        $bookingModel->insert([
            'user_id'        => session()->get('user_id'),
            'room_id'        => $roomId,
            'full_name'      => $this->request->getPost('full_name'),
            'phone'          => $this->request->getPost('phone'),
            'checkin'        => $checkIn,
            'checkout'       => $checkOut,
            'total_price'    => $totalPrice,
            'payment_method' => $paymentMethod,
            'card_name'      => $cardName,
            'card_number'    => $cardNumber,
            'cvv'            => $cvv,
            'exp_date'       => $expDate,
            'status'         => 'confirmed',
        ]);

        return redirect()->back()->with('booking_success', true);
    }

    /* ===============================
        حفظ طلب الإشعار
    ================================ */
    public function notify()
    {
        $data = $this->request->getJSON(true);

        $db = \Config\Database::connect();
        $db->table('room_waitlist')->insert([
            'room_id'    => $data['room_id'],
            'user_email' => $data['email'],
            'checkin'    => $data['checkin'],
            'checkout'   => $data['checkout'],
            'notified'   => 0
        ]);

        return $this->response->setJSON(['status' => 'ok']);
    }

    /* ===============================
        إلغاء الحجز + إرسال الإيميل
    ================================ */
    public function cancel($bookingId)
    {
        dd('cancel function works');

        $bookingModel = new BookingModel();
        $db = \Config\Database::connect();

        $booking = $bookingModel->find($bookingId);
        if (!$booking) {
            return redirect()->back();
        }

        // 1️⃣ إلغاء الحجز
        $bookingModel->update($bookingId, ['status' => 'cancelled']);

        // 2️⃣ جلب قائمة الانتظار
        $waitlist = $db->table('room_waitlist')
            ->where('room_id', $booking['room_id'])
            ->where('notified', 0)
            ->get()
            ->getResultArray();

        foreach ($waitlist as $row) {

            $email = \Config\Services::email();

            $email->setFrom(
                config('Email')->fromEmail,
                config('Email')->fromName
            );

            $email->setTo($row['user_email']);
            $email->setSubject('🔔 الغرفة أصبحت متاحة');

            $email->setMessage("
    <h3>مرحبًا 👋</h3>
    <p>
        الغرفة التي طلبتها من
        <strong>{$row['checkin']}</strong>
        إلى
        <strong>{$row['checkout']}</strong>
        أصبحت متاحة الآن.
    </p>
    <p>
        يمكنك الدخول للموقع وحجزها في أقرب وقت.
    </p>
");

            if ($email->send()) {
                $db->table('room_waitlist')
                    ->where('id', $row['id'])
                    ->update(['notified' => 1]);
            } else {
                log_message('error', $email->printDebugger());
            }

            $email->clear();
        }

        return redirect()->back()->with('success', 'تم إلغاء الحجز بنجاح');
    }
}
