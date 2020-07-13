<?php

/**
 * Weightlist Repository
 */

namespace App\Repositories;

use App\Models\SingleshotGachaRarityWeightlistModel;

class MstGachaRarityWeightlistRepository
{
    /**
     * Get single gacha weightlist
     *
     * @return object
     */
    public function getSingleGachaWeightlist()
    {
        return MstGachaRarityWeightlistModel::all()->toArray();
    }
}
