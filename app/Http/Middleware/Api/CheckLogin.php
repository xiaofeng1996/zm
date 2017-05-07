<?php

namespace App\Http\Middleware\Api;

use Closure;
use JWTAuth;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $request->userId = $user->id;
            return $next($request);
        } catch (\Exception $e) {
            throw new \Exception('token 失效');
        }
    }
}
