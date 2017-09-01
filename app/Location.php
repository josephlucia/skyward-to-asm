<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * Indicates if the timestamps are included.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location_id', 'location_name', 'sync', 
    ];
}
