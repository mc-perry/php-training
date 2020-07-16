<?php

/**
 * カードマップへのレアリティのリポジトリ
 */

namespace App\Repositories;

use App\Models\MstRarityToCardMapModel;

class MstRarityToCardMapRepository
{
    /**
     * レアリティをカードにマッピングを全て取得
     *
     * @return Array
     */
    public function getAllRarityToCardMappings()
    {
        return MstRarityToCardMapModel::all()->toArray();
    }


    /**
     * 指定のレアリティレベルのすべてのカードを入手する
     *
     * @return Array
     */
    public function getCardsWithRarityLevel(int $GachaId, int $rarityLevel)
    {
        return MstRarityToCardMapModel::where('gacha_id', $GachaId)->where('rarity_level', $rarityLevel)->get()->toArray();
    }

    /**
     * 指定のレア度レベルまたはレア度のすべてのカードを取得します（インデックス高=レア）
     *
     * @return Array
     */
    public function getCardsWithRarityLevelOrAbove(int $GachaId, int $rarityLevel)
    {
        return MstRarityToCardMapModel::where('gacha_id', $GachaId)->where('rarity_level', ">=", $rarityLevel)->get()->toArray();
    }
}
