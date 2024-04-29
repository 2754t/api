<?php

namespace App\Http\Controllers\Attendance;

use App\Enums\Answer;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\Activity;
use App\Models\Attendance;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class FetchController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        $login_player = Auth::guard('player')->user();

        $activity = Activity::query()
            ->where('team_id', $login_player->team_id)
            ->orderByDesc('activity_date')
            ->firstOrFail();

        $attendances = Attendance::query()
            ->with(['player', 'starting_member'])
            ->where('activity_id', $activity->id)
            ->where('answer', Answer::YES)
            ->get();

        // $attendances->each(function (Attendance $attendance) {
        //     $position = $attendance->starting_member->position ? $attendance->starting_member->position->label() : '控';
        //     $second_position = $attendance->second_position ? $attendance->second_position->label() : "";
        //     var_dump(
        //         $attendance->starting_member->batting_order . '番 ' .
        //             $attendance->player->last_name . ' ' .
        //             $position . ' ' .
        //             $second_position
        //     );
        // });

        // 打順で並べ替え
        $attendances = $attendances->sortBy(function (Attendance $attendance) {
            return $attendance->starting_member->batting_order;
        });

        return AttendanceResource::collection($attendances);
    }
}
