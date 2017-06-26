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

class Order
{

    //订单状态定义
    const CANCELED = -2; //在订单未支付前，用户自行取消
    const EXPIRED = -1; //订单超时未支付，由系统取消
    const WAITPAY = 0;  //订单审核通过，等待支付，不需要审核时自动进入此状态
    const PAYED = 1;  //(可以退款)订单支付完成，金额为0的订单，在审核通过之后或者等待支付时应该直接进入此状态。
    const PICKED = 2;  //(可以退款)订单已经发货，用于需要邮寄的实体货物
    const FINISHED = 3;  //(可以退款)货物已签收或者订单完成
    const REFUNDING = 4;  //订单全额退款中
    const REFUNDING_PROCESS = 5;  //订单全额退款中,此状态已经提交给第三方支付平台处理,但未收到退款结果通知
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
    public function create($uid, $date, $placeId, $pickuptimeId, $productIds)
    {
        $order = OrderModel::where('module', $module)->where('apply_id', $applyId)->first();
        if ($order) {
            $this->order = $order;
            return $this->modify($subject, $amount);
        }
        $amount = $amount <= 0 ? 0 : $amount;
        $order = [
            'uid'      => $uid,
            'order_id' => self::buildOrderId(),
            'module'   => $module,
            'apply_id' => $applyId,
            'subject'  => $subject,
            'status'   => $amount == 0 ? OrderApi::PAYED : OrderApi::WAITPAY,
            'amount'   => $amount,
            'source'   => app('user')->source(),
        ];
        $order = new OrderModel($order);
        $this->order = $order;
        $order->save();
        $this->callback()->log(__FUNCTION__);
        return $this;
    }

    /**
     * @param $subject
     * @param $amount
     * @return $this
     * 修改订单
     */
    public function modify($subject, $amount)
    {
        $amount = $amount <= 0 ? 0 : $amount;
        $order = $this->getOrder();
        if (in_array($order['status'], [OrderApi::WAITAUDIT, OrderApi::WAITPAY])) {
            $order['subject'] = $subject;
            $order['amount'] = $amount;
            $order['status'] = $amount == 0 ? OrderApi::PAYED : OrderApi::WAITPAY;
            $order->save();
            $this->callback()->log(__FUNCTION__, null, $amount);
        }
        return $this;
    }

    /**
     * @param $payType
     * @param $amount
     * @return $this
     * 设置订单已支付
     */
    public function paid($payType, $amount)
    {
        $order = $this->getOrder();
        if ($amount == $order['amount']) {
            $order['pay_type'] = $payType;
            $order['pay_time'] = time();
            $order['status'] = OrderApi::PAYED;
            $order->save();
            $this->callback()->log(__FUNCTION__, null, $amount);
            dispatch(new PaidNotify($order));
        }
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
        if ($order['status'] == OrderApi::WAITPAY) {
            $order['status'] = OrderApi::EXPIRED;
            $order->save();
            $this->callback()->log(__FUNCTION__, 0);
            dispatch(new ExpireNotify($order));
        }
        return $this;
    }

