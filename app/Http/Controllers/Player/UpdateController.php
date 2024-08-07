<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\Player\UpdateRequest;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\UseCase\Actions\Player\UpdateAction;
use App\UseCase\Params\Player\UpdateParam;

class UpdateController extends Controller
{
    public function __invoke(Player $player, UpdateRequest $request, UpdateAction $action): PlayerResource
    {
        // TODO リクエスト バリデーション
        $param = new UpdateParam($request);

        return new PlayerResource($action($param, $player));
    }
}
