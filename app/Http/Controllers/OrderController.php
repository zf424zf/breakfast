<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/8
 * Time: 下午9:43
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Metro\Place as PlaceModel;
use App\Models\PickupTime as PickupTimeModel;
use App\Models\Product\Products as ProductModel;
use App\Http\Services\Product as ProductService;
use App\Http\Services\Coupon as CouponService;
use App\Http\Services\Order as OrderService;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function index()
    {
        return view('order.index');
    }

    public function pay()
    {
        if (!request('order_ids')) {
            abort(404);
        }
        $orders = (new OrderService)->details(explode(',', request('order_ids')));
        return view('order.pay', ['orders' => $orders]);
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
                            $order = new OrderService();
                            $order->create(app('user')->id(), $date, $placeId, $pickuptimeId, $pickupData, $contact);
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
        ]);
    }
}