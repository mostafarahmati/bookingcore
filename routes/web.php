<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Test\ReservationServiceDemoController;

Route::get('/test/reservation-service', [ReservationServiceDemoController::class, 'index'])
    ->name('test.reservation-service')
    ->middleware('web');

Route::get('/', function () {
    return view('welcome');
});
