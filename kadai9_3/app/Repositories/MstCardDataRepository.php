<?php

/**
 * Gacha Master Data Repository
 */

namespace App\Repositories;

use App\Models\MstCardDataModel;

class MstCardDataRepository
{
    /**
     * Get all cards with given rarity level
     *
     * @return Array
     */
    public function getCardsWithRarityLevel(int $rarityLevel)
    {
        return MstCardDataModel::where('rarity', $rarityLevel)->get()->toArray();
    }
}
