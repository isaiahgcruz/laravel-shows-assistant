<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'timezone'
    ];

    /**
     * Fetch show's users
     * 
     * @return belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
