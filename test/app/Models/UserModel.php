<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ユーザーモデル
 */
class UserModel extends Model
{
    // テーブル名を設定
    protected $table = 'users';

    // The primary key associated with the table.
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'access_token', 'nickname', 'level', 'exp'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'access_token' => null,
        'level' => 1,
        'exp' => 0
    ];
}
