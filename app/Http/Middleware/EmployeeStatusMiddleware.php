<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $is_active = $user->is_active ?? false;

        if (!$user || !$is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is not active. Please contact support.'
            ], 403);
        }

        return $next($request);
    }
}
