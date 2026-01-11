<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RequireLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            $request->session()->put('intended_url', $request->fullUrl());
            return redirect()->route('login');
        }

        return $next($request);
    }
}
