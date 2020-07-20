<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartitionBatchTestModel extends Model
{
    // テーブル名を設定
    protected $table = 'jonathan_batch_test';

    // The primary key associated with the table.
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name'
    ];
}
