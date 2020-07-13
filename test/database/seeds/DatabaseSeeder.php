<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MaintenanceTableSeeder::class);
        $this->call(MstCardDataTableSeeder::class);
        $this->call(MstCardRarityWeightlistSeeder::class);
        $this->call(MstConsecutiveGachaDataSeeder::class);
        $this->call(MstGachaRarityWeightlistSeeder::class);
        $this->call(UserMasterDataSeeder::class);
    }
}
