<?php

/**
 * Weightlist Repository
 */

namespace App\Repositories;

use App\Models\GachaRarityWeightlistModel;

class GachaRarityWeightlistRepository
{
    /**
     * Get weightlist
     *
     * @return object
     */
    public function getWeightlist()
    {
        return GachaRarityWeightlistModel::all()->toArray();
    }
}
