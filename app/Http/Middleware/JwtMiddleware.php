<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        try {

            JWTAuth::parseToken()->authenticate();

        } catch (Exception $exception) {

            if ($exception instanceof TokenInvalidException) {

                return response()->json(['error' => 'Token no valido'], 401);

            } else if ($exception instanceof TokenExpiredException) {

                return response()->json(['error' => 'Token expirado'], 401);

            } else {

                return response()->json(['error' => 'Usuario no autorizado'], 401);
                
            }
        }
        return $next($request);
    }
}
