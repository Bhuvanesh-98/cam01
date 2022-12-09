<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProfileUpdate
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
        $user = auth()->user();

        if($user->user_type == 1 && $user->address == null){
            $notify[] = ['error','Please Update profile First'];
            return redirect()->route('user.profile')->withNotify($notify);
        }
       
        if($user->user_type == 2 && ($user->designation == null || $user->details == null || $user->experience == null || $user->qualification == null)){
            $notify[] = ['error','Please Update profile First'];
            return redirect()->route('user.profile')->withNotify($notify);
        }
        return $next($request);
    }
}
