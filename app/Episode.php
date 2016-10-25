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

     /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['title', 'start', 'end'];

    /**
     * Fetch episode's show
     * 
     * @return belongsTo
     */
    public function show()
    {
        return $this->belongsTo('App\Show');
    }


    public function getTitleAttribute()
    {
        $season = $this->attributes['season'];
        $season =  sprintf("%02d", $season);
        $number = $this->attributes['number'];
        $number =  sprintf("%02d", $number);
        $show = $this->show->name;

        return 'S'.$season.'E'.$number.' '.$show;
    }

    public function getStartAttribute()
    {
        $date = $this->attributes['airdate'];
        $time = $this->attributes['airtime'];
        $tz = $this->show->timezone;
        $date = new \DateTime($date . ' ' . $time . ' ' . $tz);

        $newTz = new \DateTimeZone(\Config::get('app.timezone'));
        $date->setTimezone($newTz);


        return $date->format('Y-m-d H:i');

    }

    public function getEndAttribute()
    {
        $date = $this->attributes['airdate'];
        $time = $this->attributes['airtime'];
        $tz = $this->show->timezone;
        $date = new \DateTime($date . ' ' . $time . ' ' . $tz);

        $newTz = new \DateTimeZone(\Config::get('app.timezone'));
        $date->setTimezone($newTz);
        $runtime = ($this->attributes['runtime']) ? $this->attributes['runtime'] : false;
        if ($runtime) {
            $date->add(new \DateInterval('PT' . $runtime . 'M'));
        }

        return $date->format('Y-m-d H:i');
    }
}
