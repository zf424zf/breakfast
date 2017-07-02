<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2016/12/15
 * Time: 下午3:13
 */

namespace App\Http\Middleware;

use Closure;

class WechatUserinfo
{

    const SCOPE = 'snsapi_userinfo';

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
        if (app()->environment() == 'local') {
            session([self::SESSION_KEY => json_decode('{"openid":"o3-UIwDbB0cWKNAdV51mcm5b6Zf8","nickname":"Skiden","sex":1,"language":"zh_CN","city":"\u5357\u4eac","province":"\u6c5f\u82cf","country":"\u4e2d\u56fd","headimgurl":"http:\/\/wx.qlogo.cn\/mmopen\/ajNVdqHZLLA3JS8ob7a7LEc4ibcnjnpBnuB2biaHTaro00ia3RFUVL5Hibr3riaaVea3WzS7IegHZPkLV2olFtQ4eicA\/0","privilege":[]}', true)]);
        }
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