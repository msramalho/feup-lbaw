<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birthdate', 'description', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The posts this user owns.
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * The comments this user owns.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Return true if the current user is an admin
     */
    public function isAdmin(){
        return $this->type === "admin";
    }

    /**
     * Return true if the current user is banned
     */
    public function isBanned(){
        return $this->type === "banned";
    }

}
