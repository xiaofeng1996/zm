<?php

/**
 * 检查是否是系统管理员
 */

namespace App\Http\Middleware\Admin;

use Closure;

class CheckMaster
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
        $role_id = $request->session()->get('role_id');
        if (!isset($role_id) || $role_id != 1) {
            return response()->api('没有权限', 0, 403);
        } else {
            return $next($request);
        }
    }
}
