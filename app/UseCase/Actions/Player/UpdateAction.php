<?php

declare(strict_types=1);

namespace App\UseCase\Actions\Player;

use App\Models\Player;
use App\UseCase\Params\Player\UpdateParam;

class UpdateAction
{
    public function __invoke(UpdateParam $param, Player $player): Player
    {
        $player->nickname = $param->nickname;
        $player->email = $param->email;
        $player->desired_position = $param->desired_position;
        $player->pitcher_flag = $param->pitcher_flag;
        $player->catcher_flag = $param->catcher_flag;
        $player->batting_order_bottom_flag = $param->batting_order_bottom_flag;
        $player->save();

        return $player->load('team');
    }
}
