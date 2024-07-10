<?php

declare(strict_types=1);

use App\Http\Controllers\Activity\FetchController as ActivityFetchController;
use App\Http\Controllers\Attendance\OrderFetchController;
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

// 権限制御なし
// ログイン
Route::post('/signIn', SignInController::class);
// 活動
Route::get('/activity', ActivityFetchController::class);
// オーダー(出欠テーブルより)
Route::get('/order', OrderFetchController::class);

// 選手登録必要
Route::middleware(['auth:player'])->group(function () {
    // 選手
    Route::get('/player', FetchController::class);
    // テスト用スタメン決め
    Route::get("attendance/update", UpdateController::class);
});
