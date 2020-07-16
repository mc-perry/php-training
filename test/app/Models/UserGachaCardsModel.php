<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ユーザーカードのモデル
 */

class UserGachaCardsModel extends Model
{
    // Set the table name
    protected $table = 'user_gacha_cards';

    // Turn off timestamps to prevent SQL error related to created_at
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'master_card_id'
    ];
}
