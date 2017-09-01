<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffSection extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'staff_sections';

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
        'section', 'person_id', 
    ];
}
