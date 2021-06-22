<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Yclients\CompanyController;
use App\Http\Controllers\Yclients\BookingDateController;
use App\Http\Controllers\Yclients\OrderController;

use \App\Http\Controllers\Dadata\AddressController;
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

Route::middleware('api')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('/address', [AddressController::class, 'index']);

        Route::resource('/orders', OrderController::class)
            ->except(['edit', 'create']);

        Route::resource('/companies', CompanyController::class)
            ->only('index', 'show');

        Route::get('/companies/{company}/book_date/', [BookingDateController::class, 'index']);
        Route::get('/companies/{company}/book_date/{date}', [BookingDateController::class, 'show']);
    });
});
