<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\Activity;
use App\Models\Attendance;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FetchController extends Controller
{
    public function __invoke(Activity $activity): AnonymousResourceCollection
    {
        $attendances = Attendance::query()
            ->with('player')
            ->where('activity_id', $activity->id)
            ->get();

        return AttendanceResource::collection($attendances);
    }
}
