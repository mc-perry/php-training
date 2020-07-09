<?php

/**
 * Gacha Master Data Repository
 */

namespace App\Repositories;

use App\Models\MasterCardDataModel;

class MasterCardDataRepository
{
    /**
     * Get all cards with given rarity level
     *
     * @return Array
     */
    public function getCardsWithRarityLevel(int $rarityLevel)
    {
        return MasterCardDataModel::where('rarity', $rarityLevel)->get()->toArray();
    }
}
