<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MasterConsecutiveGachaDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データのクリア
        DB::table('mst_consecutive_gacha')->truncate();

        DB::table('mst_consecutive_gacha')->insert([
            [
                'gacha_card_count' => 6,
                'maximum_rarity' => 2,
            ],
        ]);
    }
}
