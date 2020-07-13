<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GachaToRarityMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the data
        DB::table('gacha_to_rarity_map')->truncate();

        DB::table('gacha_to_rarity_map')->insert([
            [
                'gacha_id' => 1,
                'card_rarity' => 1,
            ],
            [
                'gacha_id' => 1,
                'card_rarity' => 2,
            ],
            [
                'gacha_id' => 1,
                'card_rarity' => 3,
            ],
            [
                'gacha_id' => 2,
                'card_rarity' => 2,
            ],
            [
                'gacha_id' => 2,
                'card_rarity' => 3,
            ],
        ]);
    }
}
