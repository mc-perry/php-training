<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MstGachaToRarityMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the data
        DB::table('mst_gacha_to_rarity_map')->truncate();

        DB::table('mst_gacha_to_rarity_map')->insert([
            [
                'gacha_id' => 1,
                'card_rarity' => 1,
                'weight' => 20
            ],
            [
                'gacha_id' => 1,
                'card_rarity' => 2,
                'weight' => 40
            ],
            [
                'gacha_id' => 2,
                'card_rarity' => 2,
                'weight' => 30
            ],
            [
                'gacha_id' => 2,
                'card_rarity' => 3,
                'weight' => 60
            ],
            [
                'gacha_id' => 3,
                'card_rarity' => 3,
                'weight' => 40
            ],
            [
                'gacha_id' => 3,
                'card_rarity' => 4,
                'weight' => 80
            ],
        ]);
    }
}
