<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Models\Player;

class FindController extends Controller
{
    public function __invoke(Player $player): PlayerResource
    {
        return new PlayerResource($player->load('team'));
    }
}
