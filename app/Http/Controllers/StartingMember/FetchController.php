<?php

namespace App\Http\Controllers\StartingMember;

use App\Http\Controllers\Controller;
use App\Http\Resources\StartingMemberResource;
use App\Models\Activity;
use App\Models\StartingMember;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FetchController extends Controller
{
    public function __invoke(Activity $activity): AnonymousResourceCollection
    {
        $starting_members = StartingMember::query()
            ->whereHas('attendance', function ($query) use ($activity) {
                $query->where('activity_id', $activity->id);
            })
            ->with(['attendance.player'])
            ->get();

        if ($starting_members->isEmpty()) {
            abort('400', "選手がいません");
        }

        // 打順で並べ替え
        $starting_members = $starting_members->sortBy(function (StartingMember $starting_member) {
            return $starting_member->batting_order;
        });

        return StartingMemberResource::collection($starting_members);
    }
}
