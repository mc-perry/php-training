<?php

/**
 * Weightlist Repository
 */

namespace App\Repositories;

use App\Models\CardRarityWeightlistModel;

class CardRarityWeightlistRepository
{
    /**
     * Get weightlist
     *
     * @return object
     */
    public function getWeightlist()
    {
        return CardRarityWeightlistModel::all()->toArray();
    }
}
