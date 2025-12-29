<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/* ================= PUBLIC ================= */

$routes->get('/', 'Home::index');
$routes->get('rooms', 'Rooms::index');

$routes->get('services', 'ServiceController::index');
$routes->get('about', 'AboutController::index');

/* ================= AUTH ================= */

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::loginProcess');
$routes->get('logout', 'AuthController::logout');

$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::registerProcess');

/* ================= PROFILE ================= */

$routes->get('profile', 'ProfileController::index');
$routes->post('profile/update', 'ProfileController::update');
$routes->get('profile/cancel/(:num)', 'ProfileController::cancelBooking/$1');

/* ================= BOOKING ================= */

$routes->get('booking/(:num)', 'BookingController::create/$1');
$routes->post('booking/store', 'BookingController::store');
$routes->get('booking-confirmed', 'BookingController::confirmed');
$routes->post('booking/notify', 'BookingController::notify');
$routes->get('booking/cancel/(:num)', 'BookingController::cancel/$1');

/* ================= ADMIN ================= */

$routes->group('admin', ['filter' => 'adminAuth'], function ($routes) {

    $routes->get('/', 'Admin\DashboardController::index');
    $routes->get('dashboard', 'Admin\DashboardController::index');



    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/delete/(:num)', 'Admin\UserController::delete/$1');
    $routes->get('users/role/(:num)', 'Admin\UserController::changeRole/$1');
    $routes->post('users/update', 'Admin\UserController::update');


    $routes->get('rooms', 'Admin\RoomController::index');
    $routes->post('rooms/store', 'Admin\RoomController::store');
    $routes->get('rooms/edit/(:num)', 'Admin\RoomController::edit/$1');
    $routes->post('rooms/update', 'Admin\RoomController::update');
    $routes->get('rooms/delete/(:num)', 'Admin\RoomController::delete/$1');
    $routes->get('bookings', 'Admin\BookingController::index');
    $routes->get('payments', 'Admin\PaymentController::index');
    $routes->get('rooms/create', 'Admin\RoomController::create');
    $routes->get('reports/payments', 'Admin\PaymentReportController::index');
    $routes->get('reports/payments/pdf', 'Admin\PaymentReportController::exportPdf');
});
