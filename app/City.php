<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['country_id', 'name'];

    public $timestamps = false;

    /**
     * the country of the city
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * the faculties inside this city
     */
    public function faculties()
    {
        return $this->hasMany('App\Faculty');
    }

    public function get_modal_data(){
        return ["id" => $this->id, "name" => $this->name, "country" => $this->country->name];
    }
}
