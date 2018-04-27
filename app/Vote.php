<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    // protected $fillable = [];

    public $timestamps = false;

    protected $primaryKey = ['user_id', 'post_id'];
    public $incrementing = false;

    /**
     * the post the vote is in
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * the user who cast the vote
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function user_voted($user_id, $post_id){
        return Vote::where("user_id", $user_id)->where("post_id", $post_id);
    }
}
