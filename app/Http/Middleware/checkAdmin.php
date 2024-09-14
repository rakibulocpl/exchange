<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkAdmin
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
        $user_type = Auth::user()->user_type;
        if (in_array($user_type,['admin','superman','vendor'])){
            return $next($request);
        }else{
            return redirect()->to('/');
        }


    }
}
