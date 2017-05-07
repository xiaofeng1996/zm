<?php

namespace App\Http\Middleware\Web;

use Closure;

class CheckLoginForAjax
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
        $user_id = $request->session()->get('user_id');
        if (!isset($user_id) || !$user_id) {
            return response()->api('请先登录', 0, 401);
        } else {
            return $next($request);
        }
    }
}
