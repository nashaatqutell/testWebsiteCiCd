<?php

namespace App\Http\Middleware;


use Illuminate\Auth\Middleware\Authenticate as Middleware;


class Authenticate extends Middleware
{

    protected function redirectTo($request): \Illuminate\Http\JsonResponse|string|null
    {
        if ($request->is('api/*')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if (!$request->expectsJson()) {
            $locale = app()->getLocale();
            return "/$locale/admin/login";
        }

        return parent::redirectTo($request);
    }
}
