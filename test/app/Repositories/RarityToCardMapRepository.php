<?php

/**
 * Rarity To Card Map Repository
 */

namespace App\Repositories;

use App\Models\RarityToCardMapModel;

class RarityToCardMapRepository
{
    /**
     * Get all cards with given rarity level
     *
     * @return Array
     */
    public function getCardsWithRarityLevel(int $GachaId, int $rarityLevel)
    {
        return RarityToCardMapModel::where('gacha_id', $GachaId)->where('rarity_level', $rarityLevel)->get()->toArray();
    }
}
