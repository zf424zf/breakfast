<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2016/12/15
 * Time: 下午3:13
 */

namespace App\Http\Middleware;

use Closure;

class WechatBasic
{

    const SCOPE = 'snsapi_base';

    const SESSION_KEY = 'wechat.user';

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session(self::SESSION_KEY)) {
            if ($request->has('state') && $request->has('code')) {
                session([self::SESSION_KEY => app('wechat')->oauth->user()->getOriginal()]);
                return redirect()->to($this->getTargetUrl());
            }
            return app('wechat')->oauth->scopes([self::SCOPE])->redirect($request->fullUrl());
        }
        return $next($request);
    }

    /**
     * Build the target business url.
     *
     * @param Request $request
     *
     * @return string
     */
    public function getTargetUrl()
    {
        $queries = array_except(request()->all(), ['code', 'state']);
        return request()->url() . (empty($queries) ? '' : '?' . http_build_query($queries));
    }
}