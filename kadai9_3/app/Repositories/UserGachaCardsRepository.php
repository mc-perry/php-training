<?php

/**
 * User Gacha Cards
 */

namespace App\Repositories;

use App\Http\Resources\User;
use App\Models\UserGachaCardsModel;
use App\Facades\Error;

class UserGachaCardsRepository
{
    /**
     * Add selected card to users cards if new
     *
     * @param int $UserId
     * @param int $CardId
     * @return bool
     */
    public function addSelectedCardToUserTable(int $UserId, int $CardId)
    {
        $insertUserDataObject = array('user_id' => $UserId, 'master_card_id' => $CardId);
        return UserGachaCardsModel::create($insertUserDataObject);
    }
}
