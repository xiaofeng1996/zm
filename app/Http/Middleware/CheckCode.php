<?php

namespace App\Http\Middleware;

use Closure;

class CheckCode
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
        $codeSrv = resolve('Code\CodeService');
        if ($codeSrv->verify($request->mobile, $request->code)) {
            return $next($request);
        }
    }
}
