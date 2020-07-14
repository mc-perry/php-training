<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GachaMasterInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the data
        DB::table('gacha_master_info')->truncate();

        DB::table('gacha_master_info')->insert([
            [
                'gacha_id' => 1,
                'number_of_cards' => 10,
                'maximum_rarity' => 2
            ],
            [
                'gacha_id' => 2,
                'number_of_cards' => 10,
                'maximum_rarity' => 3
            ],
            [
                'gacha_id' => 3,
                'number_of_cards' => 10,
                'maximum_rarity' => 4
            ],
        ]);
    }
}
