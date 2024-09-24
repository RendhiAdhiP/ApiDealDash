<?php

namespace App\Http\Middleware;

use App\Helppers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SuperadminMiddlewaare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->user()->isSuperadmin()) {
            return $next($request);
        }

        Log::info('User role_id: ' . $request->user()->role_id);

        return ApiResponse::error('Forbidden', 403);
    }   
}
