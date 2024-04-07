<?php

use App\Http\Controllers\Activity\FetchController as ActivityFetchController;
use App\Http\Controllers\Attendance\FetchController as AttendanceFetchController;
use App\Http\Controllers\Attendance\UpdateController;
use App\Http\Controllers\Player\FetchController;
use App\Http\Controllers\SignIn\SignInController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/signIn', SignInController::class);

Route::middleware(['auth:player'])->group(function () {
    Route::get('/player', FetchController::class);
    Route::get('/attendance', AttendanceFetchController::class);
    Route::get('/attendance/update', UpdateController::class);
});

Route::get('/activity', ActivityFetchController::class);
