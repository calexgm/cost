<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminRoutes
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
        $admin = Auth::user()->rol_id;
        if ($admin == 1) {
            return $next($request);
        }else{
            return redirect('/home');
        }
    }
}
