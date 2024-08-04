<?php

declare(strict_types=1);

namespace App\Http\Controllers\SignIn;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignIn\PasswordRequest;
use App\Http\Resources\SignInPlayerResource;
use App\Models\Player;
use App\UseCase\Actions\SignIn\PasswordAction;
use App\UseCase\Params\SignIn\PasswordParam;

/**
 *  ログイン中ユーザのパスワード変更
 */
class PasswordController extends Controller
{
    public function __invoke(
        PasswordRequest $request,
        PasswordAction $action,
    ): SignInPlayerResource {
        /** @var Player|null */
        $player = auth()->guard('player')->user();

        if (!$player) {
            abort(400);
        }

        $param = new PasswordParam($request);
        $player = $action($param, $player);

        return new SignInPlayerResource($player);
    }
}
