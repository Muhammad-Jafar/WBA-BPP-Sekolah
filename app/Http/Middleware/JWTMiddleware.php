<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if(!$user) {
                // throw new UnauthorizedHttpException('message', 'User not found');
                return response()->json([
                    'error' => true,
                    'message' => 'User not found',
                ]);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                'error' => true,
                'message' => 'Token is Invalid'
            ]);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'error' => true,
                    'message' => 'Token is Expired'
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Authorization Token not found'
                ]);
            }
        }

        return $next($request);
    }
}
