<?php

namespace App\Console\Commands;

use App\Enums\ActivityType;
use App\Models\Activity;
use App\Services\StartingMemberService;
use App\UseCase\Actions\Attendance\UpdateAction;
use App\UseCase\Exceptions\UseCaseException;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Throwable;

class DecideStartingMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:decide-starting-members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(UpdateAction $action)
    {
        $activities = Activity::query()
            ->where('activity_date', today()->addDays(2))
            ->where('activity_type', ActivityType::GAME)
            ->where('confirmed_flag', true)
            ->get();

            $activities->each(function (Activity $activity) use ($action) {
                try {
                    $action($activity);
                // } catch (AlreadyDecidedException $e) {
                //     // 何もしない
                // } catch (NotEnoughMembersException|NoPitcherException|NoCatcherException $e) {
                //     // チームの管理者宛に通知
                } catch (Throwable $e) {
                    // ログを残す
                    report($e);
                    // 管理者に通知
                }
            });
    }
}
