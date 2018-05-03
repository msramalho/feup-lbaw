<?php

namespace App\Http\Middleware;

use App\User;
use App\Facades\CustomAuth;
use Closure;

class VerifyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (CustomAuth::checkAdmin()) {
            return $next($request);
        }

        return redirect('/');
    }
}
