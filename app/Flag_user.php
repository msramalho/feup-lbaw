<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flag_user extends Model
{
    protected $fillable = ['reason', 'date', 'archived'];

    public $timestamps = false;

    /**
     * the user the flag is in
     */
    public function flagged()
    {
        return $this->belongsTo('App\User', 'flagged_id');
    }

    /**
     * the user who flagged this user
     */
    public function flagger()
    {
        return $this->belongsTo('App\User', 'flagger_id');
    }
}
