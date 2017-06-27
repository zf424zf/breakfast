<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/8
 * Time: 下午9:43
 */

namespace App\Http\Controllers;

use App\Http\Services\Payment;
use Illuminate\Http\Request;
use App\Models\Metro\Place as PlaceModel;
use App\Models\PickupTime as PickupTimeModel;
use App\Models\Product\Products as ProductModel;
use App\Http\Services\Product as ProductService;
use App\Http\Services\Coupon as CouponService;
use App\Http\Services\Order as OrderService;
use App\Http\Services\Payment as PaymentService;
use App\Models\Order\Order as OrderModel;

class OrderController extends Controller
{

    protected $uid;

    public function __construct()
    {
        $this->middleware('wechat.userinfo', ['except' => 'notify']);
    }

    public function index()
    {
        //日历计算
        $todayIndex = date('w');
        $start = strtotime("-{$todayIndex} day");
        $dates = [];
        $carts = session(CartController::SESSION_KEY);
        for ($i = 0; $i < 21; $i++) {
            $timestamp = $start + ($i * 86400);
            $dates[] = [
                'show'     => date('d', $timestamp),
                'date'     => date('Ymd', $timestamp),
                'selected' => array_get($carts, date('Ymd', $timestamp), []),
            ];
        }
        //日历计算结束
        $orders = OrderModel::where('uid', app('user')->id())->orderBy('id', 'DESC')->get();
        return view('order.index', ['orders' => $orders, 'dates' => $dates]);
    }

    public function notify()
    {
        return app('wechat')->payment->handleNotify(function ($notify, $successful) {
            if ($successful) {
                $service = new Payment($notify->out_trade_no);
                $service->setPaid($notify->transaction_id);
            }
            return true; // 或者错误消息
        });
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 支付界面
     */
    public function pay()
    {
        if (!request('order_ids')) {
            abort(404);
        }
        $orders = (new OrderService)->details(explode(',', request('order_ids')));
        $coupon = CouponService::getMaxAmountCoupon(app('user')->id());
        return view('order.pay', ['orders' => $orders, 'coupon' => $coupon]);
    }

    /**
     * @return array
     * 实际支付
     */
    public function postPay()
    {
        if (!request('order_ids')) {
            abort(404);
        }
        $orderIds = explode(',', request('order_ids'));
        $orders = (new OrderService)->details($orderIds);
        foreach ($orders as $order) {
            if ($order['status'] != OrderService::WAITPAY) {
                return [
                    'error'   => 1,
                    'message' => $order['order_id'] . ' 处于不可支付状态',
                ];
            }
        }
        $amount = array_sum(array_column($orders, 'amount'));
        $coupon = CouponService::getMaxAmountCoupon(app('user')->id());
        if ($coupon) {
            $amount = $amount - $coupon['amount'];
        }
        $service = new PaymentService;
        $couponId = $coupon ? $coupon['id'] : 0;
        $config = $service->createFlow($orderIds, app('user')->id(), $amount, $couponId)->purchase(app('user')->openid())->getJSPaymentConfig();
        return [
            'error'   => 0,
            'message' => 'ok',
            'config'  => $config,
        ];
    }

    public function create(Request $request)
    {
        $datas = session(CartController::SESSION_KEY, []);
        if (!$datas) {
            return [
                'error'   => 1,
                'message' => '请先挑选您的商品',
            ];
        }
        $validator = app('validator')->make($request->only('name'), ['name' => 'required']);
        if ($validator->fails()) {
            return [
                'error'   => 1,
                'message' => '请填写姓名',
            ];
        }
        $validator = app('validator')->make($request->only('phone'), ['phone' => 'required|phone']);
        if ($validator->fails()) {
            return [
                'error'   => 1,
                'message' => '请填写正确的联系电话',
            ];
        }

        $contact = [
            'name'    => request('name'),
            'phone'   => request('phone'),
            'company' => request('company'),
        ];
        $orderIds = [];
        foreach ($datas as $date => $dateData) {
            foreach ($dateData as $placeId => $placeData) {
                foreach ($placeData as $pickuptimeId => $pickupData) {
                    if ($pickupData) {
                        try {
                            $batchNo = time();
                            $order = new OrderService();
                            $order->create(app('user')->id(), $date, $placeId, $pickuptimeId, $pickupData, $contact, $batchNo);
                            $orderIds[] = $order->getOrder()['order_id'];
                        } catch (\Exception $e) {
                            return ['error' => 1, 'message' => $e->getMessage()];
                        }
                    }
                }
            }
        }
        session([CartController::SESSION_KEY => []]);
        return ['error' => 0, 'message' => 'ok', 'order_ids' => $orderIds];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 确认订单
     */
    public function confirm()
    {
        $datas = session(CartController::SESSION_KEY, []);
        //删除过期的时间数据
        foreach ($datas as $key => $data) {
            if ($key < date('Ymd')) {
                unset($datas[$key]);
            }
        }
        ksort($datas);
        $count = 0;
        $productIds = [];
        $placeIds = [];
        foreach ($datas as $date => $dateData) {
            $count += array_sum(array_dot($dateData));
            foreach ($dateData as $placeId => $placeData) {
                $placeIds = array_merge($placeIds, array_keys($placeData));
                ksort($datas[$date][$placeId]);
                foreach ($placeData as $pickuptimeId => $pickupData) {
                    $productIds = array_merge($productIds, array_keys($pickupData));
                }
            }
        }
        session([CartController::SESSION_KEY => $datas]);
        $productIds = array_unique($productIds);
        $products = ProductModel::available()->whereIn('id', $productIds)->get()->keyBy('id')->toArray();
        $pickuptimes = PickupTimeModel::all()->keyBy('id')->toArray();
        $places = PlaceModel::all()->keyBy('id')->toArray();
        $amount = 0;
        $originAmount = 0;
        $orderCount = 0;
        foreach ($datas as $date => $dateData) {
            foreach ($dateData as $placeId => $placeData) {
                foreach ($placeData as $pickuptimeId => $pickupData) {
                    if ($pickupData) {
                        $orderCount++;
                    }
                    foreach ($pickupData as $productId => $num) {
                        $product = ProductService::isEarlyBird($products[$productId], $date, $pickuptimes[$pickuptimeId]);
                        $amount += $product['price'] * $num;
                        $originAmount += ($product['origin_price']) * $num;
                    }
                }
            }
        }
        $coupon = CouponService::getMaxAmountCoupon(app('user')->id());
        if ($coupon) {
            $amount = $amount - $coupon['amount'] > 0 ? $amount - $coupon['amount'] : 0;
        }
        $lastOrder = OrderModel::where('uid', app('user')->id())->orderBy('id', 'DESC')->first();
        return view('order.confirm', [
            'count'        => $count,
            'amount'       => round($amount, 2),
            'orderCount'   => $orderCount,
            'couponAmount' => round($originAmount - $amount, 2),
            'products'     => $products,
            'datas'        => $datas,
            'pickuptimes'  => $pickuptimes,
            'places'       => $places,
            'coupon'       => $coupon,
            'lastOrder'    => $lastOrder,
        ]);
    }
}