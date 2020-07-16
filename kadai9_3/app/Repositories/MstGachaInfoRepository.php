<?php

/**
 * 重み付けリポジトリ
 */

namespace App\Repositories;

use App\Models\MstGachaInfoModel;

class MstGachaInfoRepository
{
    /**
     * シングルガチャウェイトリストを取得
     *
     * @return object
     */
    public function getGachaMasterInfo(int $GachaId)
    {
        return MstGachaInfoModel::where('gacha_id', $GachaId)->first()->toArray();
    }
}
