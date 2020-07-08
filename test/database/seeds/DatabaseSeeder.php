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
        $this->call(MstGachaTableSeeder::class);
        $this->call(UserMasterDataSeeder::class);
    }
}
