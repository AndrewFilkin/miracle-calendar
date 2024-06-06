<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsApprovedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()) {
            if (auth()->user()->is_approved == "true") {
                return $next($request);
            } else {
                return response()->json(['message' => 'Access closed, you are not approved by the administrator'], 403);
            }
        } else {
            return response()->json(['message' => 'Access closed, you are not approved by the administrator'], 403);
        }
    }
}
