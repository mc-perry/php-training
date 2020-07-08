<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ユーザーモデル
 */
class MasterDataModel extends Model
{
    // テーブル名を設定
    protected $table = 'user_master_data';

    // The primary key associated with the table.
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exp'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'exp' => 0
    ];
}
