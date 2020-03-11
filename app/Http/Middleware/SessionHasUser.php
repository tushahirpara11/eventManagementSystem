<?php

namespace App\Http\Middleware;

use Closure;

class SessionHasUser
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
        if (!$request->session()->has('user')) {
            return view('student.registration');
        } else {
            $response = $next($request);
            return $response->withCookie(cookie('user', 'userLogin'));
        }
    }
}
