<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'airdate', 'airtime', 'season', 'number', 'show_id', 'airstamp',
        'runtime'
    ];
}
