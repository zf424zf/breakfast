<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/24
 * Time: 上午12:52
 */

namespace App\Http\Services;

use App\Models\Order\Order as OrderModel;
use App\Models\Order\Logs as LogsModel;
use App\Models\Metro\Place as PlaceModel;
use App\Models\PickupTime as PickupTimeModel;
use App\Models\Order\Pay as PayModel;
use App\Models\Order\Refund as RefundModel;
use App\Http\Services\Product as ProductService;
use App\Jobs\Notify\ExpireNotify;
use App\Jobs\Notify\PaidNotify;

class Order
{

    //订单状态定义
    const CANCELED = -2; //在订单未支付前，用户自行取消
    const EXPIRED = -1; //订单超时未支付，由系统取消
    const WAITPAY = 0;  //订单审核通过，等待支付，不需要审核时自动进入此状态
    const PAYED = 1;  //(可以退款)订单支付完成，金额为0的订单，在审核通过之后或者等待支付时应该直接进入此状态。
    const PICKED = 2;  //(可以退款)订单已经发货，用于需要邮寄的实体货物
    const FINISHED = 3;  //(可以退款)货物已签收或者订单完成
    const REFUNDING = 4;  //订单退款中
    const REFUNDING_PROCESS = 5;  //订单退款中,此状态已经提交给第三方支付平台处理,但未收到退款结果通知
    const REFUNDED = 6;  //订单全额退款成功
    const REFUND_FAIL = 7;  //(可以退款)退款失败

    protected static $behaviors = [
        'CREATE'         => '订单创建',
        'MODIFY'         => '订单被修改',
        'EXPIRE'         => '订单过期，关闭',
        'CANCEL'         => '订单由用户取消',
        'PAY'            => '订单支付',
        'PAID'           => '订单支付完成',
        'PICKED'         => '订单已取货',
        'FINISH'         => '订单完成',
        'REFUND'         => '用户发起退款',
        'CONFIRM_REFUND' => '退款请求被确认',
        'REFUNDING'      => '正在退款中',
        'REFUNDED'       => '退款完成',
        'REFUNDFAIL'     => '退款失败',
        'EVALUATED'      => '订单评价完成',
    ];

    protected $order = null;

    public function __construct($orderId = null)
    {
        if ($orderId) {
            $this->order = OrderModel::where('order_id', $orderId)->first();
            if (!$this->order) {
                //exception(self::ORDER_NOT_EXISTS);
            }
        }
    }

    /**
     * @param $uid
     * @param $subject
     * @param $module
     * @param $applyId
     * @param $amount
     * @return $this
     * 创建订单
     */
    public function create($uid, $date, $placeId, $pickuptimeId, $productIds, array $contact, $batchNo)
    {
        $orderId = self::buildOrderId();
        $products = ProductService::gets(array_keys($productIds));
        $pickuptime = PickupTimeModel::find($pickuptimeId)->toArray();
        foreach ($products as $key => $product) {
            $products[$key] = ProductService::isEarlyBird($product, $date, $pickuptime);
        }
        $orderProducts = [];
        foreach ($productIds as $productId => $count) {
            $orderProducts[] = [
                'uid'           => $uid,
                'order_id'      => $orderId,
                'date'          => $date,
                'place_id'      => $placeId,
                'pickuptime_id' => $pickuptimeId,
                'product_id'    => $productId,
                'price'         => $products[$productId]['price'],
                'count'         => $count,
                'amount'        => $products[$productId]['price'] * $count,
            ];
        }
        $order = [
            'uid'           => $uid,
            'order_id'      => $orderId,
            'date'          => $date,
            'place_id'      => $placeId,
            'pickuptime_id' => $pickuptimeId,
            'amount'        => array_sum(array_column($orderProducts, 'amount')),
            'phone'         => $contact['phone'],
            'name'          => $contact['name'],
            'company'       => $contact['company'],
            'batch_no'      => $batchNo,
        ];
        $order = new OrderModel($order);
        $this->order = $order;
        $order->save();
        $order->goods()->createMany($orderProducts);
        $this->log(__FUNCTION__);
        return $this;
    }

    /**
     * @param $payType
     * @param $amount
     * @return $this
     * 设置订单已支付
     */
    public function paid($flowId)
    {
        $order = $this->getOrder();
        $order['pay_time'] = time();
        $order['status'] = self::PAYED;
        $order['pay_flow'] = $flowId;
        $order->goods()->update(['status' => self::PAYED]);
        $order->save();
        $this->log(__FUNCTION__, null, $flowId);
        dispatch(new PaidNotify($order));
        return $this;
    }

    /**
     * @return $this
     * 订单过期
     */
    public function expire()
    {
        $order = $this->getOrder();
        //订单状态为等待支付状态才操作
        if ($order['status'] == self::WAITPAY) {
            $order['status'] = self::EXPIRED;
            $order->save();
            $this->log(__FUNCTION__, 0);
            dispatch(new ExpireNotify($order));
        }
        return $this;
    }

    /**
     * @param null $uid 取消订单的人
     * @return $this
     * 订单取消
     */
    public function cancel()
    {
        //订单状态为等待支付
        $order = $this->getOrder();
        if (in_array($order['status'], [self::WAITPAY])) {
            $order['status'] = self::CANCELED;
            $order->save();
            $this->log(__FUNCTION__, $order['uid']);
        }
        return $this;
    }

    public function picked()
    {
        //订单状态为等待支付
        $order = $this->getOrder();
        if (in_array($order['status'], [self::PAYED])) {
            $order['status'] = self::PICKED;
            $order->save();
            $this->log(__FUNCTION__, $order['uid']);
        }
        return $this;
    }

