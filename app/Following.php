<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    protected $fillable = ['date'];

    public $timestamps = false;

    /**
     * the user who is followed
     */
    public function followed()
    {
        return $this->belongsTo('App\User', 'followed_id');
    }

    /**
     * the user who follows
     */
    public function follower()
    {
        return $this->belongsTo('App\User', 'follower_id');
    }
}
