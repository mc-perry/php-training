<?php

/**
 * ユーザーテーブル
 */

namespace App\Repositories;

use App\Models\MaintenanceModel;

class MaintenanceRepository
{
    /**
     * Return the maintenance window
     *
     * @param int $TimeValue
     * @return User
     */
    public function getMaintenanceWindow()
    {
        return MaintenanceModel::query()->first();
    }
}
