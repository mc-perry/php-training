<?php

/**
 * ユーザーテーブル
 */

namespace App\Repositories;

use App\Models\MaintenanceModel;

class MaintenanceRepository
{
    /**
     * メンテナンスウィンドウを戻す
     *
     * @param int $TimeValue
     * @return User
     */
    public function getMaintenanceWindow()
    {
        return MaintenanceModel::query()->first();
    }
}
