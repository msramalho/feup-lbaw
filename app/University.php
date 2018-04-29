<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = ['country_id', 'name', 'description'];

    public $timestamps = false;

    /**
     * the country of this university
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * the faculties of this university
     */
    public function faculties()
    {
        return $this->hasMany('App\Faculty');
    }

    public static function get_all(){
        return University::orderBy("name");
    }
}
