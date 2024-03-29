<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // if (Auth::check() && Auth::guard('user')->role == $role) {
        //     return $next($request);
        // } elseif (Auth::check() && Auth::guard('admincbd')->role == $role) {
        //     return $next($request);
        // }
        if (Auth::check() && Auth::user()->role == $role) {
            return $next($request);
        }
        // if (in_array($request->user()->level, $level)) {
        //     return $next($request);
        // }
        return redirect('/')->with('Maaf, kamu tidak memiliki hak akses!');
    }
}
