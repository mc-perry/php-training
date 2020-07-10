<?php

/**
 * User Gacha Cards
 */

namespace App\Repositories;

use App\Http\Resources\User;
use App\Models\MasterRareGachaLevelModel;
use App\Facades\Error;

class MasterRareGachaLevelRepository
{
    /**
     * Get maximum rarity level for consecutive gachas
     *
     * @return integer
     */
    public function getMaximumRareGachaRarityLevel()
    {
        return MasterRareGachaLevelModel::query()->first()['maximum_rarity'];
    }
}
