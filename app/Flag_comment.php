<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flag_comment extends Model
{
    protected $fillable = ['reason', 'date', 'archived'];

    protected $primaryKey =['flagger_id','comment_id'];

    public $incrementing = false;
    public $timestamps = false;

    /**
     * the comment the flag is in
     */
    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }

    /**
     * the user who flagged this comment
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'flagger_id');
    }
}
