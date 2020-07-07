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

    function createGacha()
    {
        $randNum = mt_rand() / mt_getrandmax();
        var_dump($randNum);
    }
}
