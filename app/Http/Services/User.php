<?php

namespace App\Http\Services;

use App\Http\Middleware\WechatUserinfo;
use App\Models\Users as UsersModel;

class User
{

    private $user = null;

    /**
     * 初始化用户信息
     */
    public function __construct()
    {

        $this->user = $this->info();
    }

    /**
     * @param $user
     * 设置用户信息
     */
    public function set($user)
    {
        $this->user = $user;
    }

    /**
     * @return bool|null
     * 获取用户信息
     */
    public function auth()
    {
        if (is_null($this->user)) {
            return false;
        }
        return $this->user;
    }

    /**
     * 获取用户信息
     */
    public function info()
    {
        if (!$this->user) {
            $wechatUserinfo = session(WechatUserinfo::SESSION_KEY);
            if ($wechatUserinfo) {
                $user = UsersModel::where('openid', $wechatUserinfo['openid'])->first();
                if (!$user) {
                    $userData = [
                        'openid'    => $wechatUserinfo['openid'],
                        'nickname'  => $wechatUserinfo['nickname'],
                        'profile'   => $wechatUserinfo
                    ];
                    $user = new UsersModel($userData);
                    $user->save();
                    //@todo 发放优惠券
                }
                $this->user = $user;
            }
        }
        return $this->user;
    }

    public function __call($name, $arguments)
    {
        if (isset($this->user[$name])) {
            return $this->user[$name];
        }
        return null;
    }


}