    /**
     * @return mixed
     * 获取订单信息
     */
    public function detail()
    {
        return $this->getOrder();
    }

    /**
     * @param array $orderIds
     * @param bool $more
     * @return mixed
     * 获取多个订单信息
     */
    public static function details(array $orderIds, $status = null)
    {
        $orders = OrderModel::whereIn('order_id', $orderIds)->with('goods');
        if ($status) {
            $orders->where('status', $status);
        }
        $orders = $orders->get()->keyBy('order_id')->toArray();
        $sorted = [];
        foreach ($orderIds as $orderId) {
            $sorted[$orderId] = isset($orders[$orderId]) ? $orders[$orderId] : [];
        }
        return array_filter($sorted);
    }

    /**
     * @param $uid
     * @param array $memberIds
     * @return array|mixed|null
     * 订单退款
     */
    public function refund($uid)
    {
        $order = $this->getOrder();
        //订单可以退款的状态
        $canRefundStatus = [
            self::PAYED,
            self::PICKED,
            self::FINISHED,
            self::REFUND_FAIL,
        ];//可以退款的订单状态
        if (!in_array($order['status'], $canRefundStatus)) {
            return false;
        }
        //支付流水
        $pay = PayModel::where('flow_id', $order['pay_flow'])->where('status', Payment::PAID_STATUS)->first();
        if (!$pay) {
            return false;
        }
        $amount = 0;
        //计算退款金额
        if (!$pay['coupon_id']) {
            $amount = $order['amount'];
        } else {

        }
        $refund = [
            'order_id'    => $order['order_id'],
            'pay_flow'    => isset($pay['batch_no']) ? $pay['batch_no'] : '',
            'refund_flow' => self::buildRefundId(),
            'amount'      => $amount,
            'status'      => $amount > 0 ? Refund::PROCESSING : Refund::REFUNDED,
        ];
        (new RefundModel($refund))->save();
        return $refund['refund_flow'];

        //保存退款记录
        $refundFlowId = self::saveFlow($refundAmount);
        if (!$refundFlowId) {
            exception(self::PAYFLOW_NOT_EXISTS);
        }
        //设置退款状态
        $class->setStatus($order['apply_id'], $status, $refundMemberIds);
        $order->status = $status;
        //设置订单的退款流水号
        $class->setRefundFlowId($order['apply_id'], $refundFlowId, $refundMemberIds);
        $order->save();
        $this->log('REFUND', $uid);
        //如果退款金额为0 直接退款完成
        if ($refundAmount == 0) {
            $this->refunding($uid, $refundFlowId);
            $this->refunded($uid, $refundFlowId);
        }
        return $refundFlowId;
    }

    /**
     * @param $uid
     * @param $refundFlowId
     * @return bool
     * 设置订单退款完成
     */
    public function refunded($uid, $refundFlowId)
    {
        $order = $this->getOrder();
        //订单为正在退款或者部分退款完成才可以操作
        if (in_array($order['status'], [OrderApi::REFUNDING_PROCESS, OrderApi::REFUNDING_PROCESS_PART, OrderApi::REFUNDED_PART])) {
            $order['status'] = $order['status'] == OrderApi::REFUNDING_PROCESS ? OrderApi::REFUNDED : OrderApi::REFUNDED_PART;
            $order->save();
            $class = new self::$interface[$order['module']];
            if ($order->module == Module::APPLY) {
                $class->setRefunded($refundFlowId);
            } else {
                $class->setStatus($order['apply_id'], $order['status']);
            }
            $this->log('REFUNDED', $uid);
            //@todo 通知退款完成
        }
        return true;
    }

    /**
     * @param $uid
     * @param $refundFlowId
     * @return bool
     * 设置退款失败
     */
    public function refundFail($uid, $refundFlowId)
    {
        $order = $this->getOrder();
        //订单为退款处理中才可以操作
        if (in_array($order['status'], [OrderApi::REFUNDING_PROCESS, OrderApi::REFUNDING_PROCESS_PART, OrderApi::REFUNDED_PART, OrderApi::REFUNDED])) {
            $order['status'] = $order['status'] == OrderApi::REFUNDED ? OrderApi::REFUND_FAIL : OrderApi::REFUND_PART_FAIL;
            $order->save();
            $class = new self::$interface[$order['module']];
            if ($order->module == Module::APPLY) {
                $class->setRefunded($refundFlowId);
            } else {
                $class->setStatus($order['apply_id'], $order['status']);
            }
            $this->log('REFUNDFAIL', $uid);
        }
        return true;
    }


    /**
     * @param bool $instance 获取模型对象还是数组
     * @return mixed
     * 获取订单数据
     */
    public function getOrder()
    {
        return $this->order;
    }


    /**
     * @param $behavior
     * @param null $uid
     * @param string $remark
     * @return $this
     * 订单日志记录
     */
    protected function log($behavior, $uid = null, $remark = '')
    {
        $order = $this->getOrder();
        $data = [
            'uid'      => is_null($uid) ? $order['uid'] : $uid,
            'order_id' => $order['order_id'],
            'behavior' => strtoupper($behavior),
            'log_text' => self::$behaviors[strtoupper($behavior)],
            'remark'   => $remark,
        ];
        (new LogsModel($data))->save();
        return $this;
    }

    public static function buildOrderId()
    {
        return date('md') . uniqid() . rand(1000, 9999);
    }

    public static function buildRefundId()
    {
        return uniqid('R');
    }
}