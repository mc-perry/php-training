<?php

/**
 * ユーザーテーブル
 */

namespace App\Repositories;

use App\Models\MasterDataModel;

class MasterDataRepository
{
    /**
     * ユーザーIDを指定してデータを取得する
     *
     * @param int $ExpVal
     * @return User
     */
    public function getLevelFromExp(int $ExpVal)
    {
        return MasterDataModel::query()->where('exp', '<', $ExpVal)->orderBy('exp', 'DESC')->pluck('id');
    }
}
