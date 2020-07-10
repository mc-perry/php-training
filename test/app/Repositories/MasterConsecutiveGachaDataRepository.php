<?php

/**
 * User Gacha Cards
 */

namespace App\Repositories;

use App\Http\Resources\User;
use App\Models\MasterConsecutiveGachaDataModel;
use App\Facades\Error;

class MasterConsecutiveGachaDataRepository
{
    /**
     * Get number of cards to issue for consecutive gacha
     *
     * @return integer
     */
    public function getNumberOfConsecutiveGachaCards()
    {
        return MasterConsecutiveGachaDataModel::query()->first()['gacha_card_count'];
    }

    /**
     * Get maximum rarity level for consecutive gachas
     *
     * @return integer
     */
    public function getMaximumRareGachaRarityLevel()
    {
        return MasterConsecutiveGachaDataModel::query()->first()['maximum_rarity'];
    }
}
