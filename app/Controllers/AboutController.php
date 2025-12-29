<?php

namespace App\Controllers;

class AboutController extends BaseController
{
    public function index()
    {
        return view('layout/header')
            . view('about/index')
            . view('layout/footer');
    }
}
