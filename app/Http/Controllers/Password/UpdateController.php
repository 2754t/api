<?php

declare(strict_types=1);

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Http\Requests\Password\UpdateRequest;
use App\Http\Resources\SignInPlayerResource;
use App\Models\Player;
use App\UseCase\Actions\Password\UpdateAction;
use App\UseCase\Params\Password\UpdateParam;

/**
 *  ログイン中ユーザのパスワード変更
 */
class UpdateController extends Controller
{
    public function __invoke(
        UpdateRequest $request,
        UpdateAction $action,
    ): SignInPlayerResource {
        /** @var Player|null */
        $player = auth()->guard('player')->user();

        if (!$player) {
            abort(400);
        }

        $param = new UpdateParam($request);
        $player = $action($param, $player);

        return new SignInPlayerResource($player);
    }
}
