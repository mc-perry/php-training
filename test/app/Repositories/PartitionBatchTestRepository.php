<?php

/**
 * Partition Database
 */

namespace App\Repositories;

use App\Models\PartitionBatchTestModel;
use Illuminate\Support\Facades\DB;

class PartitionBatchTestRepository
{
    /**
     * データベースを分割する
     *
     * @return bool
     */
    public function partition()
    {
        // return UserModel::query()->where('id', $UserId)->first();
        $beginOfDay = strtotime("today");
        $dayAfterTomorrow   = strtotime('tomorrow + 1 day');

        $partitionQuery = "alter table jonathan_batch_test
        PARTITION BY RANGE(UNIX_TIMESTAMP (created_at) )
        ( PARTITION part_less_than_today VALUES LESS THAN (" . $beginOfDay . "),
            PARTITION part_within_twodays VALUES LESS THAN (" . $dayAfterTomorrow . "),
            PARTITION part_after_twodays VALUES LESS THAN MAXVALUE
        );";

        var_dump($partitionQuery);
        DB::unprepared(DB::raw($partitionQuery));
    }
}
