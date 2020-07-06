<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowRankRequest;
use Illuminate\Support\Facades\Redis;

class RankController extends Controller
{
    public function showrank(ShowRankRequest $request)
    {
        $result = array();
        $result = Redis::zRevRange('ranking', $request->from, $request->to, 'withscores');

        $ranking = array();

        foreach ($result as $user => $score) {
            $rank = (Redis::zCount('ranking', $score, '+inf'));
            array_push($ranking, [
                'ランキング' => $rank . '位',
                'nickname' => $user,
                'スコア' => $score,
            ]);
        }
        return response()->json($ranking);
    }
}
