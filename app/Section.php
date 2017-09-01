<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sections';

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
        'class_id', 'class_number', 'course_id', 'instructor_id', 'instructor_id_2', 'instructor_id_3', 'location_id', 
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
                     ->orWhere('class_id', 'LIKE', '%'.$value.'%')
                     ->orWhere('class_number', 'LIKE', '%'.$value.'%')
                     ->orWhere('instructor_id', 'LIKE', '%'.$value.'%')
                     ->orWhere('instructor_id_2', 'LIKE', '%'.$value.'%')
                     ->orWhere('instructor_id_3', 'LIKE', '%'.$value.'%');
    }
}
