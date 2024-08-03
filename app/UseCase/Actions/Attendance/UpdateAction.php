<?php

namespace App\UseCase\Actions\Attendance;

use App\Enums\Answer;
use App\Models\Attendance;
use Illuminate\Support\Carbon;

class UpdateAction
{
    public function __invoke(Attendance $attendance, Answer $answer, ?Carbon $answer_due, ?Carbon $activity_datetime): Attendance
    {
        $attendance->answer = $answer;
        if (
            in_array($attendance->answer, [Answer::YES, Answer::CONDITIONALYES]) &&
            !$attendance->answer_yes_datetime
        ) {
            $attendance->answer_yes_datetime = now();
        }
        // answer変更なしで末日の時、リクエストのanswer_dueが前日になる可能性あるが考慮していない
        if (
            $attendance->answer === Answer::DUEDATE &&
            $answer_due &&
            $attendance->answer_due !== $answer_due
        ) {
            $attendance->answer_due = $answer_due;
            if (
                $attendance->answer_due->addWeek(2) > $activity_datetime ||
                $attendance->answer_due < now()
            ) {
                $attendance->penalty++;
            }
        }
        if (
            $attendance->answer_yes_datetime &&
            in_array($attendance->answer, [Answer::NO, Answer::DUEDATE]) &&
            $attendance->answer_yes_datetime->addDay(3) < now()
        ) {
            $attendance->penalty++;
            $attendance->answer_yes_datetime = null;
        }

        $attendance->save();

        return $attendance;
    }
}
