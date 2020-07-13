<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Weight list model for gacha items
 */
class MstGachaRarityWeightlistModel extends Model
{
    // Set the table name
    protected $table = 'mst_gacha_rarity_weightlist';

    // The primary key associated with the table.
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'card_id',
        'card_single_weight',
        'card_consecutive_weight',
    ];
}
