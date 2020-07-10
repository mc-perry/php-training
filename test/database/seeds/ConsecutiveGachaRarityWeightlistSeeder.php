<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ConsecutiveGachaRarityWeightlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the data
        DB::table('consecutive_gacha_rarity_weightlist')->truncate();

        DB::table('consecutive_gacha_rarity_weightlist')->insert([
            [
                'rarity_level' => 1,
                'rarity_level_weight' => 20
            ],
            [
                'rarity_level' => 2,
                'rarity_level_weight' => 40
            ],
            [
                'rarity_level' => 3,
                'rarity_level_weight' => 50
            ],
            [
                'rarity_level' => 4,
                'rarity_level_weight' => 120
            ],
            [
                'rarity_level' => 5,
                'rarity_level_weight' => 150
            ],
        ]);
    }
}
