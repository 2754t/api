<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Models\Player;

class FetchController extends Controller
{
    public function __invoke()
    {
        $players = Player::all();
        // TODO リソース作って返す
        return $players;
    }
}
