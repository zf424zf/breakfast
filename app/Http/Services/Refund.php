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


    public function createFlow(OrderModel $order)
    {

    }


    public static function buildRefundId()
    {
        return uniqid('R');
    }


}