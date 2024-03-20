<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;

class FetchController extends Controller
{
    public function __invoke()
    {
        $login_player = Auth::guard('player')->user();

        $players = Player::where('team_id', $login_player->team_id)->paginate(20);
        // TODO リソース作って返す
        return $players;
    }
}
