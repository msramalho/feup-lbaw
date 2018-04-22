<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    // protected $fillable = [];

    public $timestamps = false;

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
}
