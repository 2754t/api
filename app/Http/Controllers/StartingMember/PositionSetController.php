<?php

namespace App\Http\Controllers\StartingMember;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Services\StartingMemberService;

class PositionSetController extends Controller
{
    public function __invoke(StartingMemberService $service): void
    {
        $activity = Activity::find(1);
        $service->generate($activity);
    }
}
