<?php

/**
 * Weightlist Repository
 */

namespace App\Repositories;

use App\Models\MstCardRarityWeightlistModel;

class MstCardRarityWeightlistRepository
{
    /**
     * Get single Card weightlist
     *
     * @return object
     */
    public function getSingleCardWeightlist()
    {
        return MstCardRarityWeightlistModel::all()->toArray();
    }
}
