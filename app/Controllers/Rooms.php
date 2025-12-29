<?php

namespace App\Controllers;
use App\Models\RoomModel;

class Rooms extends BaseController
{
    public function index()
    {
        $roomModel = new RoomModel();

        $minPrice = $this->request->getGet('min_price');
        $maxPrice = $this->request->getGet('max_price');

        $data['rooms'] = $roomModel->getFilteredRooms($minPrice, $maxPrice);
        $data['min_price'] = $minPrice;
        $data['max_price'] = $maxPrice;

        return view('rooms/index', $data);

    }
}
