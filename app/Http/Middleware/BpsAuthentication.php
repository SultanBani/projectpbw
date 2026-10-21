<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BpsAuthentication
{
    public function handle(Request $request, Closure $next): Response
    {
        $lastActivity = $request->session()->get('bps_last_activity');

        if (
            !$request->session()->has('bps_username')
            || ($lastActivity && now()->diffInSeconds($lastActivity) > 1800)
        ) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');
        }

        $request->session()->put('bps_last_activity', now());

        return $next($request);
    }
}
