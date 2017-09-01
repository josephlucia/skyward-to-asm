<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'students';

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
        'person_id', 'person_number', 'first_name', 'middle_name', 'last_name',
        'grade_level', 'email_address', 'sis_username', 'password_policy', 'location_id', 
    ];

    /**
     * The query scope for staff searching.
     *
     * @param  string  $query
     * @return $this
     */
    public function scopeSearch($query, $search)
    {
        $value = is_null($search) ? '' : $search;

        return $query->where('location_id', 'LIKE', '%'.$value.'%')
                     ->orWhere('person_id', 'LIKE', '%'.$value.'%')
                     ->orWhere('last_name', 'LIKE', '%'.$value.'%')
                     ->orWhere('first_name', 'LIKE', '%'.$value.'%')
                     ->orWhere('sis_username', 'LIKE', '%'.$value.'%')
                     ->orWhere('email_address', 'LIKE', '%'.$value.'%');
    }
}
