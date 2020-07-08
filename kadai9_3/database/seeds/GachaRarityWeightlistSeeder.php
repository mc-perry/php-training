<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GachaRarityWeightlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the data
        DB::table('gacha_rarity_weightlist')->truncate();

        DB::table('gacha_rarity_weightlist')->insert([
            [
                'id' => 1,
                'card_rarity' => 10
            ],
            [
                'id' => 2,
                'card_rarity' => 30
            ],
            [
                'id' => 3,
                'card_rarity' => 60
            ],
        ]);
    }
}
