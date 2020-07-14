<?php

/**
 * Weightlist Repository
 */

namespace App\Repositories;

use App\Models\GachaMasterInfoModel;

class GachaMasterInfoRepository
{
    /**
     * Get single gacha weightlist
     *
     * @return object
     */
    public function getGachaMasterInfo(int $GachaId)
    {
        return GachaMasterInfoModel::where('gacha_id', $GachaId)->get()->toArray();
    }
}
