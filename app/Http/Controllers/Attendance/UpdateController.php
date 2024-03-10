<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Services\StartingMemberService;
use App\UseCase\Actions\Attendance\UpdateAction;
use App\UseCase\Exceptions\UseCaseException;

class UpdateController extends Controller
{
    public function __invoke(UpdateAction $action, StartingMemberService $service)
    {
        $activity = Activity::first();
        try {
            $action($activity, $service);
        } catch (UseCaseException $e) {
            abort(400, $e->getMessage(). "登録後に再度アクセスしてください。");
        }
    }
}