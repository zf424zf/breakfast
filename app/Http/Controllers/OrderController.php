<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/8
 * Time: 下午9:43
 */

namespace App\Http\Controllers;

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
        return view('order.pay');
    }

    public function create()
    {
        if (!request('name')) {
            return [
                'error'   => 1,
                'message' => '请填写姓名',
            ];
        }
        if (!request('phone')) {
            return [
                'error'   => 1,
                'message' => '请填写联系电话',
            ];
        }
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
                        $price = $product['is_early'] ? $product['early_price'] : $product['coupon_price'];
                        $amount += $price * $num;
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