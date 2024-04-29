<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\UseCase\Actions\Attendance\UpdateAction;

class UpdateController extends Controller
{
    public function __invoke(UpdateAction $action)
    {
        $action(Activity::orderByDesc('activity_date')->first());
    }
}
