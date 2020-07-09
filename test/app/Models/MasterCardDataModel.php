<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for gacha items data
 */
class MasterCardDataModel extends Model
{
    // Set the table name
    protected $table = 'master_card_data';

    // The primary key associated with the table.
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'card_name', 'rarity'
    ];
}
