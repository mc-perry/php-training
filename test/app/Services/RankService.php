<?php

/**
 * Rank Service
 */

namespace App\Services;

use App\Facades\Error;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\ShowRankRequest;

class RankService
{

    public function __construct()
    { }

    /**
     * Get rank data from the Redis sorted range and return the score object
     *
     * @param ShowRankRequest $request
     * @return object
     */
    public function showRank(ShowRankRequest $request)
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
        return $ranking;
    }
}
