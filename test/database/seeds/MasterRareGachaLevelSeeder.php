<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MasterRareGachaLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データのクリア
        DB::table('master_rare_gacha_level')->truncate();

        DB::table('master_rare_gacha_level')->insert([
            [
                'maximum_rarity' => 3,
            ],
        ]);
    }
}
