<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Faculty extends Model
{
    protected $fillable = ['city_id', 'university_id', 'name', 'description'];

    public $timestamps = false;

    /**
     * the city of this faculty
     */
    public function city()
    {
        return $this->belongsTo('App\City');
    }

    /**
     * the university of this faculty
     */
    public function university()
    {
        return $this->belongsTo('App\University');
    }

    /**
     * the posts where it is used as the origin faculty
     */
    public function posts_from()
    {
        return $this->hasMany('App\Post', 'from_faculty_id');
    }

    /**
     * the posts where it is used as the destination faculty
     */
    public function posts_to()
    {
        return $this->hasMany('App\Post', 'to_faculty_id');
    }

    public static function get_by_university($university_id){
        return Faculty::where("university_id", (int)$university_id)->orderBy("name")->get();
    }
}
