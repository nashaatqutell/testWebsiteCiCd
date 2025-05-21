<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdmin
{
    const ADMIN_LOGIN_PATH = '/admin/login';
    const ADMIN_DASHBOARD_PATH = '/admin/';

    public function handle(Request $request, Closure $next): Response
    {
        $locale = app()->getLocale();
        $adminLoginPath = $locale . self::ADMIN_LOGIN_PATH;
        $dashboardHomePath = $locale . self::ADMIN_DASHBOARD_PATH;

        if (auth()->check() && $request->is($adminLoginPath) && $request->is('/')) {
            return redirect($dashboardHomePath);
        }

        if (!auth()->check() && $request->is('/') && $request->path() !== trim($adminLoginPath, '/')) {
            return redirect($adminLoginPath);
        }

        return $next($request);
    }
}
