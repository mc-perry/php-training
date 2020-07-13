<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MstGachaRarityWeightlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the data
        DB::table('mst_gacha_rarity_weightlist')->truncate();

        DB::table('mst_gacha_rarity_weightlist')->insert([
            [
                'gacha_id' => 1,
                'gacha_weight' => 20
            ],
            [
                'gacha_id' => 1,
                'gacha_weight' => 80
            ],
            [
                'gacha_id' => 2,
                'gacha_weight' => 20
            ],
            [
                'gacha_id' => 2,
                'gacha_weight' => 80
            ],
            [
                'gacha_id' => 3,
                'gacha_weight' => 20
            ],
            [
                'gacha_id' => 3,
                'gacha_weight' => 80
            ],
            [
                'gacha_id' => 4,
                'gacha_weight' => 20
            ],
            [
                'gacha_id' => 4,
                'gacha_weight' => 80
            ],
        ]);
    }
}
