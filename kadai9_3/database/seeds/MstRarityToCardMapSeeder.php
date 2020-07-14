<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MstRarityToCardMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データのクリア
        DB::table('mst_rarity_to_card_map')->truncate();

        DB::table('mst_rarity_to_card_map')->insert([
            [
                'gacha_id' => 1,
                'rarity_level' => 1,
                'card_id' => 3,
                'card_weight' => 40,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 1,
                'card_id' => 6,
                'card_weight' => 60,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 2,
                'card_id' => 2,
                'card_weight' => 100,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 2,
                'card_id' => 5,
                'card_weight' => 20,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 3,
                'card_id' => 1,
                'card_weight' => 80,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 3,
                'card_id' => 7,
                'card_weight' => 20,
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 1,
                'card_id' => 9,
                'card_weight' => 30,
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 1,
                'card_id' => 12,
                'card_weight' => 70,
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 2,
                'card_id' => 8,
                'card_weight' => 100,
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 3,
                'card_id' => 13,
                'card_weight' => 50,
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 3,
                'card_id' => 14,
                'card_weight' => 50,
            ],
        ]);
    }
}
