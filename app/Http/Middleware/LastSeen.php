<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
class LastSeen
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user=Auth::user();

        $user->last_login=now();
        $user->save();
        
        
        return $next($request);
    }
}