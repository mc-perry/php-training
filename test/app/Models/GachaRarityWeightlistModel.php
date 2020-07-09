<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Weight list model for gacha items
 */
class GachaRarityWeightlistModel extends Model
{
    // Set the table name
    protected $table = 'gachacard_rarity_weightlist';

    // The primary key associated with the table.
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'card_rarity'
    ];

}