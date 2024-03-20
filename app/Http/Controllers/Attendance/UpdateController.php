<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Services\StartingMemberService;
use App\UseCase\Actions\Attendance\UpdateAction;
use App\UseCase\Exceptions\UseCaseException;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{
    public function __invoke(UpdateAction $action, StartingMemberService $service, Activity $activity)
    {
        // TODO 実装できたら不要
        $activity = Activity::first();

        $login_player = Auth::guard('player')->user();

        if ($login_player->team_id !== $activity->team_id) {
            abort(404);
        }

        try {
            $action($activity, $service);
        } catch (UseCaseException $e) {
            abort(400, $e->getMessage() . "登録後に再度アクセスしてください。");
        }
    }
}
