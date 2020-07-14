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
        $this->call(GachaMasterInfoSeeder::class);
        $this->call(GachaToRarityMapSeeder::class);
        $this->call(MasterCardDataTableSeeder::class);
        $this->call(RarityToCardMapSeeder::class);
    }
}
