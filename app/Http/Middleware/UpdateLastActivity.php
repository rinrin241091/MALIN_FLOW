<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     *
      */ 
    //   @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {  
            $user = Auth::user();
            $user->last_activity = Carbon::now();
            $user->save();
        }
        return $next($request);
    }
}
