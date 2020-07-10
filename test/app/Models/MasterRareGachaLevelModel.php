<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Weight list model for gacha items
 */
class MasterRareGachaLevelModel extends Model
{
    // Set the table name
    protected $table = 'master_rare_gacha_level';

    // The primary key associated with the table.
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'maximum_rarity'
    ];
}
