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
        $this->call(CardRarityWeightlistSeeder::class);
        $this->call(MaintenanceTableSeeder::class);
        $this->call(MstCardDataTableSeeder::class);
        $this->call(UserMasterDataSeeder::class);
        $this->call(MasterRareGachaLevelSeeder::class);
    }
}
