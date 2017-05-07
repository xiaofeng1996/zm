<?php

namespace App\Http\Middleware\Web;

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
        $user_id = $request->session()->get('user_id');
        if (!isset($user_id) || !$user_id) {
            return redirect('/');
        } else {
            $request->userId = $user_id;
            return $next($request);
        }
    }
}
