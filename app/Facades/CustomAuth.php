<?php
namespace App\Facades;

use Illuminate\Support\Facades\Auth;

class CustomAuth extends Auth
{
    public static function checkAdmin()
    {
        if (Auth::check()) {
			return self::user()->isAdmin();
        }
        return false;
    }
}
