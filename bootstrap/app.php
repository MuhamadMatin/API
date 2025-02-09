<?php

use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use App\Http\Middleware\UnauthenticatedToken;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(UnauthenticatedToken::class);
    })
    ->withExceptions(
        function (Exceptions $exceptions) {
            $exceptions->render(function (Throwable $e, $request) {
                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'message' => 'Someting wrong',
                        'errors' => 'Unauthenticated or invalid token'
                    ], 401);
                }
                if ($e instanceof MethodNotAllowedHttpException) {
                    return response()->json([
                        'message' => 'Something wrong',
                        'errors' => 'Method Not Allowed'
                    ], 405);
                }
            });
        }
    )->create();
