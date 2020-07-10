<?php

/**
 * Weightlist Repository
 */

namespace App\Repositories;

use App\Models\ConsecutiveGachaRarityWeightlistModel;

class ConsecutiveGachaRarityWeightlistRepository
{
    /**
     * Get weightlist
     *
     * @return object
     */
    public function getWeightlist()
    {
        return ConsecutiveGachaRarityWeightlistModel::all()->toArray();
    }
}
