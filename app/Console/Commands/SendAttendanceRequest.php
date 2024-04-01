<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendAttendanceRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-attendance-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 活動のメール送信済フラグがfalseを取得
        // ループ処理
        // 10名になるように管理者と出席率高の選手にメールを送る。
        // 出欠トランを作成
        // 出欠トランの出席数が活動トランの募集人数
    }
}
