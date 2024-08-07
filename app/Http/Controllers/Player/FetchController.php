<?php

declare(strict_types=1);

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\UseCase\Actions\Player\FetchAction;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FetchController extends Controller
{
    public function __invoke(FetchAction $action): AnonymousResourceCollection
    {
        /** @var Collection<Player> */
        $players = $action();

        return PlayerResource::collection($players);
    }
}
