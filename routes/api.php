<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('book', [ReservationController::class, 'store']);
    Route::get('search', [ReservationController::class, 'availableSeats']);
    Route::post('start-reservation', [ReservationController::class, 'start']);
    Route::get('check', [ReservationController::class, 'check']);
});
Route::get('trips', [TripController::class, 'index']);
Route::post('trip', [TripController::class, 'store']);
Route::post('login', [LoginController::class, 'login']);