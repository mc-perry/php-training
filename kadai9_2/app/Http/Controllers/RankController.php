<?php

namespace App\Http\Controllers;

use App\Services\RankService;
use App\Http\Requests\ShowRankRequest;

class RankController extends Controller
{
    private $rankService;

    public function __construct(
        RankService $rankService
    ) {
        $this->rankService = $rankService;
    }

    public function showRank(ShowRankRequest $request)
    {
        $rankResult = $this->rankService->showRank($request);
        return response()->json($rankResult);
    }
}
