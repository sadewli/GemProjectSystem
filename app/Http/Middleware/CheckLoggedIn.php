<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckLoggedIn
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::get('loggedin')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Session expired'], 401);
            }

            return redirect('/');
        }

        return $next($request);
    }
}
