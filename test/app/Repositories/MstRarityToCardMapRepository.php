<?php

/**
 * Rarity To Card Map Repository
 */

namespace App\Repositories;

use App\Models\MstRarityToCardMapModel;

class MstRarityToCardMapRepository
{
    /**
     * Get all cards with given rarity level
     *
     * @return Array
     */
    public function getCardsWithRarityLevel(int $GachaId, int $rarityLevel)
    {
        return MstRarityToCardMapModel::where('gacha_id', $GachaId)->where('rarity_level', $rarityLevel)->get()->toArray();
    }

    /**
     * Get all cards with given rarity level
     *
     * @return Array
     */
    public function getCardsWithRarityLevelOrAbove(int $GachaId, int $rarityLevel)
    {
        return MstRarityToCardMapModel::where('gacha_id', $GachaId)->where('rarity_level', "<=", $rarityLevel)->get()->toArray();
    }
}
