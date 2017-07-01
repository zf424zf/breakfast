<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/27
 * Time: 下午9:59
 */

namespace App\Http\Services;

use App\Models\Order\Pay as PayModel;
use EasyWeChat\Payment\Order as EasyWechatOrder;

class Payment
{

    const WAIT_PAY = 0;//待支付

    const PAID_STATUS = 1;//已支付

    protected $flow = null;

    protected $notifyUrl = null;

    protected $prepayId = null;

    public function __construct($flowId = null)
    {
        $this->notifyUrl = url('order/notify');
        if ($flowId) {
            $this->flow = PayModel::where('flow_id', $flowId)->first();
        }
    }

    public function createFlow(array $orderIds, $uid, $amount, $couponId = 0)
    {
        $amount = round($amount, 2);
        $hash = md5(serialize(func_get_args()));
        $this->flow = PayModel::where('hash', $hash)->first();
        if ($this->flow) {
            return $this;
        }
        $data = [
            'uid'       => $uid,
            'flow_id'   => self::buildPayFlowId(),
            'order_ids' => implode(',', $orderIds),
            'amount'    => $amount,
            'coupon_id' => $couponId,
            'hash'      => $hash,
        ];
        $this->flow = new PayModel($data);
        $this->flow->save();
        return $this;
    }

    public function purchase($openId)
    {

        $attributes = [
            'trade_type'   => EasyWechatOrder::JSAPI, // JSAPI，NATIVE，APP...
            'body'         => setting('title', '一起吃早餐') . '订单',
            'out_trade_no' => $this->flow->flow_id,
            'total_fee'    => $this->flow->amount * 100, // 单位：分
            'notify_url'   => $this->notifyUrl, // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'       => $openId, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];
        $order = new EasyWechatOrder($attributes);
        $result = app('wechat')->payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $this->prepayId = $result->prepay_id;
        } else {
            throw new \Exception('下单失败:' . $result->err_code_des);
        }
        return $this;
    }

    public function getJSPaymentConfig()
    {
        return app('wechat')->payment->configForJSSDKPayment($this->prepayId);
    }

    public static function buildPayFlowId()
    {
        return uniqid('P');
    }

    public function setPaid($transactionId)
    {
        $this->flow->transaction_id = $transactionId;
        $this->flow->pay_time = time();
        $this->flow->status = self::PAID_STATUS;
        $this->flow->save();
        if ($this->flow->coupon_id) {
            Coupon::setCouponUsed($this->flow->coupon_id);
        }
        foreach (explode(',', $this->flow->order_ids) as $orderId) {
            (new Order($orderId))->paid($this->flow->flow_id);
        }
    }

}