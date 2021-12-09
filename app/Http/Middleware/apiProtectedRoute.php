<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class apiProtectedRoute extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*public function handle($request, Closure $next)
    {
        try {
            $user = JWT::parseToken()->authenticate();
        } catch (\Exception $e) {
            if($e instanceof)
        }
        return $next($request);
    }*/

    public function handle($request, Closure $next)
    {
        try {
            $user = FacadesJWTAuth::parseToken()->authenticate();
            //$request->merge(['user' => auth('api')->user()]);
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'O token é inválido']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status' => 'O token expirou']);
            } else {
                var_dump($request);
                return response()->json(['status' => 'Token de autorização não encontrado']);
            }
        }
        return $next($request);
    }
}
