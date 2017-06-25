<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/24
 * Time: 上午12:52
 */

namespace App\Http\Services;

use App\Models\Coupon as CouponModel;

class Coupon
{
    const LOCKED = -1;//优惠券锁定
    const VALID = 0;//优惠券有效
    const USED = 1;//优惠券已使用

    const NEW_USER_COUPON_NAME = '新用户优惠';

    public static function grantNewuserCouponCard($uid)
    {
        $expireDays = 7;//有效天数
        $data = [
            'uid'    => $uid,
            'name'   => self::NEW_USER_COUPON_NAME,
            'amount' => setting('new_user_coupon', 0.01),
            'expire' => strtotime(date('Ymd')) + 86400 * $expireDays,
        ];
        $model = new CouponModel($data);
        $model->save();
        return $model->id;
    }

    /**
     * @param $uid
     * @return mixed
     * 获取优惠金额最大的优惠券
     */
    public static function getMaxAmountCoupon($uid)
    {
        return CouponModel::valid()->where('uid', $uid)->orderBy('amount', 'DESC')->first()->toArray();
    }

    /**
     * @param $id
     * @return mixed
     * 设置优惠券已使用
     */
    public static function setCouponUsed($id)
    {
        return CouponModel::where('id', $id)->update(['status' => self::USED]);
    }

    /**
     * @param $id
     * @return mixed
     * 设置优惠券已锁定(用户下单使用了优惠券未支付之前应该处于锁定状态,订单过期或者取消,优惠券应恢复至可使用状态)
     */
    public static function setCouponLocked($id)
    {
        return CouponModel::where('id', $id)->update(['status' => self::LOCKED]);
    }
}