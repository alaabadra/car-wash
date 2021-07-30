<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if(!session()->has('user'))
            return redirect('/');
        return $next($request);
    }
}
