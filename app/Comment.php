<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id', 'author_id', 'content', 'date', 'removed_reason', 'removed_date'];

    public $timestamps = false;

    /**
     * the owner of this comment
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    /**
     * the post where this comment was made
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * the flags to this comment
     */
    public function flagComments()
    {
        return $this->hasMany('App\FlagComment');
    }
}
