<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flag_user extends Model
{
    protected $fillable = ['reason', 'date', 'archived'];
    protected $primaryKey =['flagger_id','flagged_id'];

    public $incrementing = false;
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

    public static function getFlag($user_id,$flagged_id)
    {
        $flag=Flag_user::where("flagger_id",$user_id)->where("flagged_id",$flagged_id)->first();
        return $flag;
    }
}
