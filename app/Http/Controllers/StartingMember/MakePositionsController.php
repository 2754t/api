<?php

namespace App\Http\Controllers\StartingMember;

use App\Enums\Answer;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\StartingMember;

class MakePositionsController extends Controller
{
    public function __invoke()
    {
        $attendances = Attendance::where('answer', Answer::YES)->get();

        $starting_member = new StartingMember();

        var_dump($starting_member);

        return ;
    }
}
