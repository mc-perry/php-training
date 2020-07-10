<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Weight list model for gacha items
 */
class MasterConsecutiveGachaDataModel extends Model
{
    // Set the table name
    protected $table = 'mst_consecutive_gacha';

    // The primary key associated with the table.
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'gacha_card_count' ,'maximum_rarity'
    ];
}
