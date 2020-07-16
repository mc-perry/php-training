<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MstGachaInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the data
        DB::table('mst_gacha_info')->truncate();

        DB::table('mst_gacha_info')->insert([
            [
                'gacha_id' => 1,
                'number_of_cards' => 10,
                'minimum_rarity_lastgacha' => 2
            ],
            [
                'gacha_id' => 2,
                'number_of_cards' => 5,
                'minimum_rarity_lastgacha' => 1
            ],
            [
                'gacha_id' => 3,
                'number_of_cards' => 20,
                'minimum_rarity_lastgacha' => 3
            ],
        ]);
    }
}
