<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $fillable = ['from_faculty_id', 'to_faculty_id', 'title', 'content', 'school_year','beer_cost', 'life_cost', 'native_friendliness', 'work_load'];

    protected $hidden = [
        'author_id', 'votes', 'removed_reason', 'removed_date', 'search_title', 'search_content'
    ];

    //default attributes
    protected $attributes = [
        'votes' => 0
    ];

    public $timestamps = false;

    /**
     * the author of this post
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
    /**
     * the current user is the author of this post
     */
    public function isOwner()
    {
        return Auth::check() && $this->user->id == Auth::user()->id;
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
