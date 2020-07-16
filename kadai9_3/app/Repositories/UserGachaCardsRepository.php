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
        return UserGachaCardsModel::create($insertUserDataObject)->toArray();
    }

    /**
     * Add array of cards to users cards
     *
     * @param array $CardsToInsert
     * @return bool
     */
    public function addCardsToUserTableFromArray(array $CardsToInsert)
    {
        return UserGachaCardsModel::insert($CardsToInsert);
    }


    /**
     * Get cards given user id
     *
     * @param int $UserId
     * @return array
     */
    public function getUserCards(int $UserId)
    {
        return UserGachaCardsModel::query()->where('user_id', $UserId)->orderBy('id', 'asc')->get()->toArray();
    }
}
