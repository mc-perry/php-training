<?php

/**
 * Weightlist Repository
 */

namespace App\Repositories;

use App\Models\MstGachaInfoModel;

class MstGachaInfoRepository
{
    /**
     * Get single gacha weightlist
     *
     * @return object
     */
    public function getGachaMasterInfo(int $GachaId)
    {
        return MstGachaInfoModel::where('gacha_id', $GachaId)->get()->toArray();
    }
}
