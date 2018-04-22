<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['author_id', 'from_faculty_id', 'to_faculty_id', 'title', 'votes', 'content', 'school_year', 'date', 'removed_reason', 'removed_date', 'beer_cost', 'life_cost', 'native_friendliness', 'work_load', 'search_title', 'search_content'];

    public $timestamps = false;

    /**
     * the author of this post
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    /**
     * the origin faculty
     */
    public function faculty_from()
    {
        return $this->belongsTo('App\Faculty', 'from_faculty_id');
    }

    /**
     * the destination faculty
     */
    public function faculty_to()
    {
        return $this->belongsTo('App\Faculty', 'to_faculty_id');
    }

    /**
     * the comments inside this post
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * the flags of this post
     */
    public function flagPosts()
    {
        return $this->hasMany('App\FlagPost');
    }

    /**
     * the users who have voted in this post
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'votes');
    }
}
