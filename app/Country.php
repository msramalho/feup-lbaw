<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name', 'code'];

    public $timestamps = false;

    /**
     * the cities in the country
     */
    public function cities()
    {
        return $this->hasMany('App\City');
    }

    /**
     * the universities in the country
     */
    public function universities()
    {
        return $this->hasMany('App\University');
    }
}
