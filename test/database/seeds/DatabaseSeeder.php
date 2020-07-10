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
        $this->call(ConsecutiveGachaRarityWeightlistSeeder::class);
        $this->call(MaintenanceTableSeeder::class);
        $this->call(MasterConsecutiveGachaDataSeeder::class);
        $this->call(MstCardDataTableSeeder::class);
        $this->call(SingleshotGachaRarityWeightlistSeeder::class);
        $this->call(UserMasterDataSeeder::class);
    }
}
