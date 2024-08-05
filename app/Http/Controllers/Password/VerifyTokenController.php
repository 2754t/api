<?php

declare(strict_types=1);

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\UseCase\Actions\Password\VerifyTokenAction;
use App\UseCase\Exceptions\UseCaseException;
use Illuminate\Http\JsonResponse;

/**
 * パスワードリマインダー : トークン確認
 */
class VerifyTokenController extends Controller
{
    public function __invoke(string $token, VerifyTokenAction $action): JsonResponse
    {
        try {
            $action($token);

            return response()->json(['success' => true]);
        } catch (UseCaseException $e) {
            abort(400, $e->getMessage());
        }
    }
}
