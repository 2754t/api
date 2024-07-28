<?php

namespace App\UseCase\Actions\Attendance;

use App\Models\Attendance;

class UpdateAction
{
    public function __invoke(Attendance $attendance, int $answer, ?string $answer_due): Attendance
    {
        $attendance->answer = $answer;
        $attendance->answer_due = $answer_due;
        $attendance->save();

        return $attendance;
    }
}
