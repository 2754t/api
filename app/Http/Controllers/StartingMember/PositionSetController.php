<?php

namespace App\Http\Controllers\StartingMember;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Services\StartingMemberService;
use App\UseCase\Exceptions\UseCaseException;

class PositionSetController extends Controller
{
    public function __invoke(StartingMemberService $service): void
    {
        $activity = Activity::find(1);
        try {
            $service->generate($activity);
        } catch (UseCaseException $e) {
            abort(400, $e->getMessage(). "登録後に再度アクセスしてください。");
        }
    }
}
