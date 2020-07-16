<?php

/**
 * ユーザーガチャカード
 */

namespace App\Repositories;

use App\Models\UserGachaCardsModel;

class UserGachaCardsRepository
{
    /**
     * 新規の場合、選択したカードをユーザーカードに追加
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
     * カードの配列をユーザーカードに追加する
     *
     * @param array $CardsToInsert
     * @return bool
     */
    public function addCardsToUserTableFromArray(array $CardsToInsert)
    {
        return UserGachaCardsModel::insert($CardsToInsert);
    }


    /**
     * ユーザーIDを指定してカードを取得する
     *
     * @param int $UserId
     * @return array
     */
    public function getUserCards(int $UserId)
    {
        return UserGachaCardsModel::query()->where('user_id', $UserId)->orderBy('id', 'ASC')->get()->toArray();
    }
}
