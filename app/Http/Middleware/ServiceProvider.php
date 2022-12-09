<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ServiceProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->user_type == 1){
            abort(403);
        }
        return $next($request);
    }
}
