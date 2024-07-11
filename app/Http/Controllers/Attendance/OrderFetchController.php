<?php

namespace App\Http\Controllers\Attendance;

use App\Enums\Answer;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderFetchController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        $activity_id = 2;

        $attendances = Attendance::query()
            ->with(['player', 'starting_member'])
            ->where('activity_id', $activity_id)
            ->where('answer', Answer::YES)
            ->get();

        // 打順で並べ替え
        $attendances = $attendances->sortBy(function (Attendance $attendance) {
            return $attendance->starting_member->batting_order;
        });

        return AttendanceResource::collection($attendances);
    }
}
