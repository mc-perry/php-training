<?php

/**
 * Gacha Master Data Repository
 */

namespace App\Repositories;

use App\Models\GachaMasterDataModel;

class GachaMasterDataRepository
{
    /**
     * Get all cards with given rarity level
     *
     * @return Array
     */
    public function getCardsWithRarityLevel(int $rarityLevel)
    {
        return GachaMasterDataModel::where('rarity', $rarityLevel)->get()->toArray();
    }
}
