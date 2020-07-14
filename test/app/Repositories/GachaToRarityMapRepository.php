<?php

/**
 * Weightlist Repository
 */

namespace App\Repositories;

use App\Models\GachaToRarityMapModel;

class GachaToRarityMapRepository
{
    /**
     * Get list of rarity levels for gacha
     *
     * @return object
     */
    public function getRarityLevelsForGacha(int $GachaId)
    {
        return GachaToRarityMapModel::where('gacha_id', $GachaId)->toArray();
    }
}
