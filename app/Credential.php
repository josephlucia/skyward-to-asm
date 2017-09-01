<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'credentials';

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
        'domain', 'consumer_secret', 'consumer_key', 'valid', 'sync'
    ];
}
