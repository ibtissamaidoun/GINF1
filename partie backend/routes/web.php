<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\VerificationController;

Route::controller(VerificationController::class)->group(function () {
    Route::post('email/verify/resend ', 'resend')->name('verification.resend');
    Route::get('email/verify', 'notice')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'verify')->name('verification.verify');
});
//Route::post('email/verify/resend', 'VerificationController@resend')->name('verification.resend');

