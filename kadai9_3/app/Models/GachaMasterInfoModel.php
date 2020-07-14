<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Weight list model for gacha items
 */
class GachaMasterInfoModel extends Model
{
    // Set the table name
    protected $table = 'gacha_master_info';

    // The primary key associated with the table.
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gacha_id',
        'number_of_cards',
        'maximum_rarity',
    ];
}