    /**
     * @param null $uid 取消订单的人  管理员或者俱乐部或者用户自己
     * @return $this
     * 订单取消
     */
    public function cancel($uid = null)
    {
        //订单状态为等待支付或者等待审核状态才操作
        $order = $this->getOrder();
        if (in_array($order['status'], [OrderApi::WAITPAY, OrderApi::WAITAUDIT])) {
            $order['status'] = OrderApi::CANCELED;
            $order->save();
            //设置回调状态
            $uid = is_null($uid) ? $order['uid'] : $uid;
            $this->callback()->log(__FUNCTION__, $uid);
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
    public static function details(array $orderIds, $more = false)
    {
        $orders = OrderModel::whereIn('order_id', $orderIds)->get()->keyBy('order_id')->toArray();
        if ($orders && $more) {
            $modules = [];
            foreach ($orders as $order) {
                $modules[$order['module']][] = $order['apply_id'];
            }
            $details = [];
            foreach ($modules as $key => $module) {
                if (isset(self::$interface[$key])) {
                    $class = self::$interface[$key];
                    $instance = new $class;
                    if ($instance instanceof PaymentInterface) {
                        $details[$key] = $instance->orderDetails($module);
                    }
                }
            }
            foreach ($orders as $key => $order) {
                $orders[$key]['detail'] = isset($details[$order['module']][$order['apply_id']]) ? $details[$order['module']][$order['apply_id']] : [];
            }
        }
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
    public function refund($uid, $memberIds = [])
    {
        $order = $this->getOrder();
        //订单可以退款的状态
        $canRefundStatus = [
            OrderApi::PAYING,
            OrderApi::PAYED,
            OrderApi::DELIVERED,
            OrderApi::FINISHED,
            OrderApi::REFUNDING_PART,
            OrderApi::REFUNDING_PROCESS_PART,
            OrderApi::REFUNDED_PART,
            OrderApi::REFUND_PART_FAIL,
            OrderApi::REFUND_FAIL,
            OrderApi::EVALUATED,
        ];//可以退款的订单状态
        if (!in_array($order['status'], $canRefundStatus)) {
            exception(self::ORDER_CANT_REFUND);
        }
        $refundFlowId = null;
        $class = new self::$interface[$order['module']];
        if (!$class instanceof PaymentInterface) {
            exception(self::SYSTEM_ERROR);
        }
        $refundAmount = 0;
        $refundMemberIds = [];//退款成员ID
        if ($order->module == Module::APPLY) {
            //单个成员已经退款的状态
            $refundedStatus = [
                OrderApi::REFUNDING_PART,
                OrderApi::REFUNDING_PROCESS_PART,
                OrderApi::REFUNDED_PART,
                OrderApi::REFUNDED,
            ];
            //单个成员可以退款的状态
            $itemCanRefundStatus = [
                OrderApi::PAYING,
                OrderApi::PAYED,
                OrderApi::DELIVERED,
                OrderApi::FINISHED,
                OrderApi::REFUND_PART_FAIL,
                OrderApi::REFUND_FAIL,
                OrderApi::EVALUATED,
            ];
            //退款请求为报名
            $this->apply = $class->orderDetail($order['apply_id']);
            $memberIds = $memberIds ? $memberIds : array_column($this->apply['members'], 'id');
            $refundedAmount = 0;
            $refundedMemberIds = [];//已经退款成员ID
            foreach ($this->apply['members'] as $member) {
                if (in_array($member['id'], $memberIds) && in_array($member['status'], $itemCanRefundStatus)) {
                    $refundAmount += $member['price'];
                    $refundMemberIds[] = $member['id'];
                } elseif (in_array($member['status'], $refundedStatus)) {
                    $refundedAmount += $member['price'];
                    $refundedMemberIds[] = $member['id'];
                }
            }
            //如果退款成员和已经退款人员个数和报名成员个人一致则为全额退款
            $status = count($refundMemberIds) + count($refundedMemberIds) == count($this->apply['members']) ? OrderApi::REFUNDING : OrderApi::REFUNDING_PART;
        } else {
            //正常全额退款
            $refundAmount = $order['amount'];
            $status = OrderApi::REFUNDING;
        }
        //可退款金额为0 且 退款成员为空 不能退款
        if ($refundAmount == 0 && count($refundMemberIds) == 0) {
            exception(self::NO_AMOUNT_REFUND);
        }
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
     * @param $refundFlow
     * @return mixed
     * 获取退款记录
     */
    public function getRefund($refundFlow)
    {
        $refund = RefundModel::where('refund_flow', $refundFlow)->first();
        if (!$refund) {
            exception(self::REFUND_ISNT_EXISTS);
        }
        return $refund;
    }

    /**
     * @return mixed
     * 获取订单退款记录
     */
    public function refundLog()
    {
        $order = $this->getOrder();
        return RefundModel::where('order_id', $order['order_id'])->with('member')->orderBy('id', 'DESC')->get()->toArray();
    }

    /**
     * @param $refundFlow
     * @param null $amount
     * @return mixed
     * 确定退款请求
     */
    public function confirmRefund($refundFlow, $amount = null)
    {
        $refund = RefundModel::where('refund_flow', $refundFlow)->first();
        if (!is_null($amount)) {
            $amount = $amount > $refund['amount'] ? $refund['amount'] : $amount;
            $refund['real_amount'] = $amount;
        }
        if (in_array($refund['status'], [RefundApi::WAIT_PROCESS, RefundApi::ADUDIT_FAIL, RefundApi::WAIT_ADUDIT])) {
            $refund['status'] = RefundApi::WAIT_PROCESS;
            $refund->save();
        }
        return $refund;
    }


    /**
     * @param $uid
     * @param $refundFlowId
     * @return bool
     * 设置订单正在退款中
     */
    public function refunding($uid, $refundFlowId)
    {
        $order = $this->getOrder();
        //订单为退款中才可以操作
        if (in_array($order['status'], [OrderApi::REFUNDING_PART, OrderApi::REFUNDING, OrderApi::REFUNDED_PART, OrderApi::REFUNDED])) {
            $order['status'] = $order['status'] == OrderApi::REFUNDING_PART ? OrderApi::REFUNDING_PROCESS_PART : OrderApi::REFUNDING_PROCESS;
            $order->save();
            $class = new self::$interface[$order['module']];
            if (!$class instanceof PaymentInterface) {
                exception(self::SYSTEM_ERROR);
            }
            if ($order['module'] == Module::APPLY) {
                $class->setRefunding($refundFlowId);
            } else {
                $class->setStatus($order['apply_id'], $order['status']);
            }
            $this->log('REFUNDING', $uid);
            //@todo 通知退款正在处理中
        }
        return true;
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
     * 生成退款流水
     * @param string $orderId
     * @param int $applyId
     * @param array $members
     */
    protected function saveFlow($amount)
    {
        $order = $this->getOrder();
        //支付流水
        $pay = PayModel::where('order_id', $order['order_id'])->where('status', PaymentApi::PAYED)->first();
        //支付流水不存在,未实际支付,金额为0 允许实际未支付
        if (!$pay && $amount > 0) {
            return null;
        }
        $refund = [
            'club_id'     => $this->apply['club_id'],
            'order_id'    => $order['order_id'],
            'pay_flow'    => isset($pay['batch_no']) ? $pay['batch_no'] : '',
            'refund_flow' => self::getRefundFlowId(),
            'amount'      => $amount,
            'real_amount' => $amount,
            'status'      => $amount > 0 ? RefundApi::WAIT_ADUDIT : RefundApi::REFUND_SUCCESS,
        ];
        (new RefundModel($refund))->save();
        return $refund['refund_flow'];
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
}