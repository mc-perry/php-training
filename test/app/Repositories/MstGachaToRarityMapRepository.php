<?php

/**
 * Weightlist Repository
 */

namespace App\Repositories;

use App\Models\MstGachaToRarityMapModel;

class MstGachaToRarityMapRepository
{
    /**
     * Get list of rarity levels for gacha
     *
     * @return object
     */
    public function getMapForGacha(int $GachaId)
    {
        return MstGachaToRarityMapModel::where('gacha_id', $GachaId)->get()->toArray();
    }

    /**
     * Get list of rarity levels for gacha
     *
     * @param $GachaId
     * @return object
     */
    public function getMaximumRarityForGacha($GachaId)
    { 
        return MstGachaToRarityMapModel::where('gacha_id', $GachaId)->orderBy('card_rarity', 'DESC')->first()->toArray();
    }
}
