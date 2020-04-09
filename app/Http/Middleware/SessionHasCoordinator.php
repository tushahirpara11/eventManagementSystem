<?php

namespace App\Http\Middleware;

use Closure;

class SessionHasCoordinator
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
        if (!$request->session()->has('coordinator')) {
            return redirect('/student/registration');
        } else {
            return $next($request);
        }
    }
}