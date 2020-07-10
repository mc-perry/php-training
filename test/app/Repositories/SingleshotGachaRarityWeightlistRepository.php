<?php

/**
 * Weightlist Repository
 */

namespace App\Repositories;

use App\Models\SingleshotGachaRarityWeightlistModel;

class SingleshotGachaRarityWeightlistRepository
{
    /**
     * Get weightlist
     *
     * @return object
     */
    public function getWeightlist()
    {
        return SingleshotGachaRarityWeightlistModel::all()->toArray();
    }
}
