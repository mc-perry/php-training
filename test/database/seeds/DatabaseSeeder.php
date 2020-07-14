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
        $this->call(MstCardDataTableSeeder::class);
        $this->call(MstGachaInfoSeeder::class);
        $this->call(MstGachaToRarityMapSeeder::class);
        $this->call(MstRarityToCardMapSeeder::class);
    }
}
