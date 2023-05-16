<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureBearerToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Invalid or missing bearer token',
            ], 401);
        }

        return $next($request);
    }
}
