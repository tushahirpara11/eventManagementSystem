<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class SessionHasAdmin
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
        if (!$request->session()->has('admin')) {
            return view('admin.index');
        } else {
            $response = $next($request);
            return $response->withCookie(cookie('admin', 'adminLogin'));
        }
    }
}
