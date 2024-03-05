<?php

declare(strict_types=1);

namespace App\UseCase\Actions\Activity;

use App\Http\Requests\Activity\CreateRequest;
use App\Models\Activity;

class CreateAction
{
    public function __invoke(CreateRequest $request)
    {
        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = $request->stadium_id;
        $activity->activity_date = $request->activity_date;
        $activity->play_time = $request->play_time;
        $activity->activity_type = $request->activity_type;
        $activity->confirmed_flag = $request->confirmed_flag;
        $activity->dh_type = $request->dh_type;
        $activity->entry_cost = $request->entry_cost;
        $activity->save();
    }
}