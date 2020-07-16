<?php

/**
 * ガチャマスターデータリポジトリ
 */

namespace App\Repositories;

use App\Models\MstCardDataModel;

class MstCardDataRepository
{
    /**
     * 指定のレアリティレベルのすべてのカードを入手する
     *
     * @return Array
     */
    public function getCardsWithRarityLevel(int $rarityLevel)
    {
        return MstCardDataModel::where('rarity', $rarityLevel)->get()->toArray();
    }
}
