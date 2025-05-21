<?php

use App\Console\Commands\makeService;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\EmployeeStatusMiddleware;
use App\Http\Middleware\Localization;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath;
use Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // add custom middleware
        $middleware->alias([
            'localization' => Localization::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
            /**** OTHER MIDDLEWARE ****/
            'localize' => LaravelLocalizationRoutes::class,
            'localizationRedirect' => LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect' => LocaleSessionRedirect::class,
            'localeCookieRedirect' => LocaleCookieRedirect::class,
            'localeViewPath' => LaravelLocalizationViewPath::class,
            "employeeStatus" => EmployeeStatusMiddleware::class,
            "auth" => Authenticate::class
        ]);

        $middleware->use(['Illuminate\Http\Middleware\HandleCors','App\Http\Middleware\RedirectAdmin']);


    })->withCommands([
        makeService::class
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                if ($e instanceof NotFoundHttpException) {
                    return response()->json(['message' => 'Record not found.'], 404);
                }

                if ($e instanceof ModelNotFoundException) {
                    return response()->json(['message' => 'Model not found.'], 404);
                }

                if ($e instanceof ValidationException) {
                    return response()->json([
                        'message' => 'Validation failed.',
                        'errors' => $e->errors()
                    ], 422);
                }
                if ($e instanceof AuthenticationException) {
                    return response()->json(['message' => 'Unauthenticated.'], 401);
                }

                if ($e instanceof AuthorizationException) {
                    return response()->json(['message' => 'This action is unauthorized.'], 403);
                }

                if ($e instanceof HttpException) {
                    return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
                }

                return response()->json([
                    'message' => 'Server Error.',
                    'error' => config('app.debug') ? $e->getMessage() : 'Something went wrong.'
                ], 500);
            }

            return null;
        });
    })
    ->create();
