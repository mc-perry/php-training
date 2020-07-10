<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MstCardDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データのクリア
        DB::table('master_card_data')->truncate();

        DB::table('master_card_data')->insert([
            [
                'card_name' => 'Bulbasaur',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Ivysaur',
                'rarity' => '2',
            ],
            [
                'card_name' => 'Venusaur',
                'rarity' => '1',
            ],
            [
                'card_name' => 'Charmander',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Charmeleon',
                'rarity' => '2',
            ],
            [
                'card_name' => 'Charizard',
                'rarity' => '1',
            ],
            [
                'card_name' => 'Squirtle',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Wartortle',
                'rarity' => '2',
            ],
            [
                'card_name' => 'Blastoise',
                'rarity' => '1',
            ],
            [
                'card_name' => 'Caterpie',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Metapod',
                'rarity' => '2',
            ],
            [
                'card_name' => 'Butterfree',
                'rarity' => '1',
            ],
            [
                'card_name' => 'Weedle',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Kakuna',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Beedrill',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Pidgey',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Pidgeotto',
                'rarity' => '2',
            ],
            [
                'card_name' => 'Pidgeot',
                'rarity' => '1',
            ],
            [
                'card_name' => 'Rattata',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Raticate',
                'rarity' => '2',
            ],
            [
                'card_name' => 'Spearow',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Fearow',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Ekans',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Arbok',
                'rarity' => '3',
            ],
            [
                'card_name' => 'Pikachu',
                'rarity' => '1',
            ],
            [
                'card_name' => 'Raichu',
                'rarity' => '4',
            ],
            [
                'card_name' => 'Sandshrew',
                'rarity' => '4',
            ],
            [
                'card_name' => 'Sandslash',
                'rarity' => '5',
            ],
            [
                'card_name' => 'Nidoran',
                'rarity' => '5',
            ],
            [
                'card_name' => 'Nidorina',
                'rarity' => '5',
            ],
        ]);
    }
}
