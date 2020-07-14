<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Weight list model for gacha items
 */
class GachaToRarityMapModel extends Model
{
    // Set the table name
    protected $table = 'gacha_to_rarity_map';

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
        'card_rarity',
        'card_weight'
    ];
}
