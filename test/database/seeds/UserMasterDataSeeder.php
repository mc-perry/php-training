<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserMasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the data
        DB::table('user_master_data')->truncate();

        DB::table('user_master_data')->insert([
            [
                'id' => 1,
                'exp' => 0
            ],
            [
                'id' => 2,
                'exp' => 10
            ],
            [
                'id' => 3,
                'exp' => 40
            ],
            [
                'id' => 4,
                'exp' => 80
            ],
            [
                'id' => 5,
                'exp' => 150
            ],
            [
                'id' => 6,
                'exp' => 200
            ],
            [
                'id' => 7,
                'exp' => 260
            ],
            [
                'id' => 8,
                'exp' => 500
            ],
            [
                'id' => 9,
                'exp' => 650
            ],
            [
                'id' => 10,
                'exp' => 900
            ]
        ]);
    }
}
