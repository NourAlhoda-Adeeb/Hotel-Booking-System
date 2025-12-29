<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'room_id',
        'full_name',
        'phone',
        'checkin',
        'checkout',
        'total_price',
        'payment_method',
        'card_name',
        'card_number',
        'cvv',
        'exp_date',
        'status'
    ];

    protected $useTimestamps = false; // 🔥 هذا هو الحل
}
