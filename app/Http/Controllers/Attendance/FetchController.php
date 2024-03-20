<?php

namespace App\Http\Controllers\Attendance;

use App\Enums\Answer;
use App\Enums\Position;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Attendance;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class FetchController extends Controller
{
    public function __invoke(): Collection
    {
        $login_player = Auth::guard('player')->user();

        $activity = Activity::query()
            ->where('team_id', $login_player->team_id)
            ->where('activity_date', '>', today())
            ->where('is_order', true)
            ->firstOrFail();

        $attendances = Attendance::query()
            ->with(['player', 'starting_member'])
            ->where('activity_id', $activity->id)
            ->where('answer', Answer::YES)
            ->get();

        $attendances->each(function (Attendance $attendance) {
            $position = $attendance->starting_member->position ? $attendance->starting_member->position->label() : '控';
            $second_position = $attendance->second_position ? $attendance->second_position->label() : "";
            var_dump(
                $attendance->starting_member->batting_order . '番 ' .
                    $attendance->player->last_name . ' ' .
                    $position . ' ' .
                    $second_position
            );
        });
        die();

        // TODO resourceつくる
        return $attendances;
    }
}
