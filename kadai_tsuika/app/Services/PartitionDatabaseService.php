<?php

/**
 * データーベース
 */

namespace App\Services;

use App\Repositories\PartitionBatchTestRepository;

class PartitionDatabaseService
{
    private $partitionBatchTestRepository;
    public function __construct(
        PartitionBatchTestRepository $partitionBatchTestRepository
    ) {
        $this->partitionBatchTestRepository = $partitionBatchTestRepository;
    }

    public function partition()
    {
        $this->partitionBatchTestRepository->partition();
    }
}
