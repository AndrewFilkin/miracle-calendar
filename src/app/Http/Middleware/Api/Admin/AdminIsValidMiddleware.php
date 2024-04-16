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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->user()->name == "admin" && auth()->user()->email == "admin@example.com") {
            return $next($request);
        } else {
            return response()->json("Access closed", 403);
        }
    }
}
