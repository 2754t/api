<?php

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
    Route::get('/players', FetchController::class);
});