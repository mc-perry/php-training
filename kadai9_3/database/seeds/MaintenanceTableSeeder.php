<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MaintenanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the data
        DB::table('maintenance')->truncate();
        DB::table('maintenance')->insert(
            [
                'start' => Carbon::parse('2018-01-22 04:09:31')->timezone('Asia/Kolkata')->toDateTimeString(),
                'end' => Carbon::parse('2020-07-01 04:09:31')->timezone('Asia/Kolkata')->toDateTimeString()
            ]
        );
    }
}
