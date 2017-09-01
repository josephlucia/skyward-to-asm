<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';

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
        'course_id', 'course_number', 'course_name', 'location_id', 
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
                     ->orWhere('course_id', 'LIKE', '%'.$value.'%')
                     ->orWhere('course_number', 'LIKE', '%'.$value.'%')
                     ->orWhere('course_name', 'LIKE', '%'.$value.'%');
    }
}
