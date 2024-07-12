<?php

namespace App\Http\Controllers\StartingMember;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\UseCase\Actions\StartingMember\UpdateAction;

class UpdateController extends Controller
{
    public function __invoke(UpdateAction $action)
    {
        $action(Activity::find('2'));
    }
}
