<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Http\Resources\ApiAuthResourceFailed;
use Symfony\Component\HttpFoundation\Response;

class UnauthenticatedToken
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (AuthenticationException $e) {
            return new ApiAuthResourceFailed('Invalid token', 'Something wrong', 401);
        }
    }
}
