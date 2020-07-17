<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertBatchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batchdata:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert batch data into database';

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
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $batchUserData = array();
        for ($x = 0; $x < 10; $x++) {
            $firstName = substr(str_shuffle($permitted_chars), 0, 10);
            $lastName = substr(str_shuffle($permitted_chars), 0, 10);
            array_push($batchUserData, ['first_name' => $firstName, 'last_name' => $lastName]);
        }

        return DB::table('jonathan_batch_test')->insert($batchUserData);
    }
}
