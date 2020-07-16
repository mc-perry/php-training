<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceModel extends Model
{
    // テーブル名を設定
    protected $table = 'maintenance';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start', 'end'
    ];
}
