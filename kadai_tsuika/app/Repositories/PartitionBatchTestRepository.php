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
        $beginOfDay = strtotime("today");
        $dayAfterTomorrow   = strtotime('tomorrow + 1 day');

        $partitionQuery = "alter table jonathan_batch_test
        PARTITION BY RANGE(UNIX_TIMESTAMP (created_at) ) (
            PARTITION part_nintety_minutes_ago VALUES LESS THAN (" . $beginOfDay . "),
            PARTITION part_within_twodays VALUES LESS THAN (" . $dayAfterTomorrow . "),
            PARTITION recent_data VALUES LESS THAN (MAXVALUE)
        );";

        DB::unprepared(DB::raw($partitionQuery));
    }
}
