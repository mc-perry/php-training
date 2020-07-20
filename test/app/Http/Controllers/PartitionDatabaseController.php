<?php

namespace App\Http\Controllers;

use App\Services\PartitionDatabaseService;
use Illuminate\Http\Request;

class PartitionDatabaseController extends Controller
{
    private $partitionDatabaseService;
    public function __construct(
        PartitionDatabaseService $partitionDatabaseService
    ) {
        $this->partitionDatabaseService = $partitionDatabaseService;
    }

    public function partition()
    {
        $this->partitionDatabaseService->partition();
    }
}
