<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'room_number',
        'type',
        'price',
        'image',
        'status'
    ];

    protected $useTimestamps = true;

    /* ===============================
       الغرف المتاحة فقط
    =============================== */
    public function getAvailableRooms()
    {
        return $this->where('status', 'available')
            ->orderBy('room_number', 'ASC')
            ->findAll();
    }

    /* ===============================
       فلترة الغرف (سعر + حالة)
    =============================== */
    public function getFilteredRooms($minPrice = null, $maxPrice = null, $status = null)
    {
        $builder = $this;

        if ($minPrice !== null && $minPrice !== '') {
            $builder->where('price >=', $minPrice);
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $builder->where('price <=', $maxPrice);
        }

        if ($status) {
            $builder->where('status', $status);
        }

        return $builder->orderBy('room_number', 'ASC')->findAll();
    }
    public function getRoomsWithBookingCount($status = null)
    {
        $builder = $this->select('
            rooms.*,
            COUNT(bookings.id) AS bookings_count
        ')
            ->join(
                'bookings',
                'bookings.room_id = rooms.id AND bookings.status = "confirmed"',
                'left'
            )
            ->groupBy('rooms.id')
            ->orderBy('rooms.room_number', 'ASC');

        if ($status) {
            $builder->where('rooms.status', $status);
        }

        return $builder->findAll();
    }
    /*هادي متع الغرف في الادمن */
    public function getRoomsByFilter($status = null)
    {
        $builder = $this->select('
            rooms.*,
            COUNT(bookings.id) AS bookings_count
        ')
            ->join(
                'bookings',
                'bookings.room_id = rooms.id AND bookings.status = "confirmed"',
                'left'
            )
            ->groupBy('rooms.id')
            ->orderBy('rooms.room_number', 'ASC');

        // 🔹 الغرف المتاحة = لا يوجد لها حجز مؤكد
        if ($status === 'available') {
            $builder->having('bookings_count', 0);
        }

        // 🔹 الغرف المحجوزة = عندها حجز مؤكد واحد أو أكثر
        if ($status === 'booked') {
            $builder->having('bookings_count >', 0);
        }

        return $builder->findAll();
    }
}
