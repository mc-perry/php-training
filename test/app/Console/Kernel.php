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
    protected $commands = [
        \App\Console\Commands\InsertBatchData::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // setup log file for affiliates
        $cronLog = storage_path('logs/cron.log');
        if (!Storage::exists($cronLog)) {
            Storage::makeDirectory($cronLog, '');
        }

        $schedule->call(function () {
            DB::table('user_gacha_cards')->delete();
        })->everyFiveMinutes()->appendOutputTo('/tmp/laravel.log');
        // コマンドを使用してバッチデータを挿入する
        $schedule->command('batchdata:insert')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->appendOutputTo($cronLog);
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
