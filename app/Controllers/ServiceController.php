<?php

namespace App\Controllers;

use App\Models\ServiceModel;

class ServiceController extends BaseController
{
    public function index()
    {
        $model = new ServiceModel();

        $data = [
            'arabic'  => $model->where(['category' => 'restaurant', 'cuisine' => 'arabic'])->findAll(),
            'asian'   => $model->where(['category' => 'restaurant', 'cuisine' => 'asian'])->findAll(),
            'french'  => $model->where(['category' => 'restaurant', 'cuisine' => 'french'])->findAll(),
            'italian' => $model->where(['category' => 'restaurant', 'cuisine' => 'italian'])->findAll(),
            'gym'     => $model->where('category', 'gym')->findAll(),
        ];

        return view('layout/header')
            . view('services/index', $data)
            . view('layout/footer');
    }
}
