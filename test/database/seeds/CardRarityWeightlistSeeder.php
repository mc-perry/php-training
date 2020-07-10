<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CardRarityWeightlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the data
        DB::table('card_rarity_weightlist')->truncate();

        DB::table('card_rarity_weightlist')->insert([
            [
                'rarity_level' => 1,
                'rarity_level_weight' => 10
            ],
            [
                'rarity_level' => 2,
                'rarity_level_weight' => 30
            ],
            [
                'rarity_level' => 3,
                'rarity_level_weight' => 60
            ],
            [
                'rarity_level' => 4,
                'rarity_level_weight' => 100
            ],
            [
                'rarity_level' => 5,
                'rarity_level_weight' => 150
            ],
        ]);
    }
}
