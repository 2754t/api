<?php

namespace App\Console\Commands;

use App\Enums\ActivityType;
use App\Models\Activity;
use App\UseCase\Actions\StartingMember\UpdateAction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
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
            ->whereDate('activity_datetime', Carbon::today()->addDays(2))
            ->where('activity_type', ActivityType::GAME)
            ->where('confirmed_flag', true)
            ->get();

        Log::channel('starting_member')->info('Activity count: ' . $activities->count());
        $this->info('Activity count: ' . $activities->count());

        $activities->each(function (Activity $activity) use ($action) {
            Log::channel('starting_member')->info('Activity ID: ' . $activity->id);
            $this->info('Activity ID: ' . $activity->id);
            try {
                $action($activity);
                Log::channel('starting_member')->info('success');
                $this->info('Activity ID: ' . $activity->id . 'success');

                // } catch (AlreadyDecidedException $e) {
                //     // 何もしない
                // } catch (NotEnoughMembersException|NoPitcherException|NoCatcherException $e) {
                //     // チームの管理者宛に通知
            } catch (Throwable $e) {
                // ログを残す
                Log::channel('starting_member')->info(' failed');
                $this->info('Activity ID: ' . $activity->id . ' failed');
                report($e);
                // 管理者に通知
            }
        });
    }
}
