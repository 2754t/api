<?php

declare(strict_types=1);

namespace App\UseCase\Actions\Activity;

use App\Models\Activity;
use Illuminate\Support\Collection;

class FetchAction
{
    public function __invoke(int $year, int $month): Collection
    {
        // TODO team_idの判定方法考える
        return Activity::where('team_id', 1)
            ->whereYear('activity_datetime', $year)
            ->whereMonth('activity_datetime', $month)
            ->get();
    }
}
