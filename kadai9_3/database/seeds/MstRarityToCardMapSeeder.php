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
                'weight' => 20,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 1,
                'card_id' => 6,
                'weight' => 20,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 1,
                'card_id' => 9,
                'weight' => 30,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 1,
                'card_id' => 12,
                'weight' => 30,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 1,
                'card_id' => 18,
                'weight' => 40,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 1,
                'card_id' => 25,
                'weight' => 40,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 2,
                'card_id' => 2,
                'weight' => 20,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 2,
                'card_id' => 5,
                'weight' => 50,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 2,
                'card_id' => 8,
                'weight' => 20,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 2,
                'card_id' => 11,
                'weight' => 50,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 2,
                'card_id' => 17,
                'weight' => 50,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 3,
                'card_id' => 1,
                'weight' => 20,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 3,
                'card_id' => 7,
                'weight' => 30,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 3,
                'card_id' => 10,
                'weight' => 40,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 3,
                'card_id' => 13,
                'weight' => 50,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 3,
                'card_id' => 14,
                'weight' => 20,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 3,
                'card_id' => 15,
                'weight' => 30,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 3,
                'card_id' => 16,
                'weight' => 40,
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 3,
                'card_id' => 19,
                'weight' => 50,
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 1,
                'card_id' => 9,
                'weight' => 20,
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 1,
                'card_id' => 12,
                'weight' => 20,
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 2,
                'card_id' => 8,
                'weight' => 20,
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 3,
                'card_id' => 13,
                'weight' => 20,
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 3,
                'card_id' => 14,
                'weight' => 20,
            ],
        ]);
    }
}
