<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Demo
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
        if(env('APP_VERSION') == 'demo'){
            if($request->ajax()){
                return response()->json(['fails' => true, 'errorMsg' =>['email' => changeDynamic('This Is Demo Version. You Can Not Change Anything')]]);
            }
            if($request->isMethod('post') || $request->isMethod('delete') || $request->isMethod('put') || $request->isMethod('patch')){
                $notify[] = ['error','This Is Demo Version. You Can Not Change Anything'];
    
                return back()->withNotify($notify);
            }
        }
        return $next($request);
    }
}
