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

class CartController extends Controller
{

    const SESSION_KEY = 'cart';

    public function __construct()
    {
        //$this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function index($placeId = null)
    {
        $todayIndex = date('w');
        $start = strtotime("-{$todayIndex} day");
        $dates = [];
        $carts = session(self::SESSION_KEY);
        for ($i = 0; $i < 21; $i++) {
            $timestamp = $start + ($i * 86400);
            $dates[] = [
                'show'     => date('d', $timestamp),
                'date'     => date('Ymd', $timestamp),
                'selected' => array_get($carts, date('Ymd', $timestamp), []),
            ];
        }
        $place = $placeId ? PlaceModel::find($placeId) : null;
        //获取周
        $dateTimestamp = strtotime(request('date', date('Ymd')));
        $date = date('Ymd', $dateTimestamp);
        if (!$date) {
            abort(404);
        }
        $pickuptimes = PickupTimeModel::all()->keyBy('id')->toArray();
        $pickuptime = current($pickuptimes);
        if (request()->cookie('pickuptime_id') && isset($pickuptimes[request()->cookie('pickuptime_id')])) {
            $pickuptime = $pickuptimes[request()->cookie('pickuptime_id')];
        }
        $weekday = date('w', $dateTimestamp) + 1;
        $products = ProductModel::available()->whereHas('saledays', function ($query) use ($weekday) {
            $query->where('weekday', $weekday);
        })->whereHas('pickuptimes', function ($query) use ($pickuptime) {
            $query->where('pickuptime_id', $pickuptime['id']);
        });
        if ($placeId) {
            $products->whereHas('places', function ($query) use ($placeId) {
                $query->where('place_id', $placeId);
            });
        }
        $products = $products->get()->toArray();
        $cart = isset($carts[$date]) ? $carts[$date] : [];
        return view('cart', [
            'dates'       => $dates,
            'place'       => $place,
            'date'        => $date,
            'pickuptimes' => $pickuptimes,
            'products'    => $products,
            'cart'        => $cart,
        ]);
    }

    public function lists()
    {
        $datas = session(self::SESSION_KEY, []);
        //删除过期的时间数据
        foreach ($datas as $key => $data) {
            var_dump($key < date('Ymd'));
            if ($key < date('Ymd')) {
                unset($datas[$key]);
            }
        }
        ksort($datas);
        session([self::SESSION_KEY => $datas]);
        $count = 0;
        $productIds = [];
        foreach ($datas as $data) {
            $count += array_sum($data);
            $productIds = array_merge($productIds, array_keys($data));
        }
        $productIds = array_unique($productIds);
        $products = ProductModel::available()->whereIn('id', $productIds)->get()->keyBy('id')->toArray();
        return [
            'count' => $count,
            'html'  => view('cart_list', ['products' => $products, 'datas' => $datas, 'count' => $count])->__toString(),
        ];
    }

    public function add()
    {
        if (!request('date') || request('count') === null || !request('product_id')) {
            return [
                'error'   => 1,
                'message' => '参数错误',
            ];
        }
        $data = session(self::SESSION_KEY, []);
        if (request('count')) {
            $data[request('date')][request('product_id')] = request('count');
        } else {
            unset($data[request('date')][request('product_id')]);
        }

        session([self::SESSION_KEY => $data]);
        return [
            'error'   => 0,
            'message' => 'ok',
        ];
    }
}