<?php

declare(strict_types=1);

namespace App\UseCase\Actions\Player;

use App\Models\Player;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FetchAction
{
    public function __invoke(): LengthAwarePaginator
    {
        // TODO team_id
        return Player::query()
            ->with('team')
            ->where('team_id', 1)
            ->orderBy('role')
            ->orderByDesc('pitcher_flag')
            ->orderByDesc('catcher_flag')
            ->paginate(20);
    }
}
