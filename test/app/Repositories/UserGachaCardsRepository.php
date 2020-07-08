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
        if (UserGachaCardsModel::where('user_id', $UserId)->exists() && UserGachaCardsModel::where('master_card_id', $CardId)->exists()) {
            return UserGachaCardsModel::where('user_id', $UserId)->where('master_card_id', $CardId)->update(['new' => false]);
        }
        $insertUserDataObject = array('user_id' => $UserId, 'master_card_id' => $CardId);
        return UserGachaCardsModel::create($insertUserDataObject);
    }
}
