<?php

declare(strict_types=1);

use App\Http\Controllers\Activity\FetchController as ActivityFetchController;
use App\Http\Controllers\Attendance\FetchController as AttendanceFetchController;
use App\Http\Controllers\Attendance\UpdateController;
use App\Http\Controllers\Password\ChangePasswordController;
use App\Http\Controllers\Password\SendMailController;
use App\Http\Controllers\Password\UpdateController as PasswordUpdateController;
use App\Http\Controllers\Password\VerifyTokenController;
use App\Http\Controllers\Player\FetchController;
use App\Http\Controllers\Player\FindController;
use App\Http\Controllers\Player\UpdateController as PlayerUpdateController;
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
// パスワードリマインダー : メール認証
Route::post('/password-reminder', SendMailController::class);
// パスワードリマインダー : トークン確認
Route::get('/password-reminder/{token}', VerifyTokenController::class);
// パスワードリマインダー : パスワード再設定
Route::post('/password-reminder/reset', ChangePasswordController::class);

// 活動取得
Route::get('/activity', ActivityFetchController::class);
// 出欠取得
Route::get('/attendance/{activity}', AttendanceFetchController::class)->whereNumber('activity');

Route::middleware(['auth:player'])->group(function () {
    // ログイン中ユーザのパスワード変更
    Route::put('/password', PasswordUpdateController::class);
    // 選手
    Route::get('/player', FetchController::class);
    Route::get('/player/{player}', FindController::class)->whereNumber('player');
    Route::put('/player/{player}', PlayerUpdateController::class)->whereNumber('player');
    // 出欠更新
    Route::put('/attendance/{attendance}', UpdateController::class)->whereNumber('attendance');
    // スタメン取得
    Route::get('/starting-member/{activity}', StartingMemberFetchController::class)->whereNumber('activity');
});

// テスト用スタメン決め
Route::get("starting-member/update", StartingMemberUpdateController::class);
