<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // コマンドを使用してバッチデータを挿入する
        $schedule->command('batchdata:insert')
            ->everyTenMinutes()
            ->withoutOverlapping()
            ->appendOutputTo('/tmp/cron.log');

        // 90分より古いパーティションを削除する
        $schedule->command('batchdata:deletepartition')
            ->hourlyAt(0)
            ->hourlyAt(10)
            ->hourlyAt(20)
            ->withoutOverlapping()
            ->appendOutputTo('/tmp/cron.log');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
