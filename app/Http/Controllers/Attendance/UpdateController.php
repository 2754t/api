<?php

declare(strict_types=1);

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\UseCase\Actions\Attendance\UpdateAction;
use App\UseCase\Exceptions\UseCaseException;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Attendance $attendance, Request $request, UpdateAction $action): AttendanceResource
    {
        /** @var int */
        $answer = (int)$request->input('answer');
        /** @var string|null */
        $answer_due = $request->input('answer_due');
        try {
            $attendance = $action($attendance, $answer, $answer_due);
        } catch (UseCaseException $e) {
            abort(400, $e->getMessage());
        }

        return new AttendanceResource($attendance);
    }
}
