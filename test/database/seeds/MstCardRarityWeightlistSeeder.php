<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MstCardRarityWeightlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the data
        DB::table('mst_card_rarity_weightlist')->truncate();

        DB::table('mst_card_rarity_weightlist')->insert([
            [
                'card_id' => 1,
                'card_rarity' => 1,
                'card_single_weight' => 20,
                'card_consecutive_weight' => 20,
            ],
            [
                'card_id' => 1,
                'card_rarity' => 2,
                'card_single_weight' => 80,
                'card_consecutive_weight' => 80,
            ],
            [
                'card_id' => 2,
                'card_rarity' => 1,
                'card_single_weight' => 20,
                'card_consecutive_weight' => 20,
            ],
            [
                'card_id' => 2,
                'card_rarity' => 2,
                'card_single_weight' => 80,
                'card_consecutive_weight' => 80,
            ],
            [
                'card_id' => 3,
                'card_rarity' => 1,
                'card_single_weight' => 20,
                'card_consecutive_weight' => 20,
            ],
            [
                'card_id' => 3,
                'card_rarity' => 2,
                'card_single_weight' => 80,
                'card_consecutive_weight' => 80,
            ],
            [
                'card_id' => 4,
                'card_rarity' => 1,
                'card_single_weight' => 20,
                'card_consecutive_weight' => 20,
            ],
            [
                'card_id' => 4,
                'card_rarity' => 2,
                'card_single_weight' => 80,
                'card_consecutive_weight' => 80,
            ],
            [
                'card_id' => 5,
                'card_rarity' => 1,
                'card_single_weight' => 20,
                'card_consecutive_weight' => 20,
            ],
            [
                'card_id' => 5,
                'card_rarity' => 2,
                'card_single_weight' => 80,
                'card_consecutive_weight' => 80,
            ],
        ]);
    }
}
