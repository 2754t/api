<?php

declare(strict_types=1);

namespace App\Http\Controllers\Attendance;

use App\Enums\Answer;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\UseCase\Actions\Attendance\UpdateAction;
use App\UseCase\Exceptions\UseCaseException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UpdateController extends Controller
{
    public function __invoke(Attendance $attendance, Request $request, UpdateAction $action): AttendanceResource
    {
        /** @var Answer */
        $answer = Answer::tryFrom($request->input('answer'));
        /** @var Carbon|null */
        $answer_due = $request->input('answer_due') ? Carbon::parse($request->input('answer_due')) : null;
        /** @var Carbon|null */
        $activity_datetime = $request->input('activity_datetime') ? Carbon::parse($request->input('activity_datetime')) : null;
        try {
            $attendance = $action($attendance, $answer, $answer_due, $activity_datetime);
        } catch (UseCaseException $e) {
            abort(400, $e->getMessage());
        }

        return new AttendanceResource($attendance);
    }
}
