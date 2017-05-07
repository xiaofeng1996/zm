<?php

namespace App\Http\Middleware\Admin;

use Closure;

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
        $admin_id = $request->session()->get('admin_id');
        if (!isset($admin_id) || !$admin_id) {
            return response()->api('未登录', 0, 401);
        } else {
            return $next($request);
        }
    }
}
