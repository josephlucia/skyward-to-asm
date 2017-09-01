<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rosters';

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
        'roster_id', 'class_id', 'student_id', 
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

        return $query->where('roster_id', 'LIKE', '%'.$value.'%')
                     ->orWhere('class_id', 'LIKE', '%'.$value.'%')
                     ->orWhere('student_id', 'LIKE', '%'.$value.'%');
    }
}
