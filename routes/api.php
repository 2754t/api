<?php

declare(strict_types=1);

use App\Http\Controllers\Activity\FetchController as ActivityFetchController;
use App\Http\Controllers\Attendance\FetchController as AttendanceFetchController;
use App\Http\Controllers\Attendance\UpdateController;
use App\Http\Controllers\Player\FetchController;
use App\Http\Controllers\SignIn\PasswordController;
use App\Http\Controllers\SignIn\SignInController;
use App\Http\Controllers\StartingMember\FetchController as StartingMemberFetchController;
use App\Http\Controllers\StartingMember\UpdateController as StartingMemberUpdateController;
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
// スタメン
Route::get('/starting-member/{activity}', StartingMemberFetchController::class)->whereNumber('activity');
// テスト用スタメン決め
Route::get("starting-member/update", StartingMemberUpdateController::class);
// 出欠
Route::get('/attendance/{activity}', AttendanceFetchController::class)->whereNumber('activity');
Route::put('/attendance/{attendance}', UpdateController::class)->whereNumber('attendance');


// TODO 仕分け 選手登録必要
Route::middleware(['auth:player'])->group(function () {
    // ログイン中ユーザのパスワード変更
    Route::put('/password', PasswordController::class);
    // 選手
    Route::get('/player', FetchController::class);
});
