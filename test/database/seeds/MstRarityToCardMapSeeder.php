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
                'singleshot_weight' => 20,
                'tentimes_weight' => 20
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 1,
                'card_id' => 6,
                'singleshot_weight' => 20,
                'tentimes_weight' => 20
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 2,
                'card_id' => 2,
                'singleshot_weight' => 20,
                'tentimes_weight' => 20
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 2,
                'card_id' => 5,
                'singleshot_weight' => 20,
                'tentimes_weight' => 20
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 3,
                'card_id' => 1,
                'singleshot_weight' => 20,
                'tentimes_weight' => 20
            ],
            [
                'gacha_id' => 1,
                'rarity_level' => 3,
                'card_id' => 7,
                'singleshot_weight' => 20,
                'tentimes_weight' => 20
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 1,
                'card_id' => 9,
                'singleshot_weight' => 20,
                'tentimes_weight' => 20
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 1,
                'card_id' => 12,
                'singleshot_weight' => 20,
                'tentimes_weight' => 20
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 2,
                'card_id' => 8,
                'singleshot_weight' => 20,
                'tentimes_weight' => 20
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 3,
                'card_id' => 13,
                'singleshot_weight' => 20,
                'tentimes_weight' => 20
            ],
            [
                'gacha_id' => 2,
                'rarity_level' => 3,
                'card_id' => 14,
                'singleshot_weight' => 20,
                'tentimes_weight' => 20
            ],
        ]);
    }
}
