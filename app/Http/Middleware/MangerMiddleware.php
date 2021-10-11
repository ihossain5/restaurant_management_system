<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MangerMiddleware
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
        if (auth()->user()->is_manager !=0) {
            return $next($request);
        }
        return redirect()->back()->withErrors(['error' => 'Sorry! You have no permission to access this']);
    }
}
