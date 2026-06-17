<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('login')->with('info', 'Please sign in to access the management portal.');
        }

        return $next($request);
    }
}