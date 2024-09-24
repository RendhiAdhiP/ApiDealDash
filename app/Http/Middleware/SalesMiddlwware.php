<?php

namespace App\Http\Middleware;

use App\Helppers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesMiddlwware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->isSales()) {
            return $next($request);
        }

        return ApiResponse::error('Forbidden', 403);
    }
}
