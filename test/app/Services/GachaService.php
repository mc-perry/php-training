<?php

/**
 * Gacha Service
 */

namespace App\Services;

use App\Facades\Error;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\CreateGachaRequest;

class GachaService
{
    public $rarity_map = [
        1 => 'SR',
        2 => 'R',
        3 => 'N',
    ];

    public function __construct()
    { }

    function createGacha(CreateGachaRequest $request)
    {
        $gachaCard = ['id' => intval($request->id)];

        // Generates a random number between 0 and 1
        $randNum = mt_rand() / mt_getrandmax();

        if ($randNum >= 0 && $randNum < 0.6) {
            $rarityLevel = 3;
        } elseif ($randNum >= 0.6 && $randNum < 0.9) {
            $rarityLevel = 2;
        } else {
            $rarityLevel = 1;
        }

        var_dump($rarityLevel);
    }
}
