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
use App\Models\Order\Order as OrderModel;

class CartController extends Controller
{

    const SESSION_KEY = 'cart';

    public function __construct()
    {
        $this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function index($placeId = null)
    {
        //@todo $placeId = null 时从最近订单获取placeId
        if (is_null($placeId)) {
            $placeId = OrderModel::where('uid', app('user')->id())->orderBy('id', 'DSESC')->pluck('place_id')->first();
        }
        if (!$placeId) {
            return redirect(url('metro'));
        }
        //格式化日期信息
        $dateTimestamp = strtotime(request()->cookie('date', date('Ymd', time() + 86400)));
        $date = date('Ymd', $dateTimestamp);
        if (!$date) {
            abort(404);
        }
        //获取取货地点信息
        $place = $placeId ? PlaceModel::with('pickuptimes')->find($placeId) : null;
        //取货时间段 默认去第一个时间段,如果设置了cookie则以cookie信息为准
        $pickuptimes = $place->pickuptimes->keyBy('id')->toArray();
        $pickuptime = current($pickuptimes);
        if (request()->cookie('pickuptime') && isset($pickuptimes[request()->cookie('pickuptime')])) {
            $pickuptime = $pickuptimes[request()->cookie('pickuptime')];
        }
        //判断最后下单时间
        $isStop = false;
        $lastPurchaseTime = strtotime($date . ' ' . $pickuptime['start']) - $pickuptime['purchase_stop'] * 3600;
        if (time() > $lastPurchaseTime) {
            $isStop = true;
        }
        //日历计算
        $todayIndex = date('w');
        $start = strtotime("-{$todayIndex} day");
        $dates = [];
        $carts = session(self::SESSION_KEY);
        for ($i = 0; $i < 21; $i++) {
            $timestamp = $start + ($i * 86400);
            $dates[] = [
                'show'     => date('d', $timestamp),
                'date'     => date('Ymd', $timestamp),
                'selected' => array_get($carts, date('Ymd', $timestamp) . '.' . $placeId, []),
            ];
        }
        //@todo 按日期查询订单数据  显示下单情况
        $products = ProductService::gets([], $date, $placeId, $pickuptime['id']);
        //获取当前日期 当前取餐点  当前取餐时间段的购物车数据
        $cart = array_get($carts, $date . '.' . $placeId . '.' . $pickuptime['id'], []);
        return view('cart', [
            'dates'       => $dates,
            'place'       => $place,
            'date'        => $date,
            'pickuptimes' => $pickuptimes,
            'pickuptime'  => $pickuptime,
            'products'    => $products,
            'cart'        => $cart,
            'isStop'      => $isStop,
        ]);
    }

    public function lists()
    {
        $datas = session(self::SESSION_KEY, []);
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
        session([self::SESSION_KEY => $datas]);
        $productIds = array_unique($productIds);
        $products = ProductModel::available()->whereIn('id', $productIds)->get()->keyBy('id')->toArray();
        $pickuptimes = PickupTimeModel::all()->keyBy('id')->toArray();
        $places = PlaceModel::all()->keyBy('id')->toArray();
        $amount = 0;
        $originAmount = 0;
        foreach ($datas as $date => $dateData) {
            foreach ($dateData as $placeId => $placeData) {
                foreach ($placeData as $pickuptimeId => $pickupData) {
                    foreach ($pickupData as $productId => $num) {
                        $product = ProductService::isEarlyBird($products[$productId], $date, $pickuptimes[$pickuptimeId]);
                        $amount += $product['price'] * $num;
                        $originAmount += ($product['origin_price']) * $num;
                    }
                }
            }
        }
        return [
            'count'         => $count,
            'amount'        => round($amount, 2),
            'coupon_amount' => round($originAmount - $amount, 2),
            'html'          => view('cart_list', [
                'products'    => $products,
                'datas'       => $datas,
                'count'       => $count,
                'pickuptimes' => $pickuptimes,
                'places'      => $places,
            ])->__toString(),
        ];
    }

    public function add()
    {
        if (!request('date') ||
            request('count') === null ||
            !request('product_id') ||
            !request('pickuptime_id') ||
            !request('place_id')
        ) {
            return [
                'error'   => 1,
                'message' => '参数错误',
            ];
        }
        $data = session(self::SESSION_KEY, []);
        $product = current(ProductService::gets([], request('date'), request('place_id'), request('pickuptime_id')));
        var_dump($product);
        die;
        if (!$product['is_early'] &&
            $product['stock'] < request('count') &&
            request('is_add')
        ) {
            return [
                'error'   => 1,
                'message' => '库存不足,' . $product['name'] . '当前仅剩余库存' . $product['stock'],
            ];
        }
        if (request('count')) {
            $data[request('date')][request('place_id')][request('pickuptime_id')][request('product_id')] = request('count');
        } else {
            unset($data[request('date')][request('place_id')][request('pickuptime_id')][request('product_id')]);
        }

        session([self::SESSION_KEY => $data]);
        return [
            'error'   => 0,
            'message' => 'ok',
        ];
    }
}