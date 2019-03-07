<?php

namespace App\Http\Middleware;

use Closure;

/**
 * 会员前台
 * Class FrontMiddleware
 * @package App\Http\Middleware
 */
class FrontMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!\site(null, true)) {
            abort(404, '站点不存在或域名没有绑定到模块');
        }
        if (!\module(null, true)) {
            abort(404, '您请求的模块不存在');
        }
        return $next($request);
    }
}
