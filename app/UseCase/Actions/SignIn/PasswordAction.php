<?php

declare(strict_types=1);

namespace App\UseCase\Actions\SignIn;

use App\Models\Player;
use App\UseCase\Params\SignIn\PasswordParam;
use Illuminate\Support\Facades\Hash;

class PasswordAction
{
    public function __invoke(PasswordParam $param, Player $player): Player
    {
        $player->password = Hash::make($param->password);
        $player->save();

        return $player->load('team');
    }
}
