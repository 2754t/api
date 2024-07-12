<?php

namespace App\Http\Controllers\StartingMember;

use App\Http\Controllers\Controller;
use App\Http\Resources\StartingMemberResource;
use App\Models\StartingMember;

class FetchController extends Controller
{
    public function __invoke()
    {
        $activity_id = 2;
        // TODO getすると一度全権取得してしまう
        $starting_members = StartingMember::query()
            ->with(['attendance.player'])
            ->get()
            ->filter(function (StartingMember $starting_member) use ($activity_id) {
                return $starting_member->attendance->activity_id === $activity_id;
            });

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
