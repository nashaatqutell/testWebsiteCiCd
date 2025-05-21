<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        if (
            $request->hasHeader('Accept-Language') &&
            in_array(
                $local=$request->header('Accept-Language'),
                config('app.available_locales'),
                true
            ))
        {
            app()->setLocale($local);
        }

        return $next($request);
    }
}
