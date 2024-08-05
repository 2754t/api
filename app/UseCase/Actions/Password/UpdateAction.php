<?php

declare(strict_types=1);

namespace App\UseCase\Actions\Password;

use App\Models\Player;
use App\UseCase\Params\Password\UpdateParam;
use Illuminate\Support\Facades\Hash;

class UpdateAction
{
    public function __invoke(UpdateParam $param, Player $player): Player
    {
        $player->password = Hash::make($param->password);
        $player->save();

        return $player->load('team');
    }
}
