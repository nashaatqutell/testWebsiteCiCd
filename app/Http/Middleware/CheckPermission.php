<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if (Auth::check() && Auth::user()->hasPermissionTo($permission))
        {
            return $next($request);
        }
        abort(403, 'Unauthorized');
    }
}
