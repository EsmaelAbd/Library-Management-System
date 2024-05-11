<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'You must be logged in to access this resource'], 401);
        }

        if (auth()->user()->is_admin) {
            return $next($request);
        }

        return response()->json(['message' => 'You are not authorized to perform this action'], 403);
    }
}
