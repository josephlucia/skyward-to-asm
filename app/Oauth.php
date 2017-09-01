<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oauth extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauths';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'access_token', 'token_type', 'expires_in'
    ];
}
