<?php

/**
 * ユーザー
 */

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\MasterDataRepository;
use App\Repositories\MaintenanceRepository;
use Illuminate\Support\Facades\DB;

class MaintenanceService
{
    private $maintenanceRepository;

    public function __construct(
        MaintenanceRepository $maintenanceRepository
    ) {
        $this->maintenanceRepository = $maintenanceRepository;
    }

    public function isInMaintenanceWindow()
    {
        $inMaintenance = $this->maintenanceRepository->getMaintenanceWindow();
        $startTimeString = $inMaintenance->pluck('start')[0];
        $endTimeString = $inMaintenance->pluck('end')[0];
        $startTime = strtotime($startTimeString);
        $endTime = strtotime($endTimeString);
        $currentTime = strtotime(date("Y-m-d H:i:s"));
        if ($currentTime >= $startTime && $currentTime <= $endTime) {
            return array($startTimeString, $endTimeString);
        } else {
            return false;
        }
    }
}
