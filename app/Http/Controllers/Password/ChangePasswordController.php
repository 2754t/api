<?php

declare(strict_types=1);

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Http\Requests\Password\ChangePasswordRequest;
use App\UseCase\Actions\Password\ChangePasswordAction;
use App\UseCase\Exceptions\UseCaseException;

/**
 * パスワードリマインダー : パスワード再設定
 */
class ChangePasswordController extends Controller
{
    public function __invoke(ChangePasswordRequest $request, ChangePasswordAction $action): void
    {
        $token = $request->input('password_token');
        $password = $request->input('password');

        try {
            $action($token, $password);
        } catch (UseCaseException $e) {
            abort(400, $e->getMessage());
        }
    }
}
