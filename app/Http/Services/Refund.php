<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/27
 * Time: 下午9:59
 */

namespace App\Http\Services;

use App\Models\Order\Refund as RefundModel;
use App\Models\Order\Order as OrderModel;
use App\Models\Order\Pay as PayModel;
use App\Models\Coupon as CouponModel;

class Refund
{

    const REFUND_FAIL = -1;//退款失败

    const PROCESSING = 0;//退款中

    const REFUNDED = 1;//退款成功

    protected $refund;

    public function __construct($flowId = null)
    {
        if ($flowId) {
            $this->refund = RefundModel::where('refund_flow', $flowId)->first();
        }
    }

    /**
     * @param OrderModel $order
     * @return $this|bool
     * 创建退款流水
     */
    public function createFlow(OrderModel $order)
    {
        //支付流水
        $pay = PayModel::where('flow_id', $order['pay_flow'])->where('status', Payment::PAID_STATUS)->first();
        if (!$pay) {
            return false;
        }
        $amount = $order['amount'];
        //计算退款金额
        if ($pay['coupon_id']) {
            $coupon = CouponModel::find($pay['coupon_id']);
            $amount = $order['amount'] - (($order['amount'] / ($pay['amount'] + $coupon['amount'])) * $coupon['amount']);
            $amount = max($amount, 0);
            $amount = round($amount, 2);
        }
        $refund = [
            'order_id'    => $order['order_id'],
            'pay_flow'    => isset($pay['flow_id']) ? $pay['flow_id'] : '',
            'refund_flow' => self::buildRefundId(),
            'amount'      => $amount,
            'pay_amount'  => $pay['amount'],
            'status'      => $amount > 0 ? Refund::PROCESSING : Refund::REFUNDED,
        ];
        $flow = new RefundModel($refund);
        $flow->save();
        $this->refund = $flow;
        return $this;
    }

    /**
     * @return $this|null
     * 启动退款
     */
    public function launch()
    {
        if ($this->refund->amount <= 0) {
            return $this->refunded();
        }
        $result = app('wechat')->payment->refund($this->refund['order_id'], $this->refund['refund_flow'], $this->refund['pay_amount'] * 100, $this->refund['amount'] * 100);
        var_dump($result);
        return $this;
    }

    /**
     * @return null
     * 退款成功
     */
    public function refunded()
    {
        $this->refund['staus'] = self::REFUNDED;
        $this->refund->save();
        (new Order($this->refund['order_id']))->refunded();
        return $this;
    }

    /**
     * @return $this
     * 退款失败
     */
    public function refundFail()
    {
        $this->refund['staus'] = self::REFUND_FAIL;
        $this->refund->save();
        (new Order($this->refund['order_id']))->refundFail();
        return $this;
    }


    public static function buildRefundId()
    {
        return uniqid('R');
    }


}