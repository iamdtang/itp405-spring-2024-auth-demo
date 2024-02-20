<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class DenyBlockedUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestedRouteName = $request->route()->getName();
        $isBlocked = Auth::user()->is_blocked;
        $isNotBlocked = !$isBlocked;

        if ($isBlocked && $requestedRouteName !== 'blocked') {
            return redirect()->route('blocked');
        }

        if ($isNotBlocked && $requestedRouteName === 'blocked') {
            return redirect()->route('profile.index');
        }

        return $next($request);
    }
}
