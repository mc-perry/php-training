<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteBatchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batchdata:deletepartition';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete db partitions older than 90 minutes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        var_dump("hello world");
        $ninetyMinutesAgo = 5;
        return DB::table('jonathan_batch_test')->where('created_at', '<', $ninetyMinutesAgo)->delete();
    }
}
