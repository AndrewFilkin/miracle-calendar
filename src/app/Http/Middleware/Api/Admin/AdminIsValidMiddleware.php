<?php

namespace App\Http\Middleware\Api\Admin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminIsValidMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->user()) {
            if (auth()->user()->role == "admin") {
                return $next($request);
            } else {
                return response()->json(['message' => 'Access closed'], 403);
            }
        } else {
            return response()->json(['message' => 'Access closed'], 403);
        }
    }
}
