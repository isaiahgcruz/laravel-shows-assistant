<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Show extends Model
{
    use Eloquence;

    /**
     * The attributes that are searchable.
     *
     * @var array
     **/
    protected $searchableColumns = [
        'name'
    ];
    
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
