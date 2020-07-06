<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\MaintenanceService;

class MaintenanceWindow
{
    private $maintenanceService;
    public function __construct(MaintenanceService $maintenanceService)
    {
        $this->maintenanceService = $maintenanceService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $returnObject = $this->maintenanceService->isInMaintenanceWindow();
        if ($returnObject) {
            return response()->json(['data' => ["メンテナンス中です。{$returnObject[0]}～{$returnObject[1]}"]], 200);
        }
        return $next($request);
    }
}
